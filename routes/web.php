<?php

use Illuminate\Support\Facades\Route;

// Landing/Welcome page (for guest)
Route::view('/welcome', 'welcome')->name('welcome');

// Public routes - Home page with helps listing
Route::view('/', 'home')->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard route - redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        } elseif ($user->role === 'super_admin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Default: redirect to customer dashboard
        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    // Chat shortcut routes (open a specific conversation)
    Route::get('/chat/start', [\App\Http\Controllers\ChatController::class, 'start'])->name('chat.start');
    Route::get('/chat/{help}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');

    // ========================================
    // CUSTOMER ROUTES (Kustomer/Penerima Bantuan)
    // ========================================
    Route::prefix('customer')->name('customer.')->middleware('kustomer')->group(function () {
        // Dashboard
        Route::get('/dashboard', \App\Livewire\Customer\Dashboard::class)->name('dashboard');

        // Helps Management
        Route::get('/helps', \App\Livewire\Customer\Helps\Index::class)->name('helps.index');
        Route::get('/helps/create', \App\Livewire\Customer\Helps\Create::class)->name('helps.create');

        // Notifications
        Route::get('/notifications', \App\Livewire\Customer\Notifications\Index::class)->name('notifications.index');

        // Balance & Transactions
        // Route untuk balance management bisa ditambahkan di sini
        Route::get('/transactions', \App\Livewire\Customer\Transactions\Index::class)->name('transactions.index');

        // Top Up Saldo (Livewire component)
        Route::get('/top-up', \App\Livewire\Customer\Topup::class)->name('topup');

        // Chat (optional help id for opening detail directly)
        Route::get('/chat/{help?}', \App\Livewire\Customer\Chat::class)->name('chat');
    });

    // ========================================
    // MITRA ROUTES (Volunteer/Pemberi Bantuan)
    // ========================================
    Route::prefix('mitra')->name('mitra.')->middleware('mitra')->group(function () {
        // Dashboard
        Route::get('/dashboard', \App\Livewire\Mitra\Dashboard\Index::class)->name('dashboard');

        // Helps Management
        Route::get('/helps', \App\Livewire\Mitra\Helps\AllHelps::class)->name('helps.all');
        Route::get('/helps/completed', \App\Livewire\Mitra\Helps\CompletedHelps::class)->name('helps.completed');
        Route::get('/help/{id}', \App\Livewire\Mitra\Helps\HelpDetail::class)->name('help.detail');

        // Profile
        Route::get('/profile', \App\Livewire\Mitra\Profile\Index::class)->name('profile');

        // Chat (optional help id for opening detail directly)
        Route::get('/chat/{help?}', \App\Livewire\Mitra\Chat\Index::class)->name('chat');

        // Processing helps (in-progress) - page for mitra to manage helps they are currently handling
        Route::get('/helps/processing', \App\Livewire\Mitra\Helps\ProcessingHelps::class)->name('helps.processing');

        // Ratings
        Route::get('/ratings', \App\Livewire\Mitra\Ratings\Index::class)->name('ratings');
    });

    // ========================================
    // SHARED ROUTES (Accessible by both)
    // ========================================
    // Profile Management (accessible by all authenticated users)
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/profile/edit', 'profile.edit')->name('profile.edit');
    Route::view('/profile/settings', 'profile.settings')->name('profile.settings');
    Route::view('/profile/settings/notifications', 'profile.settings.notifications')->name('profile.settings.notifications');
    Route::view('/profile/settings/password', 'profile.settings.password')->name('profile.settings.password');

    Route::put('/profile/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('status', 'Password updated successfully!');
    })->name('profile.password.update');

    Route::delete('/profile', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        \Illuminate\Support\Facades\Auth::logout();
        $user->delete();

        return redirect('/')->with('status', 'Account deleted successfully!');
    })->name('profile.delete');
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

// ========================================
// MIDTRANS PAYMENT ROUTES (Public - No Auth)
// ========================================
Route::prefix('topup')->name('topup.')->group(function () {
    Route::get('/finish', [\App\Http\Controllers\TopupController::class, 'finish'])->name('finish');
    Route::get('/unfinish', [\App\Http\Controllers\TopupController::class, 'unfinish'])->name('unfinish');
    Route::get('/error', [\App\Http\Controllers\TopupController::class, 'error'])->name('error');
    Route::post('/notification', [\App\Http\Controllers\TopupController::class, 'notification'])->name('notification');
});

require __DIR__ . '/auth.php';