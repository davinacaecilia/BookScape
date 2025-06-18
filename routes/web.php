<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logined', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    // auth
    Route::get('/home', [UserController::class, 'showHome'])->name('home');
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // admin views
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('admin.orders');
    Route::get('/message', [AdminController::class, 'listMessage'])->name('admin.message');  
    //product management
    Route::get('/product-management', [AdminController::class, 'listProduct'])->name('product.management');
    Route::get('/product-management/create', [AdminController::class, 'addProduct'])->name('product.create');
    Route::post('/product-management/store', [AdminController::class, 'storeProduct'])->name('product.store');
    Route::get('/product-management/edit/{id}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::put('/product-management/update/{id}', [AdminController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product-management/delete/{id}', [AdminController::class, 'deleteProduct'])->name('product.destroy');
    // user management
    Route::get('/user-management', [AdminController::class, 'listUsers'])->name('user.management');
});

//Route untuk list produk di hlmn user (punya jeilta)
Route::get('/produk', function () {
    return view('produk');
})->name('produk');



