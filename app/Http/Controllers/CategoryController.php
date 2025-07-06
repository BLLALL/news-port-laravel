<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('articles')->get();
        $categoryTree = (new Category)->buildTree($categories);

        return view('home', ['categoryTree' => $categoryTree]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

     public function show(Category $category, Request $request)
    {
        // Get all categories for the tree structure
        $allCategories = Category::with('articles')->get();
        $categoryTree = Category::buildTree($allCategories);
        
        // Simple approach: just get articles directly attached to this category
        $query = Article::with(['author', 'categories'])
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->latest('created_at'); // or published_at if you have that column
            
        // Add search functionality if search parameter exists
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        // Paginate results
        $articles = $query->paginate(12)->withQueryString();
        
        // Get subcategories with article counts
        $subcategories = $category->children()->with('articles')->get();
        
        // Get category path (breadcrumbs)
        $categoryPath = $this->getCategoryPath($category);
        
        return view('categories.show', compact(
            'category', 
            'articles', 
            'subcategories', 
            'categoryTree',
            'categoryPath'
        ));
    }
    
    /**
     * Get the category path for breadcrumbs
     */
    private function getCategoryPath(Category $category)
    {
        $path = collect([$category]);
        $current = $category;
        
        while ($current->parent) {
            $current = $current->parent;
            $path->prepend($current);
        }
        
        return $path;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}