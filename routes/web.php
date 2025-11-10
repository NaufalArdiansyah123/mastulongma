<?php

use Illuminate\Support\Facades\Route;

// Landing/Welcome page (for guest)
Route::view('/welcome', 'welcome')->name('welcome');

// Public routes - Home page with helps listing
Route::view('/', 'home')->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Helps routes
    Route::view('/helps', 'helps.index')->name('helps.index');
    Route::view('/helps/create', 'helps.create')->middleware('kustomer')->name('helps.create');
    Route::view('/helps/available', 'helps.index')->middleware('mitra')->name('helps.available');

    // Profile routes
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/profile/edit', 'profile')->name('profile.edit');
});

require __DIR__ . '/auth.php';
