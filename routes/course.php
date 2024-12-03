<?php


use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Lesson\LessonNoteController;
use Illuminate\Support\Facades\Route;

Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{course}', [CourseController::class, 'show']);

//course lesson note
Route::get('/lesson-note/download/{lessonNote}', [LessonNoteController::class, 'download']);
