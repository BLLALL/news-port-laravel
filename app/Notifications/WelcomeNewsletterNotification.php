<?php

namespace App\Notifications;

use App\Models\NewsletterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNewsletterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct(NewsletterSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $unsubscribeUrl = route('newsletter.unsubscribe.form', ['email' => $this->subscription->email]);

        return (new MailMessage)
            ->subject('Welcome to '.config('app.name').' Newsletter!')
            ->greeting('Welcome to our newsletter!')
            ->line('Thank you for subscribing to '.config('app.name').' newsletter.')
            ->line('You\'ll receive the latest news, updates, and exclusive content directly in your inbox.')
            ->line('Here\'s what you can expect:')
            ->line('• Latest breaking news and stories')
            ->line('• Weekly roundups of important events')
            ->line('• Exclusive insights and analysis')
            ->line('• Special announcements and updates')
            ->action('Visit Our Website', route('home'))
            ->line('If you have any questions or feedback, feel free to reach out to us.')
            ->line('You can unsubscribe at any time by clicking the link below.')
            ->action('Unsubscribe', $unsubscribeUrl)
            ->line('Thank you for joining our community!')
            ->salutation('Best regards, The '.config('app.name').' Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'email' => $this->subscription->email,
            'source' => $this->subscription->source,
        ];
    }
}
