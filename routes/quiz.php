<?php

use App\Http\Controllers\Quiz\QuizController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('quiz/{quiz}', [QuizController::class, 'getQuestion']);
    Route::post('quiz/{quiz}/question/{question}/submit', [QuizController::class, 'submitAnswer']);
    Route::post('quiz/{quiz}/question/{question}/self-assessment', [QuizController::class, 'submitSelfAssessmentScore']);
    Route::get('quiz/{quiz}/question/{currentQuestion}/next', [QuizController::class, 'getNextQuestion']);
    Route::get('quiz/{quiz}/score', [QuizController::class, 'getScore']);
});
