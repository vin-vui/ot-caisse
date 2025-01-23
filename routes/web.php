<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);

    Route::get( 'ventes',                   [SellController::class, 'list'])            ->name('ventes');
    Route::get( 'nouvelle-vente/{article}', [SellController::class, 'create'])          ->name('create');
    Route::post('addtosale/{article}',      [SellController::class, 'store'])           ->name('addtosale');
    Route::get( 'caisse',                   [SellController::class, 'index'])           ->name('dashboard');
    Route::post('addtocart',                [SellController::class, 'addToCart'])       ->name('addtocart');
    Route::post('updatecart',               [SellController::class, 'updateCart'])      ->name('updatecart');
    Route::post('confirmpurchase',          [SellController::class, 'confirmPurchase']) ->name('confirmPurchase');
    Route::get( 'panier',                   [SellController::class, 'cart'])            ->name('cart');

    // Route::delete('/cart/remove/{article}', [SellController::class, 'removeFromCart'])->name('removeFromCart');
});
