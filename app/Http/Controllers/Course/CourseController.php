<?php

namespace App\Http\Controllers\Course;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\DetailedCourseResource;
use App\Models\Course\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $stageId = $request->query('stage_id');
        $gradeId = $request->query('grade_id');

        $courses = Course::filter($stageId, $gradeId)->with('translations')->get();

        return ApiResponse::sendResponse(200,'Courses',CourseResource::collection($courses));
    }

    public function show(Course $course)
    {
        return new DetailedCourseResource($course);
    }

}
