<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Homecontroller;

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

