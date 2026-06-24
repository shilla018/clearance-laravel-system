<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SupportTicketController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ReportingController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');
require __DIR__.'/auth.php';
Route::view('/home', 'home')->name('public.home');
Route::view('/about', 'about')->name('about');
Route::get('/system-logo', fn () => response()->file(base_path('app/image.png')))->name('system.logo');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/payments', [DashboardController::class, 'payments'])->middleware('role:student')->name('payments.index');
    Route::get('/results', [DashboardController::class, 'results'])->middleware('role:student')->name('results.index');
    Route::get('/accommodation', [DashboardController::class, 'accommodation'])->middleware('role:student')->name('accommodation.index');
    Route::get('/library', [DashboardController::class, 'library'])->middleware('role:student')->name('library.index');
    Route::get('/clearance', [DashboardController::class, 'clearance'])->middleware('role:student')->name('clearance.index');
    Route::post('/clearance', [DashboardController::class, 'submitClearance'])->middleware('role:student')->name('clearance.submit');
    Route::post('/clearance/{application}/resubmit', [DashboardController::class, 'resubmitClearance'])->middleware('role:student')->name('clearance.resubmit');
    Route::get('/applications', [DashboardController::class, 'applications'])->middleware('role:admin,clearance_admin,officer')->name('applications.index');
    Route::get('/applications/{application}', [DashboardController::class, 'showApplication'])->middleware('role:admin,clearance_admin,officer')->name('applications.show');
    Route::post('/applications/{application}/reviews/{review}', [DashboardController::class, 'reviewApplication'])->middleware('role:officer')->name('applications.review');
    Route::get('/statistics', [DashboardController::class, 'statistics'])->middleware('role:admin,clearance_admin')->name('statistics.index');
    Route::get('/reports/clearance.csv', [DashboardController::class, 'exportClearanceReport'])->middleware('role:admin,clearance_admin')->name('reports.clearance');
    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportTicketController::class, 'store'])->middleware('role:student')->name('support.store');
    Route::get('/support/{ticket}', [SupportTicketController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/respond', [SupportTicketController::class, 'respond'])->middleware('role:admin,clearance_admin')->name('support.respond');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/dropdown-data', [NotificationController::class, 'dropdownData'])->name('notifications.dropdown-data');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/{notificationId}', [NotificationController::class, 'show'])->name('notifications.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin,clearance_admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::resource('users', UserManagementController::class);
    Route::get('/users/import/form', [UserManagementController::class, 'importForm'])->name('users.import-form');
    Route::post('/users/import', [UserManagementController::class, 'import'])->name('users.import');

    // Reporting
    Route::get('/reports/dashboard', [ReportingController::class, 'dashboard'])->name('reports.dashboard');
    Route::get('/reports/export', [ReportingController::class, 'export'])->name('reports.export');
});

Route::get('/e-learning', fn () => redirect()->route('login'))->name('e-learning');
