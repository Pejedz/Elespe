<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('items', ItemController::class)->except(['show']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::get('transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');

    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('/cart', [PosController::class, 'addToCart'])->name('cart.add');
        Route::patch('/cart/{item}', [PosController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/{item}', [PosController::class, 'removeFromCart'])->name('cart.remove');
        Route::get('/checkout', [PosController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [PosController::class, 'processCheckout'])->name('checkout.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
