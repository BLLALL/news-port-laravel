<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{


    public function dashboard()
    {
        $stats = [
            'total_articles' => Article::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'recent_articles' => Article::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $recentArticles = Article::with(['author', 'categories'])
            ->latest()
            ->take(5)
            ->get();

        $popularCategories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'popularCategories'));
    }
}