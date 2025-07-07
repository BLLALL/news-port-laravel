<?php

// config/newsletter.php

return [

    /*
    |--------------------------------------------------------------------------
    | Newsletter Enabled
    |--------------------------------------------------------------------------
    |
    | This option controls whether the newsletter system is enabled.
    | When disabled, no newsletter emails will be sent.
    |
    */

    'enabled' => env('NEWSLETTER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Auto Send on Article Creation
    |--------------------------------------------------------------------------
    |
    | When enabled, newsletters will be automatically sent when new articles
    | are created (unless explicitly disabled for that article).
    |
    */

    'auto_send_on_creation' => env('NEWSLETTER_AUTO_SEND', true),

    /*
    |--------------------------------------------------------------------------
    | Newsletter Sending Delay
    |--------------------------------------------------------------------------
    |
    | Delay in minutes before sending newsletter after article creation.
    | This allows time for last-minute edits before the newsletter goes out.
    | Set to 0 for immediate sending.
    |
    */

    'send_delay_minutes' => env('NEWSLETTER_SEND_DELAY', 0),

    /*
    |--------------------------------------------------------------------------
    | Maximum Daily Newsletters
    |--------------------------------------------------------------------------
    |
    | Maximum number of newsletter emails that can be sent per day.
    | This prevents overwhelming subscribers with too many emails.
    | Set to 0 for unlimited.
    |
    */

    'max_daily_newsletters' => env('NEWSLETTER_MAX_DAILY', 3),

    /*
    |--------------------------------------------------------------------------
    | Quiet Hours
    |--------------------------------------------------------------------------
    |
    | Hours during which newsletters should not be sent automatically.
    | Uses 24-hour format. Newsletters will be queued until after quiet hours.
    |
    */

    'quiet_hours' => [
        'start' => env('NEWSLETTER_QUIET_START', 22), // 10 PM
        'end' => env('NEWSLETTER_QUIET_END', 8),     // 8 AM
    ],

    /*
    |--------------------------------------------------------------------------
    | Required Categories
    |--------------------------------------------------------------------------
    |
    | If specified, only articles with these category slugs will trigger
    | automatic newsletters. Leave empty to send for all categories.
    |
    */

    'required_categories' => [
        // 'breaking-news',
        // 'important-updates',
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Categories
    |--------------------------------------------------------------------------
    |
    | Articles with these category slugs will never trigger newsletters.
    |
    */

    'excluded_categories' => [
        // 'draft',
        // 'internal',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for newsletter emails
    |
    */

    'email' => [
        'from_name' => env('NEWSLETTER_FROM_NAME', env('APP_NAME')),
        'from_email' => env('NEWSLETTER_FROM_EMAIL', env('MAIL_FROM_ADDRESS')),
        'reply_to' => env('NEWSLETTER_REPLY_TO', env('MAIL_FROM_ADDRESS')),
        'subject_prefix' => env('NEWSLETTER_SUBJECT_PREFIX', '📰'),
        'include_unsubscribe_link' => true,
        'include_web_version_link' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Batch Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for sending newsletters in batches
    |
    */

    'batch' => [
        'size' => env('NEWSLETTER_BATCH_SIZE', 50),
        'delay_between_batches' => env('NEWSLETTER_BATCH_DELAY', 100), // milliseconds
        'max_attempts' => env('NEWSLETTER_MAX_ATTEMPTS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for newsletter content
    |
    */

    'content' => [
        'excerpt_length' => 200,
        'include_categories' => true,
        'include_author' => true,
        'include_publish_date' => true,
        'include_featured_image' => false, // Set to true when implementing
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | Configuration for testing newsletters
    |
    */

    'testing' => [
        'test_mode' => env('NEWSLETTER_TEST_MODE', false),
        'test_email' => env('NEWSLETTER_TEST_EMAIL', 'test@example.com'),
        'log_only' => env('NEWSLETTER_LOG_ONLY', false), // Only log, don't send
    ],

];
