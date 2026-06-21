<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CourseMaterialController;
use App\Http\Controllers\Api\V1\EnrolmentController;
use App\Http\Controllers\Api\V1\LearningPathController;
use App\Http\Controllers\Api\V1\PasswordResetController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\CertificateController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Controllers\Api\V1\AssessmentController;
use App\Http\Controllers\Api\V1\ReportController;

Route::prefix('v1')->group(function () {

    // Public routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{slug}', [CourseController::class, 'show']);
    Route::get('/courses/{course}/materials', [CourseMaterialController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/certificates/verify/{code}', [CertificateController::class, 'verify']);
    Route::get('/payments/verify/{reference}', [PaymentController::class, 'verify']);
    Route::get('/learning-paths', [LearningPathController::class, 'index']);
    Route::get('/learning-paths/{slug}', [LearningPathController::class, 'show']);

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
        Route::post('/reset-password', [PasswordResetController::class, 'reset']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', [AuthController::class, 'me']);
        });
    });

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {

        // Delegate + above
        Route::get('/enrolments', [EnrolmentController::class, 'index']);
        Route::post('/enrolments', [EnrolmentController::class, 'store']);
        Route::get('/enrolments/{enrolment}', [EnrolmentController::class, 'show']);
        Route::post('/enrolments/{enrolment}/cancel', [EnrolmentController::class, 'cancel']);

        Route::get('/certificates', [CertificateController::class, 'index']);
        Route::get('/certificates/{certificate}', [CertificateController::class, 'show']);
        Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download']);

        Route::get('/user/me', [UserController::class, 'me']);
        Route::put('/user/profile', [UserController::class, 'update']);

        Route::get('/payments', [PaymentController::class, 'index']);
        Route::get('/payments/{payment}', [PaymentController::class, 'show']);
        Route::post('/payments/initiate', [PaymentController::class, 'initiate']);

        Route::get('/assessments', [AssessmentController::class, 'index']);
        Route::get('/assessments/{assessment}', [AssessmentController::class, 'show']);
        Route::post('/assessments/{assessment}/submit', [AssessmentController::class, 'submit']);
        Route::get('/assessments/{assessment}/results', [AssessmentController::class, 'results']);

        Route::get('/schedules', [ScheduleController::class, 'index']);
        Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);

        Route::get('/materials/{material}', [CourseMaterialController::class, 'show']);

        // Admin routes
        Route::middleware('role:super_admin,admin')->group(function () {
            // Courses admin
            Route::post('/courses', [CourseController::class, 'store']);
            Route::put('/courses/{course}', [CourseController::class, 'update']);
            Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
            Route::post('/courses/{course}/publish', [CourseController::class, 'publish']);
            Route::post('/courses/{course}/featured', [CourseController::class, 'featured']);

            // Categories admin
            Route::post('/categories', [CategoryController::class, 'store']);
            Route::put('/categories/{category}', [CategoryController::class, 'update']);
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

            // Users admin
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/users/{user}', [UserController::class, 'show']);
            Route::put('/users/{user}', [UserController::class, 'update']);
            Route::delete('/users/{user}', [UserController::class, 'destroy']);

            // Enrolments admin
            Route::put('/enrolments/{enrolment}', [EnrolmentController::class, 'update']);
            Route::post('/enrolments/{enrolment}/complete', [EnrolmentController::class, 'complete']);

            // Payments admin
            Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund']);

            // Schedules admin
            Route::post('/schedules', [ScheduleController::class, 'store']);
            Route::put('/schedules/{schedule}', [ScheduleController::class, 'update']);
            Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy']);

            // Materials admin
            Route::post('/materials', [CourseMaterialController::class, 'store']);
            Route::put('/materials/{material}', [CourseMaterialController::class, 'update']);
            Route::delete('/materials/{material}', [CourseMaterialController::class, 'destroy']);

            // Learning Paths admin
            Route::post('/learning-paths', [LearningPathController::class, 'store']);
            Route::put('/learning-paths/{learningPath}', [LearningPathController::class, 'update']);
            Route::delete('/learning-paths/{learningPath}', [LearningPathController::class, 'destroy']);

            // Assessments admin
            Route::post('/assessments', [AssessmentController::class, 'store']);
            Route::put('/assessments/{assessment}', [AssessmentController::class, 'update']);
            Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy']);

            // Reports
            Route::prefix('reports')->group(function () {
                Route::get('/enrolments', [ReportController::class, 'enrolments']);
                Route::get('/revenue', [ReportController::class, 'revenue']);
                Route::get('/completions', [ReportController::class, 'completions']);
                Route::get('/delegates', [ReportController::class, 'delegates']);
            });
        });
    });
});
