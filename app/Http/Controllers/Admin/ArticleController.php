<?php

// app/Http/Controllers/Admin/ArticleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Services\NewsletterEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    protected $newsletterEmailService;

    public function __construct(NewsletterEmailService $newsletterEmailService)
    {
        $this->newsletterEmailService = $newsletterEmailService;
    }

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

        $article->load(['author', 'categories']);

        // Check if newsletter should be sent (default: true)
        $sendNewsletter = $request->input('send_newsletter', true);
        $newsletterMessage = '';

        if ($sendNewsletter) {
            try {
                // Send newsletter using the service
                $newsletterSent = $this->newsletterEmailService->sendNewArticleNewsletter($article);

                if ($newsletterSent) {
                    $newsletterMessage = ' Newsletter has been queued and will be sent to subscribers shortly.';

                    Log::info('Newsletter queued for article', [
                        'article_id' => $article->id,
                        'article_title' => $article->title,
                        'author_id' => auth()->id(),
                    ]);
                } else {
                    $newsletterMessage = ' However, the newsletter could not be sent. Please check the logs.';
                }
            } catch (\Exception $e) {
                $newsletterMessage = ' However, there was an error sending the newsletter: '.$e->getMessage();

                Log::error('Error sending newsletter for article', [
                    'article_id' => $article->id,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            $newsletterMessage = ' Newsletter was not sent as requested.';
        }

        // 4. SUCCESS RESPONSE - Enhanced with newsletter status
        $successMessage = 'Article "'.$article->title.'" created successfully!'.$newsletterMessage;

        return redirect()->route('admin.articles.index')->with('success', $successMessage);
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

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Generate unique filename
                $filename = time().'_'.$file->getClientOriginalName();

                // Store in public storage under uploads/editor
                $path = $file->storeAs('uploads/editor', $filename, 'public');

                // Return TinyMCE expected response format
                return response()->json([
                    'location' => asset('storage/'.$path),
                ]);
            }

            return response()->json(['error' => 'No file uploaded'], 400);

        } catch (\Exception $e) {
            Log::error('TinyMCE image upload failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'file_size' => $request->hasFile('file') ? $request->file('file')->getSize() : 0,
                'file_type' => $request->hasFile('file') ? $request->file('file')->getMimeType() : null,
            ]);

            return response()->json(['error' => 'Upload failed'], 500);
        }
    }
}
