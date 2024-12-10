<?php

use App\Http\Controllers\Comment\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject']);

});

