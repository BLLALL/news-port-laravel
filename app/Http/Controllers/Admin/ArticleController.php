<?php
// app/Http/Controllers/Admin/ArticleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'categories'])->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->only(['title', 'content']); 
        $data['author_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article = Article::create($data);
        $article->categories()->attach(array_unique($request->categories));

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $article->load('categories');
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);


        $data = $request->only(['title', 'content']); // Only get allowed fields

        if ($request->hasFile('image')) {
            if ($article->image) {
                \Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);
        $article->categories()->sync(array_unique($request->categories));

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            \Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully!');
    }
}