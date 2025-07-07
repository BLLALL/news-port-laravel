<?php

namespace App\Services;

use App\Models\NewsletterSubscription;
use App\Notifications\WelcomeNewsletterNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NewsletterService
{
    private const DISPOSABLE_DOMAINS = [
        '10minutemail.com', 'tempmail.org', 'guerrillamail.com',
        'mailinator.com', 'throwaway.email', 'temp-mail.org',
        'getnada.com', 'maildrop.cc', 'sharklasers.com',
        'grr.la', 'guerrillamailblock.com', 'pokemail.net',
        'spam4.me', 'bccto.me', 'chacuo.net', 'dispostable.com',
    ];

    public function subscribe(string $email, array $options = []): NewsletterSubscription
    {
        $email = strtolower(trim($email));

        // Validate email
        $this->validateEmail($email);

        // Check if already subscribed and active
        $existingSubscription = NewsletterSubscription::findByEmail($email);

        if ($existingSubscription && $existingSubscription->is_active) {
            throw ValidationException::withMessages([
                'email' => 'This email is already subscribed to our newsletter.',
            ]);
        }

        // Prepare subscription data
        $data = array_merge([
            'email' => $email,
            'source' => 'website',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $options);

        if ($existingSubscription) {
            $existingSubscription->update([
                'is_active' => true,
                'source' => $data['source'],
                'ip_address' => $data['ip_address'],
                'user_agent' => $data['user_agent'],
                'email_verified_at' => null, // Reset verification
                'verification_token' => null,
            ]);
            $subscription = $existingSubscription;
        } else {
            $subscription = NewsletterSubscription::create($data);
        }
        // for now, mark as verified
        $subscription->markEmailAsVerified();

        // Send welcome email
        $this->sendWelcomeEmail($subscription);

        Log::info('Newsletter subscription created', [
            'email' => $email,
            'source' => $data['source'],
            'ip' => $data['ip_address'],
        ]);

        return $subscription;
    }

    /**
     * Unsubscribe an email from the newsletter
     */
    public function unsubscribe(string $email): bool
    {
        $email = strtolower(trim($email));

        $subscription = NewsletterSubscription::findByEmail($email);

        if (! $subscription) {
            throw ValidationException::withMessages([
                'email' => 'Email address not found in our subscription list.',
            ]);
        }

        $result = $subscription->update(['is_active' => false]);

        Log::info('Newsletter unsubscription', [
            'email' => $email,
            'ip' => request()->ip(),
        ]);

        return $result;
    }

    /**
     * Validate email address
     */
    private function validateEmail(string $email): void
    {
        $validator = Validator::make(['email' => $email], [
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Check for disposable email domains
        $domain = substr(strrchr($email, '@'), 1);
        if (in_array($domain, self::DISPOSABLE_DOMAINS)) {
            throw ValidationException::withMessages([
                'email' => 'Please use a permanent email address.',
            ]);
        }

        // Additional domain validation
        if (! $this->isValidDomain($domain)) {
            throw ValidationException::withMessages([
                'email' => 'Please enter a valid email address.',
            ]);
        }
    }

    /**
     * Check if domain is valid
     */
    private function isValidDomain(string $domain): bool
    {
        // Basic domain validation
        if (! filter_var($domain, FILTER_VALIDATE_DOMAIN)) {
            return false;
        }

        if (function_exists('getmxrr')) {
            $mxRecords = [];

            return getmxrr($domain, $mxRecords) && ! empty($mxRecords);
        }

        return true;
    }

    /**
     * Send welcome email
     */
    private function sendWelcomeEmail(NewsletterSubscription $subscription): void
    {
        try {
            // Create a simple notification target
            $notifiable = new class($subscription->email)
            {
                use Notifiable;

                public $email;

                public function __construct($email)
                {
                    $this->email = $email;
                }

                public function routeNotificationForMail()
                {
                    return $this->email;
                }
            };

            $subscription->notify(new WelcomeNewsletterNotification($subscription));

            Log::info('Welcome email sent for newsletter subscription', [
                'email' => $subscription->email,
                'subscription_id' => $subscription->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email for newsletter subscription', [
                'email' => $subscription->email,
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);
            // Don't throw exception here as the subscription was successful
        }
    }
}
