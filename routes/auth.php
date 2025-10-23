<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // authentication
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    
    // registration
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    // password management
    Route::get('forgot-pass', [ResetPasswordController::class, 'create'])->name('forgot.password');
    Route::post('forgot-pass/send', [ResetPasswordController::class, 'store'])->name('forgot.password.store');
    Route::get('reset-pass', [ResetPasswordController::class, 'edit'])->name('reset.password');
    Route::post('reset-pass/edit', [ResetPasswordController::class, 'update'])->name('reset.password.edit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});