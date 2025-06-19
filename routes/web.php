<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//rute semua orang
Route::get('/', function () {
    return view('welcome');
});

//rute user
Route::get('/home', function () {
    return view('user.home');
})->name('home');
Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');
Route::get('/settings', function () {
    return view('user.settings');
})->name('settings');
Route::get('/product', [UserController::class, 'showLibrary'])->name('product.library');
Route::get('/product/detail/{id}', [UserController::class, 'showDetail'])->name('product.detail');
Route::post('/cart/add/{id}', [UserController::class, 'addToCart'])->name('product.addToCart');
Route::get('/cart', [UserController::class, 'showCart'])->name('product.cart');



//rute admin
Route::middleware(['auth', 'role:0'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('orders');
    Route::get('/ratings', function () {
        return view('admin.ratings');
    })->name('ratings');

    //rute lain disini

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
