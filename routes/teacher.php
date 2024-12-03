<?php

use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Course\DashboardCourseController;
use App\Http\Controllers\Lesson\DashboardLessonController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;

Route::controller(TeacherAuthController::class)->group(function (){
    Route::middleware(['set-language'])->group(function () {
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        Route::post('/login','login')->name('login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password','resetPassword');
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


});


