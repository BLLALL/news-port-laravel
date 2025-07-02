<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        // Get all categories with their articles for the tree
        $allCategories = Category::with('articles')->get();
        $categoryTree = Category::buildTree($allCategories);
        
        // Get selected categories from the request
        $selectedCategories = $request->input('categories', []);
        
        // Debug: Log the selected categories
        Log::info('Selected categories:', $selectedCategories);

        // Start building the articles query
        $query = Article::with(['author', 'categories'])
            ->latest('created_at'); // Using created_at since published_at might not exist yet

        // Apply category filtering if categories are selected
        if (!empty($selectedCategories)) {
            // Convert to array if it's a single value
            if (!is_array($selectedCategories)) {
                $selectedCategories = [$selectedCategories];
            }
            
            // Get all category IDs including descendants
            $categoryIds = [];
            foreach ($selectedCategories as $catId) {
                $categoryIds[] = $catId;
                // Get descendant categories (subcategories)
                $descendantIds = $this->categoryService->getDescendantsIds($allCategories, $catId);
                $categoryIds = array_merge($categoryIds, $descendantIds);
            }
            
            // Remove duplicates
            $categoryIds = array_unique($categoryIds);
            
            // Debug: Log the final category IDs
            Log::info('Final category IDs for filtering:', $categoryIds);

            // Filter articles by categories
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        // Get the latest news (limit to 12 for homepage)
        $latestNews = $query->take(12)->get();
        
        // Debug: Log the number of articles found
        Log::info('Number of articles found:', ['count' => $latestNews->count()]);

        return view('home', [
            'categoryTree' => $categoryTree,
            'latestNews' => $latestNews,
            'selectedCategories' => $selectedCategories,
        ]);
    }
}