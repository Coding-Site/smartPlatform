<?php

use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Book\DashboardBookController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Course\DashboardCourseController;
use App\Http\Controllers\Exam\ExamBankController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\Lesson\DashboardLessonController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Teacher\DashboardTeacherController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;

Route::controller(TeacherAuthController::class)->group(function (){
    Route::middleware(['set-language'])->group(function () {
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        // Route::post('/login','login')->name('login');
        // Route::post('/forgot-password','forgotPassword');
        // Route::post('/reset-password','resetPassword');
        Route::middleware(['auth:teacher'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });
});

Route::middleware(['auth:teacher'])->group(function () {
    Route::apiResource('courses', DashboardCourseController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('lessons', DashboardLessonController::class);
    Route::apiResource('books', DashboardBookController::class);
    Route::apiResource('exams', ExamController::class);
    Route::apiResource('exam-banks', ExamBankController::class);

    Route::controller(DashboardTeacherController::class)->group(function (){
        Route::get('subscription/course','getCourseSubscription');
        Route::get('subscription/book','getOrderedBooks');
        Route::get('count/subscription/course','getSubscriptionsCountForTeacher');
    });

    Route::apiResource('packages', PackageController::class);

    Route::get('/lessons/{lesson}/comments', [CommentController::class, 'showComments']);
    Route::post('/lessons/{lesson}/comments', [CommentController::class, 'store']);
    Route::post('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject']);
});




