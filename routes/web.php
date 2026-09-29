<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama: belum login -> ke login, sudah login -> ke dashboard admin.
// Nama 'blog.index' dipertahankan supaya view lama yang memanggilnya tidak error.
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
})->name('blog.index');

Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/articles/{article}/preview', [ArticleController::class, 'preview'])->name('articles.preview');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('articles', ArticleController::class)->except(['show']);
});

require __DIR__.'/auth.php';

// Catch-all harus paling bawah agar tidak menimpa /login, /admin, dll.
Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');