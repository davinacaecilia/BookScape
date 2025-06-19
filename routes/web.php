<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//rute semua orang
Route::get('/', function () {
    return view('welcome');
});

//rute bawaan breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//rute user
Route::get('/cart', function () {
    return view('produk.cart');
});

//rute admin
Route::middleware(['auth', 'role:0'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    //rute lain disini

});

require __DIR__ . '/auth.php';
