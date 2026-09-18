<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Farmer\FarmerDashboardController;
use App\Http\Controllers\Farmer\DiagnosisController;
use App\Http\Controllers\Farmer\AppointmentController as FarmerAppointmentController;
use App\Http\Controllers\Farmer\SeedController;
use App\Http\Controllers\Officer\OfficerDashboardController;
use App\Http\Controllers\Officer\OfficerAppointmentController;
use App\Http\Controllers\Officer\AdviceController;
use App\Http\Controllers\Officer\OfficerArticleController;
use App\Http\Controllers\Officer\NotificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminDiseaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Farmer\CropController;

// ── Public ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles', [HomeController::class, 'articles'])->name('articles');
Route::get('/articles/{slug}', [HomeController::class, 'show'])->name('articles.show');
Route::get('/contact',  [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// 💡 Added: Dedicated guides route for the tips feature
Route::get('/guides/{topic}', [HomeController::class, 'guide'])->name('guide');

// ── Auth ────────────────────────────────────────────────
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ── Farmer ──────────────────────────────────────────────
Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard',          [FarmerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/diagnosis',          [DiagnosisController::class, 'index'])->name('diagnosis');
    Route::post('/diagnosis',         [DiagnosisController::class, 'store'])->name('diagnosis.store');
    Route::get('/diagnosis/{id}',     [DiagnosisController::class, 'show'])->name('diagnosis.show');
    Route::get('/appointments',       [FarmerAppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/book',  [FarmerAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',      [FarmerAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/available-slots', [FarmerAppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
    Route::get('/seeds',              [SeedController::class, 'index'])->name('seeds');
    Route::post('/diagnosis/{id}/request-advice', [DiagnosisController::class, 'requestAdvice'])->name('diagnosis.request-advice');

    // Crop / Harvest Tracker
    Route::get('/crops',             [CropController::class, 'index'])->name('crops');
    Route::get('/crops/create',      [CropController::class, 'create'])->name('crops.create');
    Route::post('/crops',            [CropController::class, 'store'])->name('crops.store');
    Route::patch('/crops/{id}/task', [CropController::class, 'toggleTask'])->name('crops.toggle');
    Route::delete('/crops/{id}',     [CropController::class, 'destroy'])->name('crops.destroy');
});

// ── Officer ─────────────────────────────────────────────
Route::middleware(['auth', 'role:officer'])->prefix('officer')->name('officer.')->group(function () {
    Route::get('/dashboard',                  [OfficerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments',               [OfficerAppointmentController::class, 'index'])->name('appointments');
    Route::patch('/appointments/{id}/accept', [OfficerAppointmentController::class, 'accept'])->name('appointments.accept');
    Route::patch('/appointments/{id}/reject', [OfficerAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::get('/diagnoses',                  [AdviceController::class, 'index'])->name('diagnoses');
    Route::get('/diagnoses/{id}',             [AdviceController::class, 'show'])->name('diagnoses.show');
    Route::post('/diagnoses/{id}/advice',     [AdviceController::class, 'sendAdvice'])->name('advice.send');

    // Officer Articles
    Route::get('/articles',           [OfficerArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create',    [OfficerArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles',          [OfficerArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [OfficerArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}',      [OfficerArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}',   [OfficerArticleController::class, 'destroy'])->name('articles.destroy');

    // Officer Notifications
    Route::get('/notifications',        [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
});

// ── Admin ───────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',     [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users',    AdminUserController::class);
    Route::resource('/articles', AdminArticleController::class);
    Route::resource('/diseases', AdminDiseaseController::class);

    // 📊 Officer Reports
    Route::get('/reports',              [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/officer/{id}', [ReportController::class, 'generateOfficer'])->name('reports.officer');
});