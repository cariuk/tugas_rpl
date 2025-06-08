<?php

use App\Http\Controllers\Shop\LandingPageController;
use App\Http\Controllers\Shop\ProductDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/product-detail/{productId}', [ProductDetailController::class, 'index'])->name('product-detail');
