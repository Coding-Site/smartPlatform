<?php


use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Term\TermController;
use Illuminate\Support\Facades\Route;


Route::middleware(['set-language'])->group(function () {
    Route::controller(UserAuthController::class)->group(function (){
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

Route::post('/cart/{course}/add', [CartController::class, 'addToCart'])->middleware('ensurecarttoken');
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});