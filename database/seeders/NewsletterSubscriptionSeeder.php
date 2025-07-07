<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create sample newsletter subscriptions
        $sources = ['website', 'footer', 'popup', 'social_media', 'referral'];
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (Android 11; Mobile; rv:91.0) Gecko/91.0',
        ];

        // Create 100 newsletter subscriptions with varied dates
        for ($i = 0; $i < 100; $i++) {
            $isActive = $faker->boolean(85); // 85% chance of being active
            $createdAt = $faker->dateTimeBetween('-6 months', 'now');
            $hasVerifiedEmail = $faker->boolean(90); // 90% chance of being verified

            NewsletterSubscription::create([
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => $hasVerifiedEmail ? $createdAt : null,
                'verification_token' => $hasVerifiedEmail ? null : \Illuminate\Support\Str::random(64),
                'is_active' => $isActive,
                'preferences' => $faker->boolean(30) ? [
                    'categories' => $faker->randomElements(['tech', 'business', 'health', 'sports'], $faker->numberBetween(1, 3)),
                    'frequency' => $faker->randomElement(['daily', 'weekly', 'monthly']),
                ] : null,
                'source' => $faker->randomElement($sources),
                'ip_address' => $faker->ipv4(),
                'user_agent' => $faker->randomElement($userAgents),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        // Create some recent subscriptions (last 7 days)
        for ($i = 0; $i < 15; $i++) {
            $createdAt = $faker->dateTimeBetween('-7 days', 'now');

            NewsletterSubscription::create([
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => $createdAt,
                'verification_token' => null,
                'is_active' => true,
                'preferences' => null,
                'source' => $faker->randomElement($sources),
                'ip_address' => $faker->ipv4(),
                'user_agent' => $faker->randomElement($userAgents),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        // Create some unsubscribed users
        for ($i = 0; $i < 10; $i++) {
            $createdAt = $faker->dateTimeBetween('-3 months', '-1 month');
            $unsubscribedAt = $faker->dateTimeBetween($createdAt, 'now');

            NewsletterSubscription::create([
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => $createdAt,
                'verification_token' => null,
                'is_active' => false,
                'preferences' => null,
                'source' => $faker->randomElement($sources),
                'ip_address' => $faker->ipv4(),
                'user_agent' => $faker->randomElement($userAgents),
                'created_at' => $createdAt,
                'updated_at' => $unsubscribedAt,
            ]);
        }

        $this->command->info('Newsletter subscriptions seeded successfully!');
        $this->command->info('Total subscriptions: '.NewsletterSubscription::count());
        $this->command->info('Active subscriptions: '.NewsletterSubscription::active()->count());
        $this->command->info('Verified subscriptions: '.NewsletterSubscription::verified()->count());
    }
}
