<?php

namespace App\Http\Controllers\Course;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\DetailedCourseResource;
use App\Models\Course\Course;
use Illuminate\Http\Request;
use Exception;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $stageId = $request->query('stage_id');
            $gradeId = $request->query('grade_id');

            $courses = Course::filter($stageId, $gradeId)->with('translations')->get();

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully', CourseResource::collection($courses));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch courses. ' . $e->getMessage());
        }
    }

    public function show(Course $course)
    {
        try {
            $course->load('units.lessons.comments.replies');

            return ApiResponse::sendResponse(200, 'Course details retrieved successfully', new DetailedCourseResource($course));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch course details. ' . $e->getMessage());
        }
    }
}
