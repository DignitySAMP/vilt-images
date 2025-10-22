<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

// images
Route::get('/', [ImageController::class, 'index'])->name('home');

// albums
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');

// resourced resources
Route::resource('album', AlbumController::class)->middleware('auth')->except(['index', 'show']);
Route::resource('image', ImageController::class)->middleware('auth')->except(['index', 'show']);

Route::get('/image/{image}', [ImageController::class, 'show'])->name('image.show');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');

require __DIR__.'/auth.php';