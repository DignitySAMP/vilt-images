<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ImageController::class, 'index'])->name('home');

Route::get('/upload', function () {
    return Inertia::render('Upload');
})->name('upload');

Route::get('/profile', function () {
    return Inertia::render('Profile');
})->name('profile');


require __DIR__.'/auth.php';