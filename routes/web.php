<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController; // Ditambahkan dari main

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Homecontroller;
use App\Http\Controllers\ProfileController;

Route::get('login', function () {
    return view('login');
});

Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::post('/login', [LandingController::class, 'login'])->name('login');
// Route::post('/logout', [LandingController::class, 'logout'])->name('logout');
Route::get('/register', [LandingController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LandingController::class, 'register']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/home', [HomeController::class,'home'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

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
