<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Homecontroller;
use App\Http\Controllers\ProfileController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logined', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/registered', [RegisterController::class, 'register']);
Route::get('/home', [HomeController::class,'home'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

});

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


Route::get('/product', function () {
    return view('produk.new');
});


Route::get('/preview', function () {
    return view('produk.preview');
});

Route::get('/cart', function () {
    return view('produk.cart');
});

Route::get('/history', function () {
    return view('produk.history');
});

Route::get('/rating', function () {
    return view('produk.rating');
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
