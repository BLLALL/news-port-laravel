<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('articles');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Parent filter
        if ($request->has('parent') && $request->parent !== '') {
            if ($request->parent === 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent);
            }
        }

        $categories = $query->with('parent')->latest()->paginate(15)->withQueryString();
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    public function create()
    {
        // Get all categories ordered by hierarchy (root categories first, then their children)
        $parentCategories = Category::orderBy('parent_id')
            ->orderBy('name')
            ->get();
            
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'articles']);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)
            ->orderBy('parent_id')
            ->orderBy('name')
            ->get();
        
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notIn([$category->id])
            ],
        ]);

        if ($validated['parent_id']) {
            $descendants = $category->getAllDescendants();
            $descendantIds = $descendants->pluck('id')->toArray();
            
            if (in_array($validated['parent_id'], $descendantIds)) {
                return back()->withErrors(['parent_id' => 'Cannot make a descendant category the parent (would create circular reference).'])->withInput();
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Automatically handle subcategories by moving them up one level
        if ($category->children()->exists()) {
            // Move all children to the parent of the current category (or null if no parent)
            $category->children()->update(['parent_id' => $category->parent_id]);
        }

        // Detach articles (don't delete articles, just remove the relationship)
        if ($category->articles()->exists()) {
            $category->articles()->detach();
        }

        // Delete the category
        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$categoryName}' deleted successfully! Subcategories have been moved up one level.");
    }
}
