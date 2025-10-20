<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/upload', function () {
    return Inertia::render('Upload');
})->name('upload');

Route::get('/profile', function () {
    return Inertia::render('Profile');
})->name('profile');

Route::get('/logout', function () {
    return Inertia::render('Home');
})->name('logout');