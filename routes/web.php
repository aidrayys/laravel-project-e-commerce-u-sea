<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProductController;
use Illuminate\Support\Facades\Route;

// Halaman statis
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

// Produk (customer-facing)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Seller authentication
Route::get('/seller/login', [SellerAuthController::class, 'showLogin'])->name('seller.login');
Route::post('/seller/login', [SellerAuthController::class, 'login'])->name('seller.login.submit');
Route::post('/seller/logout', [SellerAuthController::class, 'logout'])->name('seller.logout');

// Seller center (protected)
Route::middleware(['seller.auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/products', SellerProductController::class)->names('products');
});

// Keranjang
Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{product}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{product}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// Checkout & pesanan
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
