<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// トップページを表示
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボードを求人一覧にリダイレクト
Route::redirect('/dashboard', '/jobs')->name('dashboard');

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    // 求人関連のルート
    Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{jobListing}', [JobListingController::class, 'show'])->name('jobs.show');

    // お気に入り関連のルート
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{jobListing}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{jobListing}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::patch('/favorites/{jobListing}/comment', [FavoriteController::class, 'updateComment'])->name('favorites.comment');

    // プロフィール関連のルート（Breezeデフォルト）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証関連のルート（Laravel Breeze）
require __DIR__.'/auth.php';
