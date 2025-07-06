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
        $allCategories = Category::with('articles')->get();
        $categoryTree = Category::buildTree($allCategories);

        $selectedCategories = $request->input('categories', []);

        $query = Article::with(['author', 'categories'])
            ->latest('created_at');

        if (! empty($selectedCategories)) {
            if (! is_array($selectedCategories)) {
                $selectedCategories = [$selectedCategories];
            }

            $categoryIds = [];
            foreach ($selectedCategories as $catId) {
                $categoryIds[] = $catId;
                $descendantIds = $this->categoryService->getDescendantsIds($allCategories, $catId);
                $categoryIds = array_merge($categoryIds, $descendantIds);
            }

            $categoryIds = array_unique($categoryIds);

            log::info('Selected categories IDs:', ['ids' => $categoryIds]);
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        $latestNews = $query->take(12)->get();

        Log::info('Number of articles found:', ['count' => $latestNews->count()]);

        return view('home', [
            'categoryTree' => $categoryTree,
            'latestNews' => $latestNews,
            'selectedCategories' => $selectedCategories,
        ]);
    }
}
