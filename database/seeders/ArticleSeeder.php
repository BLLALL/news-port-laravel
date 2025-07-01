<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = "PHP 8.4 was released on November 21, 2024. It includes new features like property hooks, asymmetric visibility, and new array functions. There were also some deprecations and removals.";
        Article::create([
            'title' => 'PHP 8.4 is out',
            'content' => $content,
            'author_id' => 1,
        ])->category()->attach([1, 2]);
    
        Article::create([
            'title' => 'Sample Article',
            'content' => 'This is a sample article content.',
            'author_id' => 1,
        ])->category()->attach([1, 2, 3]);
    }
}
