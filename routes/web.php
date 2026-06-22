<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CourseWebController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AdminCourseController;
use App\Http\Controllers\Web\AdminUserController;
use App\Http\Controllers\Web\EnrolmentWebController;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index']);
Route::get('/courses', [CourseWebController::class, 'index']);
Route::get('/courses/{slug}', [CourseWebController::class, 'show']);

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthWebController::class, 'register']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthWebController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthWebController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthWebController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthWebController::class, 'resetPassword'])->name('password.update');

// ── Delegate Dashboard ───────────────────────────────────────────────────────
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [DashboardController::class, 'courses']);
    Route::get('/certificates', [DashboardController::class, 'certificates']);
    Route::get('/payments', [DashboardController::class, 'payments']);
    Route::get('/profile', [DashboardController::class, 'profile']);
    Route::put('/profile', [DashboardController::class, 'updateProfile']);
});

// ── Enrolment ────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/enrolment/checkout', [EnrolmentWebController::class, 'checkout']);
    Route::post('/enrolment/initiate', [EnrolmentWebController::class, 'initiate']);
    Route::get('/enrolment/success', [EnrolmentWebController::class, 'success']);
});

// ── Admin Panel ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin,admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('courses', AdminCourseController::class)->except(['show']);
    Route::resource('users', AdminUserController::class)->only(['index']);
    Route::get('enrolments', [AdminController::class, 'enrolments']);
    Route::post('enrolments/{enrolment}/approve', [AdminController::class, 'approveEnrolment']);
    Route::post('enrolments/{enrolment}/cancel', [AdminController::class, 'cancelEnrolment']);
    Route::get('payments', [AdminController::class, 'payments']);
    Route::get('reports', [AdminController::class, 'reports']);
});
