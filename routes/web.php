<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

// public routes
Route::get('/', [ImageController::class, 'index'])->name('home'); // images
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index'); // albums

// resourced resources
Route::resource('album', AlbumController::class)->middleware(['auth', 'verified'])->except(['index', 'show']);
Route::resource('image', ImageController::class)->middleware(['auth', 'verified'])->except(['index', 'show']);


// these need to come last
Route::get('/image/{image}', [ImageController::class, 'show'])->name('image.show');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');

require __DIR__.'/auth.php';