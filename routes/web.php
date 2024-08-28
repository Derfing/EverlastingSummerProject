<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('endpoints/create', 'endpoints_create')
    ->middleware(['auth', 'verified'])
    ->name('endpoints.create');

Route::view('endpoints/edit/{id}', 'endpoints_edit')
    ->middleware(['auth', 'verified'])
    ->name('endpoints.edit');

Route::view('endpoints', 'endpoints')
    ->middleware(['auth', 'verified'])
    ->name('endpoints');

Route::view('objects', 'objects')
    ->middleware(['auth', 'verified'])
    ->name('objects');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
