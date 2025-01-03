<?php

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
});

// Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UsersController::class)->except(['show', 'create', 'edit']);
});


// Fallback
Route::fallback(function () {
    return redirect()->route('home');
});
