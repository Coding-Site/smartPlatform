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
            $type = $request->query('type');

            $courses = Course::filter($stageId, $gradeId,$type)->get();

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully', CourseResource::collection($courses));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch courses. ' . $e->getMessage());
        }
    }

    public function getCoursesByGradeIds(Request $request)
    {
        try {
            $gradeIds = $request->query('grade_ids', []);

            $courses = Course::whereIn('grade_id', $gradeIds)->get();

            $courseData = $courses->map(function ($course) {
                return [
                    'value' => $course->id,
                    'label' => $course->name . ' - ' . $course->grade->name,
                ];
            });

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully', $courseData);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch courses. ' . $e->getMessage());
        }
    }

    public function getFilteredCourseNames(Request $request)
    {
        try {
            $stageId = $request->query('stage_id');
            $gradeId = $request->query('grade_id');
            $type = $request->query('type');

            $courses = Course::filter($stageId, $gradeId, $type)->get();

            $courseNames = $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            });

            return ApiResponse::sendResponse(200, 'Filtered course names retrieved successfully', $courseNames);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch course names. ' . $e->getMessage());
        }
    }




    public function showCourseDetails($courseId)
    {
        try {
            $course = Course::with('units.lessons')->findOrFail($courseId);

            if (!$course) {
                return ApiResponse::sendResponse(404, 'Course Not Found');
            }

            $isSubscribed = auth()->check() ? auth()->user()->hasActiveSubscription($courseId) : false;
            $courseDetails = [
                'course_id' => $course->id,
                'course_name' => $course->name,
                'units' => $course->units->map(function ($unit) use ($isSubscribed) {
                    return [
                        'unit_name' => $unit->title,
                        'lessons' => $unit->lessons->map(function ($lesson) use ($isSubscribed) {
                            return [
                                'lesson_title' => $lesson->title,
                                'video_url' => $isSubscribed ? $lesson->url : null,
                            ];
                        }),
                    ];
                }),
            ];

            return ApiResponse::sendResponse(200, 'Course Details', $courseDetails);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Something went wrong: ' . $e->getMessage());
        }
    }



}
