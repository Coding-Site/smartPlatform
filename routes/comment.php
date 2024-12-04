<?php

use App\Http\Controllers\Comment\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/lessons/{lesson}/comments', [CommentController::class, 'store']);

    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject']);

    Route::post('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});

Route::get('/lessons/{lesson}/comments', [CommentController::class, 'showComments']);
