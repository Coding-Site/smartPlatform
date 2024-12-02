<?php

use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Term\TermController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:teacher'])->group(function () {
//     Route::apiResource('courses', CourseController::class);

// });
Route::post('/set-term/{id}', [TermController::class, 'setActiveTerm'])->name('term.set');

