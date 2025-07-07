<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class NewsletterSubscription extends Model
{
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Generate a verification token for the subscription
     */
    public function generateVerificationToken(): string
    {
        $token = Str::random(64);
        $this->update(['verification_token' => $token]);

        return $token;
    }

    /**
     * Mark the email as verified
     */
    public function markEmailAsVerified(): bool
    {
        return $this->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for verified subscriptions
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Scope for unverified subscriptions
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    /**
     * Get subscription by email
     */
    public static function findByEmail(string $email): ?self
    {
        return static::where('email', $email)->first();
    }

    /**
     *Check if email is already subscribed
     */
    public static function isSubscribed(string $email): bool
    {
        return static::where('email', $email)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Unsubscribe by email
     */
    public static function unsubscribeByEmail(string $email): bool
    {
        return static::where('email', $email)->update(['is_active' => false]);
    }
}
