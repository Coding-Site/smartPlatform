<?php

namespace App\Http\Controllers\Lesson;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LessonNote\LessonNote;

class LessonNoteController extends Controller
{
    public function download(LessonNote $lessonNote)
    {
        if (!$lessonNote) {
            return ApiResponse::sendResponse(404, 'Lesson note not found');
        }

        $filePath = storage_path('app/public/lesson_notes/' . $lessonNote->file);

        if (!file_exists($filePath)) {
            return ApiResponse::sendResponse(404, 'File not found');
        }

        return response()->download($filePath);
    }

}
