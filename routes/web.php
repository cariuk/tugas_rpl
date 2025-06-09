<?php

use App\Http\Controllers\Shop\LandingPageController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/products', [ProductController::class, 'get'])->name('products');
Route::get('/product-detail/{productId}', [ProductController::class, 'index'])->name('product-detail');
