<?php

use App\Http\Controllers\Api\ArticleApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/articles', [ArticleApiController::class, 'index']);
    Route::get('/articles/{slug}', [ArticleApiController::class, 'show']);
    Route::get('/categories', [ArticleApiController::class, 'categories']);
    Route::get('/footer', [ArticleApiController::class, 'footer']);
    Route::get('/preview/{id}', [ArticleApiController::class, 'preview']);
});