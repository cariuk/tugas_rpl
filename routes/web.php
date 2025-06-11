<?php

use App\Http\Controllers\Shop\LandingPageController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\PengirimanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/products', [ProductController::class, 'get'])->name('products');
Route::get('/product-detail/{productId}', [ProductController::class, 'index'])->name('product-detail');
Route::get('/product-pengiriman/get-lokasi', [PengirimanController::class, 'getLokasi'])->name('products-pengiriman.lokasi');
Route::get('/product-pengiriman/domestic-cost', [PengirimanController::class, 'getDomesticCost'])->name('products-pengiriman.domestic-cost');
Route::get('/product-pengiriman/{productId}', [PengirimanController::class, 'index'])->name('products-pengiriman');
