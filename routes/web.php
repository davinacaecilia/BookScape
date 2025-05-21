<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\ProductController;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Homecontroller;

//Route untuk dashboard admin (punya anggun)
Route::get('login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/product-management', function () {
    return view('product.product-management');
});
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
Route::delete('/product/{id}/delete', function ($id) {
    // Tempat untuk delete data dari database nanti
    // return redirect()->route('product.management')->with('success', 'Product deleted!');
})->name('product.destroy');

// User Mnagement
Route::get('/user-management', [AdminController::class, 'listUsers']);


//Route untuk homepage user (punya putri)
Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::post('/login', [LandingController::class, 'login'])->name('login');
// Route::post('/logout', [LandingController::class, 'logout'])->name('logout');
Route::get('/register', [LandingController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LandingController::class, 'register']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/home', [HomeController::class,'home'])->name('home');

//Route untuk list produk di hlmn user (punya jeilta)
Route::get('/produk', function () {
    return view('produk');
})->name('produk');
