<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\KoleksiBukuController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Models\CategoryBook;
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
    Route::post('/pinjam/{id}', [UserDashboardController::class, 'pinjam'])->name('pinjam-buku');
    Route::get('/history', [UserDashboardController::class, 'history'])->name('history');
    Route::post('/kembalikan/{id}', [UserDashboardController::class, 'return'])->name('kembalikan-buku');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('update-profile');
});

// Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('koleksi-buku', KoleksiBukuController::class)->except(['create', 'edit']);
    Route::resource('category', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('users', UsersController::class)->except(['show', 'create', 'edit']);
});


// Fallback
Route::fallback(function () {
    return redirect()->route('home');
});
