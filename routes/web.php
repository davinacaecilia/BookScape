<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
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

