<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ImageController::class, 'index'])->name('home');
Route::get('/image/{image}', [ImageController::class, 'show'])->name('image.show');
Route::get('/upload', [ImageController::class, 'create'])->name('image.upload');


Route::get('/profile', function () {
    return Inertia::render('Profile');
})->name('profile');


require __DIR__.'/auth.php';