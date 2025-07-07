<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewArticleNewsletterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $article;

    public $unsubscribeUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article, string $subscriberEmail)
    {
        $this->article = $article;
        $this->unsubscribeUrl = route('newsletter.unsubscribe.form', ['email' => $subscriberEmail]);
    }

    /**
     * Get the notification's delivery channels.
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
        $articleUrl = route('news.show', $this->article);
        $excerpt = $this->getArticleExcerpt();

        $mailMessage = (new MailMessage)
            ->subject('📰 New Article: '.$this->article->title)
            ->greeting('Hello!')
            ->line('We have a new article that we think you\'ll find interesting.')
            ->line('**'.$this->article->title.'**')
            ->line($excerpt);

        // Add categories if available
        if ($this->article->categories->count() > 0) {
            $categories = $this->article->categories->pluck('name')->join(', ');
            $mailMessage->line('**Categories:** '.$categories);
        }

        // Add author info
        $mailMessage->line('**By:** '.$this->article->author->name);

        // Add published date
        $mailMessage->line('**Published:** '.$this->article->created_at->format('F j, Y'));

        $mailMessage
            ->action('Read Full Article', $articleUrl)
            ->line('Thank you for being a subscriber to '.config('app.name').'!')
            ->line('---')
            ->line('Don\'t want to receive these emails? You can unsubscribe at any time.')
            ->action('Unsubscribe', $this->unsubscribeUrl)
            ->salutation('Best regards, The '.config('app.name').' Team');

        return $mailMessage;
    }

    /**
     * Get article excerpt for email
     */
    private function getArticleExcerpt(): string
    {
        $content = strip_tags($this->article->content);
        $excerpt = Str::limit($content, 200);

        return $excerpt;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'article_url' => route('news.show', $this->article),
            'sent_at' => now(),
        ];
    }
}
