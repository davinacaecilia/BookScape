<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/new', function () {
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
