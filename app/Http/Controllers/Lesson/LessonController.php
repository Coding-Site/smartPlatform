<?php

namespace App\Http\Controllers\Lesson;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Lesson\LessonResource;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{

    public function show(Lesson $lesson)
    {
        $courseId = $lesson->unit->course_id;
        
        $isSubscribed = auth()->check() ? auth()->user()->hasActiveSubscription($courseId) : false;
        if($lesson->is_free || $isSubscribed ) {
            return new LessonResource($lesson);
        }
        return ApiResponse::sendResponse(Response::HTTP_FORBIDDEN, 'This lesson is not free and you are not subscribed to the course.');
    }

    public function download(Lesson $lesson)
    {
        if (!$lesson->hasMedia('lesson_note')) {
            return ApiResponse::sendResponse(Response::HTTP_NOT_FOUND, 'Lesson Note not found.');
        }

        $filePath = $lesson->getFirstMedia('lesson_note')->getPath();

        if (!file_exists($filePath)) {
            return ApiResponse::sendResponse(404, 'File not found');
        }

        return response()->download($filePath);
    }
}
