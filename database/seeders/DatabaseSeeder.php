<?php

// database/seeders/DatabaseSeeder.php (replace existing)

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Seed categories first (they have relationships between themselves)
        $this->call([
            CategorySeeder::class,
            ArticleSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@example.com / password');
        $this->command->info('User login: john@example.com / password');
    }
}
