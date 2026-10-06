<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman beranda
Route::get('/', [ProductController::class, 'home'])->name('home');

// Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Keranjang
Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{product}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{product}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// Checkout & pesanan
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
