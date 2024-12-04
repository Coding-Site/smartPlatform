<?php

use App\Http\Controllers\Order\DashboardOrderController;
use App\Http\Controllers\Teacher\DashboardTeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::resource('teachers', DashboardTeacherController::class);
    Route::get('/orders', [DashboardOrderController::class, 'index']);

});
