<?php

use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Lesson\LessonController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;

Route::controller(TeacherAuthController::class)->group(function (){
    Route::middleware(['set-language'])->group(function () {
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        Route::post('/login','login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password','resetPassword');
        Route::middleware(['auth:teacher'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });
});

Route::middleware(['auth:teacher'])->group(function () {
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('lessons', LessonController::class);

    // Route::controller(CourseController::class)->group(function (){
    //     Route::post('courses',  'store');
    // });
});


