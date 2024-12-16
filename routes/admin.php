<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ContactUs\DashboardContactUsController;
use App\Http\Controllers\Order\DashboardOrderController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Teacher\DashboardTeacherController;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {
    Route::resource('teachers', DashboardTeacherController::class);
    Route::get('/orders', [DashboardOrderController::class, 'index']);

    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('users/{user}/assign-role', [RoleController::class, 'assignRoleToUser']);

    Route::get('contact-us', [DashboardContactUsController::class, 'index']);
    Route::get('contact-us/{contactUs}', [DashboardContactUsController::class, 'show']);
    Route::delete('contact-us/{contactUs}', [DashboardContactUsController::class, 'destroy']);

});
