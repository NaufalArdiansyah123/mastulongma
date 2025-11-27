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
    // CUSTOMER ROUTES (Customer/Penerima Bantuan)
    // ========================================
    Route::prefix('customer')->name('customer.')->middleware('customer')->group(function () {
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

        // Reports
        Route::get('/reports/create', \App\Livewire\Customer\Reports\Create::class)->name('reports.create');
        Route::get('/reports/create/user/{user_id}', \App\Livewire\Customer\Reports\Create::class)->name('reports.create.user');
        Route::get('/reports/create/help/{help_id}', \App\Livewire\Customer\Reports\Create::class)->name('reports.create.help');
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
        // Edit profile page for mitra (full page, not modal)
        Route::get('/profile/edit', \App\Livewire\Mitra\Profile\EditPage::class)->name('profile.edit');

        // Chat (optional help id for opening detail directly)
        Route::get('/chat/{help?}', \App\Livewire\Mitra\Chat\Index::class)->name('chat');

        // Reports
        Route::get('/reports/create', \App\Livewire\Mitra\Reports\Create::class)->name('reports.create');
        Route::get('/reports/create/user/{user_id}', \App\Livewire\Mitra\Reports\Create::class)->name('reports.create.user');
        Route::get('/reports/create/help/{help_id}', \App\Livewire\Mitra\Reports\Create::class)->name('reports.create.help');
        // Show a submitted report (mitra can view their own submitted report status)
        Route::get('/reports/{report}', function (\App\Models\PartnerReport $report) {
            // simple ownership check: only reporter or admin can view; mitra middleware ensures auth
            if ($report->reporter_id !== auth()->id()) {
                abort(403);
            }
            return view('livewire.mitra.reports.show', ['report' => $report]);
        })->name('reports.show');

        // Processing helps (in-progress) - page for mitra to manage helps they are currently handling
        Route::get('/helps/processing', \App\Livewire\Mitra\Helps\ProcessingHelps::class)->name('helps.processing');

        // Ratings
        Route::get('/ratings', \App\Livewire\Mitra\Ratings\Index::class)->name('ratings');

        // Withdraw (Mitra) - form & history
        Route::get('/withdraw', [\App\Http\Controllers\WithdrawController::class, 'showForm'])->name('withdraw.form');
        Route::post('/withdraw', [\App\Http\Controllers\WithdrawController::class, 'requestWithdraw'])->name('withdraw.request');
        Route::get('/withdraw/history', [\App\Http\Controllers\WithdrawController::class, 'withdrawHistory'])->name('withdraw.history');
        Route::get('/withdraw/success/{withdraw}', [\App\Http\Controllers\WithdrawController::class, 'showSuccess'])->name('withdraw.success');
        Route::get('/withdraw/rejected/{withdraw}', [\App\Http\Controllers\WithdrawController::class, 'showRejected'])->name('withdraw.rejected');
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

    // Withdraw management (Admin)
    Route::get('/withdraws', [\App\Http\Controllers\Admin\AdminWithdrawController::class, 'index'])->name('withdraws.index');
    // Modal endpoint to load withdraw details into a modal (AJAX)
    Route::get('/withdraws/{withdraw}/modal', [\App\Http\Controllers\Admin\AdminWithdrawController::class, 'modal'])->name('withdraws.modal');
    Route::get('/withdraws/{withdraw}', [\App\Http\Controllers\Admin\AdminWithdrawController::class, 'show'])->name('withdraws.show');
    Route::post('/withdraws/{withdraw}/approve', [\App\Http\Controllers\Admin\AdminWithdrawController::class, 'approve'])->name('withdraws.approve');
    Route::post('/withdraws/{withdraw}/reject', [\App\Http\Controllers\Admin\AdminWithdrawController::class, 'reject'])->name('withdraws.reject');

    // Users management (Admin area)
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');

    // Partners activity and exports
    Route::get('/partners/activity', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'index'])->name('partners.activity');
    Route::get('/partners/activity/export/csv', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'exportCsv'])->name('partners.activity.export.csv');
    Route::get('/partners/activity/export/excel', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'exportExcel'])->name('partners.activity.export.excel');
    Route::get('/partners/activity/export/print', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'exportPrint'])->name('partners.activity.export.print');
    Route::post('/partners/activity/{user}/reset-sessions', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'resetSessions'])->name('partners.activity.reset_sessions');
    Route::post('/partners/activity/{user}/reset-password', [\App\Http\Controllers\Admin\PartnerActivityController::class, 'resetPassword'])->name('partners.activity.reset_password');

    // Partner reports and summaries
    Route::get('/partners/report', [\App\Http\Controllers\Admin\PartnerReportController::class, 'index'])->name('partners.report');
    Route::get('/partners/reports', [\App\Http\Controllers\Admin\PartnerReportController::class, 'reportsIndex'])->name('partners.reports');
    Route::get('/partners/reports/{report}', [\App\Http\Controllers\Admin\PartnerReportController::class, 'show'])->name('partners.reports.show');
    Route::post('/partners/reports/{report}/status', [\App\Http\Controllers\Admin\PartnerReportController::class, 'updateStatus'])->name('partners.reports.update');
    Route::post('/partners/reports/{report}/add-note', [\App\Http\Controllers\Admin\PartnerReportController::class, 'addNote'])->name('partners.reports.add-note');
    Route::post('/partners/reports/{report}/resolve', [\App\Http\Controllers\Admin\PartnerReportController::class, 'resolve'])->name('partners.reports.resolve');
    Route::post('/partners/reports/{report}/reopen', [\App\Http\Controllers\Admin\PartnerReportController::class, 'reopen'])->name('partners.reports.reopen');

    // Blocked partners
    Route::get('/partners/blocked', [\App\Http\Controllers\Admin\BlockedPartnerController::class, 'index'])->name('partners.blocked');
    Route::post('/partners/blocked/{id}/toggle', [\App\Http\Controllers\Admin\BlockedPartnerController::class, 'toggle'])->name('partners.blocked.toggle');
    // Backwards-compatible toggle route used by views: route('admin.partners.toggle', $id)
    Route::post('/partners/toggle/{id}', [\App\Http\Controllers\Admin\BlockedPartnerController::class, 'toggle'])->name('partners.toggle');
});

// ========================================
// MIDTRANS PAYMENT ROUTES (Public - No Auth)
// ========================================
Route::prefix('topup')->name('topup.')->group(function () {
    Route::get('/finish', [\App\Http\Controllers\TopupController::class, 'finish'])->name('finish');
    Route::get('/unfinish', [\App\Http\Controllers\TopupController::class, 'unfinish'])->name('unfinish');
    Route::get('/error', [\App\Http\Controllers\TopupController::class, 'error'])->name('error');
    Route::get('/success', [\App\Http\Controllers\TopupController::class, 'success'])->name('success');
    Route::post('/notification', [\App\Http\Controllers\TopupController::class, 'notification'])->name('notification');
    // Client-side callback (AJAX) used to notify server immediately when Snap reports success
    Route::post('/client-callback', [\App\Http\Controllers\TopupController::class, 'clientCallback'])->name('client-callback');
});

// Public callback endpoint used by payment gateway integrations for withdraw disbursements
Route::post('/gateway/callback', [\App\Http\Controllers\WithdrawController::class, 'gatewayCallback'])->name('gateway.callback');

require __DIR__ . '/auth.php';