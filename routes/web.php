<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImageController::class, 'index'])->name('home');
Route::get('/image/{image}', [ImageController::class, 'show'])->name('image.show');

Route::resource('/album', AlbumController::class)->middleware('auth')->except(['index', 'show']);

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/image/{image}/edit', [ImageController::class, 'edit'])->name('image.edit');
    Route::patch('/image/{image}', [ImageController::class, 'update'])->name('image.update');
    Route::delete('/image/{image}', [ImageController::class, 'destroy'])->name('image.destroy');
    Route::get('/upload', [ImageController::class, 'create'])->name('image.create');
    Route::post('/upload', [ImageController::class, 'store'])->name('image.store');
});

require __DIR__.'/auth.php';