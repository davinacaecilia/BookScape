<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController; // Ditambahkan dari main

use Illuminate\Support\Facades\Route;

// Rute Publik / Guest
Route::get('/', [LandingController::class, 'index'])->name('landing'); // Dari main
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Grup Rute yang Membutuhkan Otentikasi
Route::middleware('auth')->group(function () {
    // Rute Umum User (jika ada, dari main)
    Route::get('/home', [UserController::class, 'showHome'])->name('home');

    // Rute Admin Views & Fungsionalitas
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('admin.orders');
    Route::get('/message', [AdminController::class, 'listMessage'])->name('admin.message'); // Enih dah igun apus yh, soalnya fiturnya ganti jadi ratings
    
    // Rute Ratings
    Route::get('/admin/ratings', [AdminController::class, 'showRatingsAndReviews'])->name('admin.ratings'); // Ratings & Reviews
    Route::get('/orders/{id}', function ($id) {
        // nanti di sini bisa ambil data order sesuai $id dari DB kalau sudah backend
        return view('admin.detail-order', ['orderId' => $id]);
    })->name('orders.detail'); // Detail Order
    Route::get('/admin/reply-message', function () {
        return view('admin.reply-message');
    })->name('reply.form'); // Reply Message
    
    // Product Management (diambil dari main, karena sudah direfaktor ke AdminController)
    Route::get('/product-management', [AdminController::class, 'listProduct'])->name('product.management');
    Route::get('/product-management/create', [AdminController::class, 'addProduct'])->name('product.create');
    Route::post('/product-management/store', [AdminController::class, 'storeProduct'])->name('product.store');
    Route::get('/product-management/edit/{id}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::put('/product-management/update/{id}', [AdminController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product-management/delete/{id}', [AdminController::class, 'deleteProduct'])->name('product.destroy');
    
    // User Management (diambil dari main dan dilengkapi)
    Route::get('/user-management', [AdminController::class, 'listUsers'])->name('user.management');
    Route::put('/user-management/update/{id}', [AdminController::class, 'updateUser'])->name('user.update'); // Ditambahkan, karena ada methodnya di AdminController
    Route::delete('/user-management/delete/{id}', [AdminController::class, 'deleteUser'])->name('user.destroy'); // Ditambahkan, karena ada methodnya di AdminController

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Route untuk list produk di hlmn user (punya jeilta) - di luar middleware auth
Route::get('/produk', function () {
    return view('produk');
})->name('produk');