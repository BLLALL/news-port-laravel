<?php

namespace App\Services;

use App\Jobs\SendNewsletterJob;
use App\Models\Article;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Log;

class NewsletterEmailService
{
    /**
     * Send newsletter for new article
     */
    public function sendNewArticleNewsletter(Article $article, array $options = []): bool
    {
        // Check if newsletter sending is enabled
        if (! $this->isNewsletterEnabled()) {
            Log::info('Newsletter sending is disabled', ['article_id' => $article->id]);

            return false;
        }

        // Check if article should trigger newsletter
        if (! $this->shouldSendNewsletterForArticle($article)) {
            Log::info('Article does not meet newsletter criteria', [
                'article_id' => $article->id,
                'article_title' => $article->title,
            ]);

            return false;
        }

        // Get subscriber count for logging
        $subscriberCount = NewsletterSubscription::active()->verified()->count();

        if ($subscriberCount === 0) {
            Log::info('No active subscribers for newsletter', ['article_id' => $article->id]);

            return false;
        }

        try {
            // Dispatch the newsletter job
            if (isset($options['delay'])) {
                SendNewsletterJob::dispatch($article)->delay($options['delay']);
            } else {
                SendNewsletterJob::dispatch($article);
            }

            Log::info('Newsletter job dispatched successfully', [
                'article_id' => $article->id,
                'subscriber_count' => $subscriberCount,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to dispatch newsletter job', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Check if newsletter sending is enabled
     */
    private function isNewsletterEnabled(): bool
    {
        // You can add a setting in your config or database
        return config('newsletter.enabled', true);
    }

    /**
     * Determine if article should trigger newsletter
     */
    private function shouldSendNewsletterForArticle(Article $article): bool
    {
        if (empty($article->title) || empty($article->content)) {
            return false;
        }

        // Check if article was just created (within last 5 minutes)
        if ($article->created_at->diffInMinutes(now()) > 5) {
            Log::info('Article too old for newsletter', [
                'article_id' => $article->id,
                'created_at' => $article->created_at,
                'minutes_old' => $article->created_at->diffInMinutes(now()),
            ]);

            return false;
        }

        return true;
    }

    /**
     * Get newsletter statistics
     */
    public function getNewsletterStats(): array
    {
        return [
            'total_subscribers' => NewsletterSubscription::count(),
            'active_subscribers' => NewsletterSubscription::active()->count(),
            'verified_subscribers' => NewsletterSubscription::active()->verified()->count(),
            'unverified_subscribers' => NewsletterSubscription::active()->where('email_verified_at', null)->count(),
            'newsletter_enabled' => $this->isNewsletterEnabled(),
        ];
    }

    /**
     * Send test newsletter
     */
    public function sendTestNewsletter(Article $article, string $testEmail): bool
    {
        try {
            // Create a simple notification target for test email
            $notifiable = new class($testEmail)
            {
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

            $notifiable->notify(new \App\Notifications\NewArticleNewsletterNotification($article, $testEmail));

            Log::info('Test newsletter sent successfully', [
                'article_id' => $article->id,
                'test_email' => $testEmail,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send test newsletter', [
                'article_id' => $article->id,
                'test_email' => $testEmail,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send immediate newsletter (bypass normal checks)
     */
    public function sendImmediateNewsletter(Article $article): bool
    {
        try {
            SendNewsletterJob::dispatchNow($article);

            Log::info('Immediate newsletter sent', [
                'article_id' => $article->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send immediate newsletter', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Schedule newsletter for later
     */
    public function scheduleNewsletter(Article $article, \DateTime $sendAt): bool
    {
        try {
            $delay = $sendAt->getTimestamp() - now()->getTimestamp();

            if ($delay <= 0) {
                return $this->sendImmediateNewsletter($article);
            }

            SendNewsletterJob::dispatch($article)->delay($delay);

            Log::info('Newsletter scheduled', [
                'article_id' => $article->id,
                'send_at' => $sendAt->format('Y-m-d H:i:s'),
                'delay_seconds' => $delay,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to schedule newsletter', [
                'article_id' => $article->id,
                'send_at' => $sendAt->format('Y-m-d H:i:s'),
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
