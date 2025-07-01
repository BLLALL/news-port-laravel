<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

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

        $query = Article::with('author', 'categories')->latest();
        if (! empty($selectedCategories)) {
            $categoryIds = [];
            foreach ($selectedCategories as $catId) {
                $categoryIds[] = $catId;
                $descendantIds = $this->categoryService->getDescendantsIds($allCategories, $catId);
                $categoryIds = array_merge($categoryIds, $descendantIds);
            }

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', array_unique($categoryIds));
            });
        }

        $latestNews = $query->take(12)->get();

        return view('home', [
            'categoryTree' => $categoryTree,
            'latestNews' => $latestNews,
            'selectedCategories' => $selectedCategories,
        ]);

    }
}
