<?php
// routes/web.php - Add this to your existing routes

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {})->name('test');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{article}', [ArticleController::class, 'show'])->name('news.show'); 
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';