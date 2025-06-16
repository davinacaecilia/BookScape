<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/product-management', function () {
    return view('product.product-management');
});
Route::get('/admin/ratings', function () {
    return view('admin.ratings'); 
})->name('admin.ratings');
Route::get('/orders', function () {
    return view('admin.orders');
});
Route::get('/users', function () {
    return view('admin.user-management');
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
// Route detail order baru
Route::get('/orders/{id}', function ($id) {
    // nanti di sini bisa ambil data order sesuai $id dari DB kalau sudah backend
    return view('admin.detail-order', ['orderId' => $id]);
})->name('orders.detail');
// Reply Message 
Route::get('/admin/reply-message', function () {
    return view('admin.reply-message');
})->name('reply.form');



