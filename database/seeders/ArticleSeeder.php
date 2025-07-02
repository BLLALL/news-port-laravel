<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create articles and automatically attach to category hierarchy
        $this->createArticleWithCategories(
            'PHP 8.4 is out',
            'PHP 8.4 was released on November 21, 2024. It includes new features like property hooks, asymmetric visibility, and new array functions. There were also some deprecations and removals.',
            1, // author_id
            'PHP' // Most specific category - will auto-attach to parents
        );

        $this->createArticleWithCategories(
            'Building Modern Laravel Applications',
            'Laravel continues to be the most popular PHP framework. In this article, we explore the latest features and best practices for building modern web applications.',
            1,
            'Laravel'
        );

        $this->createArticleWithCategories(
            'JavaScript ES2024 Features',
            'ECMAScript 2024 brings exciting new features to JavaScript. Let\'s explore what\'s new and how it affects modern web development.',
            1,
            'JavaScript'
        );

        $this->createArticleWithCategories(
            'The Future of Web Development',
            'Technology is evolving rapidly. This article covers the trends shaping the future of web development across all technologies.',
            1,
            'Technology'
        );
    }

    /**
     * Create an article and attach it to a category and all its parents
     */
    private function createArticleWithCategories(string $title, string $content, int $authorId, string $categoryName): Article
    {
        $article = Article::create([
            'title' => $title,
            'content' => $content,
            'author_id' => $authorId,
        ]);

        // Find the category by name
        $category = Category::where('name', $categoryName)->first();
        
        if ($category) {
            // Get all parent categories
            $categoriesToAttach = $this->getCategoryHierarchy($category);
            
            // Attach to all categories in the hierarchy
            $article->categories()->attach($categoriesToAttach->pluck('id'));
        }

        return $article;
    }

    /**
     * Get a category and all its parents up to the root
     */
    private function getCategoryHierarchy(Category $category): \Illuminate\Support\Collection
    {
        $hierarchy = collect([$category]);
        $current = $category;
        
        while ($current->parent) {
            $current = $current->parent;
            $hierarchy->push($current);
        }
        
        return $hierarchy;
    }
}