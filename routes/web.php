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

// Super Admin routes - require super_admin role only
Route::middleware(['auth', 'verified', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\SuperAdmin\Dashboard::class)->name('dashboard');
    Route::get('/users', \App\Livewire\SuperAdmin\Users::class)->name('users');
    Route::get('/cities', \App\Livewire\SuperAdmin\Cities::class)->name('cities');
    Route::get('/categories', \App\Livewire\SuperAdmin\Categories::class)->name('categories');
    Route::view('/subscriptions', 'superadmin.subscriptions')->name('subscriptions');
    Route::get('/helps', \App\Livewire\SuperAdmin\Helps::class)->name('helps');
    Route::get('/verifications', \App\Livewire\SuperAdmin\Verifications::class)->name('verifications');
});

// Admin routes - require admin role only (for moderasi)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/helps', \App\Livewire\Admin\Helps\Index::class)->name('helps');
    Route::get('/verifications', \App\Livewire\Admin\Verifications\Index::class)->name('verifications');
});

require __DIR__ . '/auth.php';