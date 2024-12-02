<?php


use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{course}', [CourseController::class, 'show']);
