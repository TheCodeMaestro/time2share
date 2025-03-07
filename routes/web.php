<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/products/myProducts', [ProductController::class, 'showPendingProducts'])->middleware(['auth', 'verified'])->name('showPendingProducts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('reviews', ReviewController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('products', ProductController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

Route::delete('products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy')
    ->middleware(['auth', 'verified', 'AdminOrProductOwner']);

Route::post('/products/{product}/loan', [ProductController::class, 'loan'])->name('products.loan');
Route::post('/products/{product}/return', [ProductController::class, 'return'])->name('products.return');
Route::post('/products/{product}/accept', [ProductController::class, 'accept'])->name('products.accept');

require __DIR__.'/auth.php';
