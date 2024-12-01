<?php

use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:teacher'])->group(function () {
    Route::apiResource('courses', CourseController::class);

});
