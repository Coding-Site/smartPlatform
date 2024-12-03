<?php

namespace App\Http\Controllers\Lesson;

use App\Http\Controllers\Controller;
use App\Models\LessonNote\LessonNote;

class LessonNoteController extends Controller
{
    public function download(LessonNote $lessonNote)
    {
        if (!$lessonNote) {
            return response()->json(['error' => 'Lesson note not found'], 404);
        }

        $filePath = storage_path('app/public/' . $lessonNote->file);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->download($filePath);
    }

}
