<?php


use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Lesson\LessonNoteController;
use Illuminate\Support\Facades\Route;

//course
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{course}', [CourseController::class, 'show']);

//course lesson
Route::get('/lesson-note/download/{lessonNote}', [LessonNoteController::class, 'download']);
Route::get('/cards/lesson/{lesson}', [CardController::class, 'get']);
Route::post('/cards/{card}/save', [CardController::class, 'save']);
Route::post('/cards/{card}/forget', [CardController::class, 'forget']);
Route::get('/lesson/{lesson}/score', [CardController::class, 'calculateScore']);


