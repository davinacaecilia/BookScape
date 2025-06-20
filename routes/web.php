<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//rute semua orang
Route::get('/', function () {
    return view('welcome');
});

//rute user
Route::middleware(['auth', 'role:1'])->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/home', [UserController::class, 'showHome'])->name('home');

    Route::get('/product', [UserController::class, 'showLibrary'])->name('product.library');
    Route::get('/product/detail/{id}', [UserController::class, 'showDetail'])->name('product.detail');

    Route::post('/cart/add/{id}', [UserController::class, 'addToCart'])->name('product.addToCart');
    Route::get('/cart', [UserController::class, 'showCart'])->name('product.cart');
    Route::post('/cart/update-quantity', [UserController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/delete', [UserController::class, 'deleteCart'])->name('cart.delete');
    Route::post('/cart/delete-selected', [UserController::class, 'deleteSelectedCart'])->name('cart.deleteSelected');
    Route::post('/cart/checkout', [UserController::class, 'checkout'])->name('cart.checkout');

    Route::post('/order/place', [UserController::class, 'placeOrder'])->name('order.place');
    Route::post('/checkout', [UserController::class, 'checkoutNow'])->name('order.checkout');
    Route::get('/payment/{order}', [UserController::class, 'showPaymentPage'])->name('order.payment');
    Route::post('/payment/{order}/upload-proof', [UserController::class, 'uploadPaymentProof'])->name('payment.uploadProof');

    Route::get('/history', [UserController::class, 'showHistory'])->name('order.history');
    Route::get('/rating/{buku}', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/ratings/{buku}', [RatingController::class, 'store'])->name('ratings.store');
});


//rute admin
Route::middleware(['auth', 'role:0'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('orders');
    Route::get('/ratings', [AdminController::class, 'showRatingsAndReviews'])->name('ratings');
    Route::get('/product-management', [AdminController::class, 'listProduct'])->name('product.management');
    Route::get('/user-management', [AdminController::class, 'listUsers'])->name('user.management');

    // CRUD Products
    Route::get('/products/create', [AdminController::class, 'addProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/product-edit/{id}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::put('/product-update/{id}', [AdminController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product-delete/{id}', [AdminController::class, 'deleteProduct'])->name('product.destroy');
});

Route::middleware(['auth', 'role:0'])->group(function () {

    Route::get('/product-management', [AdminController::class, 'listProduct'])->name('product.management');
    Route::get('/user-management', [AdminController::class, 'listUsers'])->name('user.management');
    Route::get('/product-create', [AdminController::class, 'addProduct'])->name('product.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('product.store');
    Route::get('/product-edit/{id}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::put('/product-update/{id}', [AdminController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product-delete/{id}', [AdminController::class, 'deleteProduct'])->name('product.destroy');

    // Jika ada rute lain yang polanya sama, bisa ditambahkan di sini
});

require __DIR__ . '/auth.php';
