<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Homecontroller;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'showDashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});


//Route untuk dashboard admin (punya anggun)
Route::get('/message', function () {
    return view('admin.message');
});
Route::get('/orders', function () {
    return view('admin.orders');
});

// Ini Untuk Folder Product
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create'); // Add Product
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product-management', [ProductController::class, 'index'])->name('product.management');

Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Edit Product
Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update'); // buat update data

// Button Delete
Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    // Tempat untuk delete data dari database nanti
    // return redirect()->route('product.management')->with('success', 'Product deleted!');

// User Mnagement
Route::get('/user-management', [AdminController::class, 'listUsers']);

//Route untuk list produk di hlmn user (punya jeilta)
Route::get('/produk', function () {
    return view('produk');
})->name('produk');



