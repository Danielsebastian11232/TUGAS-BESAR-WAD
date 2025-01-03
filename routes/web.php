<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\KoleksiBukuController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'postLogin']);
    Route::post('/register', [AuthController::class, 'postRegister']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [UserDashboardController::class, 'home'])->name('home');
    Route::get('/detail/{id}', [UserDashboardController::class, 'detail'])->name('detail');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('koleksi-buku', KoleksiBukuController::class)->except(['create', 'edit']);
    Route::resource('users', UsersController::class)->except(['show', 'create', 'edit']);
    Route::resource('category', CategoryController::class)->except(['show', 'create', 'edit']);
});


// Fallback
Route::fallback(function () {
    return redirect()->route('home');
});
