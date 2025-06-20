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
    Route::get('/home', function () {
        return view('user.home');
    })->name('home');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cart', function () {
        return view('produk.cart');
    });
    Route::get('/history', function () {
        return view('produk.history');
    });
    Route::get('/new', function () {
        return view('produk.new');
    });
    Route::get('/order-cart', function () {
        return view('produk.order-cart');
    });
    Route::get('/order-now', function () {
        return view('produk.order-now');
    });
    Route::get('/payment', function () {
        return view('produk.payment');
    });
    Route::get('/preview', function () {
        return view('produk.preview');
    });
    Route::get('/rating/{buku}', [RatingController::class, 'create'])->name('rating.create');
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
