<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Technology',
            'color' => '#4A90E2',
        ]);

        Category::create([
            'name' => 'PHP',
            'color' => '#E94E77',
            'parent_id' => 1,
        ]);

        Category::create([
            'name' => 'Laravel',
            'color' => '#FFCA28',
            'parent_id' => 2,
        ]);

        Category::create([
            'name' => 'JavaScript',
            'color' => '#F39C12',
            'parent_id' => 1,
        ]);
    }
}