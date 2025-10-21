<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImageController::class, 'index'])->name('home');
Route::get('/image/{image}', [ImageController::class, 'show'])->name('image.show');
Route::get('/image/{image}/edit', [ImageController::class, 'edit'])->name('image.edit');
Route::patch('/image/{image}', [ImageController::class, 'update'])->name('image.update');
Route::delete('/image/{image}', [ImageController::class, 'destroy'])->name('image.destroy');
Route::get('/upload', [ImageController::class, 'create'])->middleware('auth')->name('image.create');
Route::post('/upload', [ImageController::class, 'store'])->middleware('auth')->name('image.store');

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/album/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('/album', [AlbumController::class, 'store'])->name('album.store');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/album/{album}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::patch('/album/{album}', [AlbumController::class, 'update'])->name('album.update');
Route::delete('/album/{album}', [AlbumController::class, 'destroy'])->name('album.destroy');

require __DIR__.'/auth.php';