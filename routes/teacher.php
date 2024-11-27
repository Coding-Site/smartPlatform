<?php

use App\Http\Controllers\Auth\TeacherAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['set-language'])->group(function () {
    Route::controller(TeacherAuthController::class)->group(function (){
        Route::post('/register','register');
        Route::post('/verify-email','verifyEmail');
        Route::post('/login','login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password','resetPassword');
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });

});
