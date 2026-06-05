<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CalendarController;
use App\Http\Controllers\Web\ComputerTrainingController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\PasswordResetController;
use App\Http\Controllers\Web\ReminderController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.store');
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->middleware('throttle:3,1')->name('password.update');
});

Route::middleware(['auth', 'active', 'tenant'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'show']);
    Route::resource('customers', CustomerController::class)->except(['create', 'edit', 'show']);
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);
    Route::get('/search', SearchController::class)->name('search');
    Route::get('/calendar', CalendarController::class)->name('calendar');
    Route::post('/services/computer-training/students', [ComputerTrainingController::class, 'storeStudent'])->name('computer-training.students.store');
    Route::post('/services/computer-training/attendance', [ComputerTrainingController::class, 'storeAttendance'])->name('computer-training.attendance.store');
    Route::post('/services/computer-training/classes', [ComputerTrainingController::class, 'storeClassSchedule'])->name('computer-training.classes.store');
    Route::post('/services/computer-training/exams', [ComputerTrainingController::class, 'storeExam'])->name('computer-training.exams.store');
    Route::post('/services/computer-training/fees', [ComputerTrainingController::class, 'storeFee'])->name('computer-training.fees.store');
    Route::post('/services/computer-training/marketing', [ComputerTrainingController::class, 'storeMarketingLead'])->name('computer-training.marketing.store');
    Route::put('/services/computer-training/marketing/{lead}', [ComputerTrainingController::class, 'updateMarketingLead'])->name('computer-training.marketing.update');
    Route::get('/services/computer-training/marketing/export', [ComputerTrainingController::class, 'exportMarketingLead'])->name('computer-training.marketing.export');
    Route::post('/services/computer-training/marketing/import', [ComputerTrainingController::class, 'importMarketingLead'])->name('computer-training.marketing.import');
    Route::post('/services/computer-training/reminders', [ComputerTrainingController::class, 'storeReminder'])->name('computer-training.reminders.store');
    Route::post('/services/computer-training/notices', [ComputerTrainingController::class, 'storeNotice'])->name('computer-training.notices.store');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::resource('reminders', ReminderController::class)->only(['index', 'store', 'update']);
    Route::resource('reports', ReportController::class)->only(['index', 'store']);
    Route::get('/settings', SettingsController::class)->name('settings');
});

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache cleared successfully!';
});

Route::get('/setup-db', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return 'Database migrated and seeded successfully! You can now login with admin@dpoerp.test / password';
});
