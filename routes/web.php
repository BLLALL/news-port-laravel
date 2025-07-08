<?php

// routes/web.php - Add this to your existing routes

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {})->name('test');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{article}', [ArticleController::class, 'show'])->name('news.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Newsletter routes
Route::prefix('newsletter')->name('newsletter.')->group(function () {
    // Subscribe to newsletter
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');

    // Unsubscribe from newsletter
    Route::get('/unsubscribe', [NewsletterController::class, 'showUnsubscribeForm'])->name('unsubscribe.form');
    Route::post('/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');

    // Email verification (for future use)
    Route::get('/verify/{token}', [NewsletterController::class, 'verify'])->name('verify');

    // Newsletter statistics (for admin/monitoring)
    Route::get('/stats', [NewsletterController::class, 'stats'])
        ->middleware(['auth', 'admin'])
        ->name('stats');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Categories with bulk action
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/reorder', [App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');

    Route::post('categories/bulk-action', [App\Http\Controllers\Admin\CategoryController::class, 'bulkAction'])->name('categories.bulk-action');

    // Articles
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);

    Route::post('/upload-image', [App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])->name('upload-image');

    Route::prefix('newsletter')->name('newsletter.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('index');
        Route::get('/export', [App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('export');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\NewsletterController::class, 'bulkAction'])->name('bulk-action');
    });
});

Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('index');
    Route::get('/settings', [App\Http\Controllers\Admin\NewsletterController::class, 'settings'])->name('settings');
    Route::get('/export', [App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('export');
    Route::post('/bulk-action', [App\Http\Controllers\Admin\NewsletterController::class, 'bulkAction'])->name('bulk-action');
    Route::post('/send-test', [App\Http\Controllers\Admin\NewsletterController::class, 'sendTestNewsletter'])->name('send-test');
    Route::post('/send-article', [App\Http\Controllers\Admin\NewsletterController::class, 'sendNewsletterForArticle'])->name('send-article');
});

Route::get('/send-direct-newsletter', function () {
    try {
        $subscriber = \App\Models\NewsletterSubscription::where('email', 'bamer8353@gmail.com')->first();
        $article = \App\Models\Article::with(['author', 'categories'])->latest()->first();

        $notification = new \App\Notifications\NewArticleNewsletterNotification($article, $subscriber->email);

        $subscriber->notify($notification);

        return '✅ Newsletter sent directly! Check your email (including spam and promotions tab).';

    } catch (\Exception $e) {
        return '❌ Error: '.$e->getMessage();
    }
})->middleware('auth');

require __DIR__.'/auth.php';
