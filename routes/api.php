<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(UserAuthController::class)->group(function (){
        Route::post('/register','register');
        
    });
Route::middleware(['set-language'])->group(function () {
    Route::controller(AuthController::class)->group(function (){
        Route::post('/login','login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password','resetPassword');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/change-password','changePassword');
            Route::post('/logout','logout');
        });
    });

});

Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
    require __DIR__ . '/admin.php';
    require __DIR__ . '/teacher.php';
    require __DIR__ . '/user.php';
    require __DIR__ . '/quiz.php';
    require __DIR__ . '/course.php';
    require __DIR__ . '/comment.php';

});
