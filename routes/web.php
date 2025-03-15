<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');})->name('welcome'); //function () {return view('welcome');} Was route naar welcome

Route::middleware('auth', 'verified', 'isBlocked')->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/products/myProducts', [ProductController::class, 'showPendingProducts'])->middleware(['auth', 'verified'])->name('showPendingProducts');
});

Route::delete('products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy')
    ->middleware(['auth', 'verified', 'isBlocked', 'adminOrProductOwner']);

Route::get('/blocked', [UserController::class, 'blocked'])->name('blocked');

Route::middleware('auth', 'verified', 'isBlocked')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class) //moet weg
    ->only(['index', 'store', 'edit', 'update', 'destroy'])//moet weg
    ->middleware(['auth', 'verified']);//moet weg

Route::resource('reviews', ReviewController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware(['auth', 'verified', 'isBlocked']);

Route::resource('products', ProductController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified', 'isBlocked']);

Route::middleware('auth', 'verified', 'isBlocked')->group(function () {
    Route::post('/products/{product}/loan', [ProductController::class, 'loan'])->name('products.loan');
    Route::post('/products/{product}/return', [ProductController::class, 'return'])->name('products.return');
    Route::post('/products/{product}/accept', [ProductController::class, 'accept'])->name('products.accept');
});

Route::middleware('auth', 'verified', 'isAdmin')->group(function () {
    Route::post('/users/{user}/blockUser', [UserController::class, 'blockUser'])->name('users.blockUser');
    Route::post('/users/{user}/unblockUser', [UserController::class, 'unblockUser'])->name('users.unblockUser');
});
require __DIR__.'/auth.php';
