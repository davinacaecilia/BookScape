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
    // dashboard
    Route::get('/dashboard', [UserController::class, 'showDashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // admin views
    Route::get('/message', fn() => view('admin.message'));
    Route::get('/orders', fn() => view('admin.orders'));

    // product management
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product-management', [ProductController::class, 'index'])->name('product.management');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    // user management
    Route::get('/user-management', [AdminController::class, 'listUsers']);
});

//Route untuk list produk di hlmn user (punya jeilta)
Route::get('/produk', function () {
    return view('produk');
})->name('produk');



