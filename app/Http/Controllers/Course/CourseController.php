<?php

namespace App\Http\Controllers\Course;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\DetailedCourseResource;
use App\Models\Course\Course;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function showCourseDetails($courseId)
    {
        try {
            $course = Course::with('units.lessons')->findOrFail($courseId);
            if(!$course) return ApiResponse::sendResponse(404,'Course Not Found');

            $isSubscribed = false;
            if (auth()->check()) {
                $user = auth()->user();
                $isSubscribed = $user->hasActiveSubscription($courseId);
            }

            $courseDetails = [
                'course_id'   => $course->id,
                'course_name' => $course->name,
                'units'       => $course->units->map(function ($unit) use ($isSubscribed) {
                    return [
                        'unit_name' => $unit->title,
                        'lessons'   => $unit->lessons->map(function ($lesson) use ($isSubscribed) {
                            return [
                                'lesson_title' => $lesson->title,
                                'video_url'    => $isSubscribed ? $lesson->url : null,
                            ];
                        }),
                    ];
                }),
            ];
            return ApiResponse::sendResponse(200,'Course Details',$courseDetails);

        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Something Wents Wrong'.$e->getMessage());
        }
    }



}
