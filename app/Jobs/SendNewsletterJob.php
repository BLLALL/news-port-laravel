<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\NewsletterSubscription;
use App\Notifications\NewArticleNewsletterNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $article;

    public $timeout = 300; // 5 minutes timeout

    public $tries = 3; // Retry 3 times if failed

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting newsletter send for article', [
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
        ]);

        // Get all active and verified subscribers
        $subscribers = NewsletterSubscription::active()
            ->verified()
            ->select('email')
            ->get();

        if ($subscribers->isEmpty()) {
            Log::info('No active subscribers found for newsletter');

            return;
        }

        $successCount = 0;
        $errorCount = 0;

        // Send emails in chunks to avoid memory issues
        $subscribers->chunk(50)->each(function ($chunk) use (&$successCount, &$errorCount) {
            foreach ($chunk as $subscriber) {
                try {
                    // Create a simple notification target
                    $notifiable = new class($subscriber->email)
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

                    // Send the notification
                    $subscriber->notify(new NewArticleNewsletterNotification($this->article, $subscriber->email));
                    $successCount++;

                    // Small delay to avoid overwhelming the email service
                    usleep(100000); // 0.1 second delay

                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error('Failed to send newsletter email', [
                        'email' => $subscriber->email,
                        'article_id' => $this->article->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        });

        Log::info('Newsletter sending completed', [
            'article_id' => $this->article->id,
            'total_subscribers' => $subscribers->count(),
            'successful_sends' => $successCount,
            'failed_sends' => $errorCount,
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Newsletter job failed completely', [
            'article_id' => $this->article->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
