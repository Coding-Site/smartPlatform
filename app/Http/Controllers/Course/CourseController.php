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

            $courses = Course::filter($stageId, $gradeId, $type)->with(['units.lessons' => function ($query) {
                $query->where('is_free', true);
            }])->get();

            $coursesWithFreeLessons = CourseResource::collection($courses);

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully', $coursesWithFreeLessons);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch courses. ' . $e->getMessage());
        }
    }
    public function getCoursesByGradeIds(Request $request)
    {
        try {
            $gradeIds = $request->query('grade_ids', []);

            $courses = Course::whereIn('grade_id', $gradeIds)
                ->with('grade')
                ->get();

            $uniqueCourses = $courses->groupBy('name')->map(function ($group) {
                return [
                    'label' => $group->first()->name,
                ];
            })->values();

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully', $uniqueCourses);
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


    public function getCourse(Course $course)
    {
        try {
            $course->load('teacher', 'grade', 'grade.courses');

            $courseDetails = [
                'id' => $course->id,
                'name' => $course->name,
                'image' => $course->getFirstMediaUrl('images'),
                'term_price' => $course->term_price,
                'monthly_price' => $course->monthly_price,
                'teacher_name' => $course->teacher->name,
                'teacher_image' => $course->teacher->getFirstMediaUrl('image'),
                'other_courses_in_same_grade' => $course->grade->courses
                    ->where('id', '!=', $course->id)
                    ->map(function ($otherCourse) {
                        return [
                            'id' => $otherCourse->id,
                            'name' => $otherCourse->name,
                            'icon' => $otherCourse->getFirstMediaUrl('icons'),
                        ];
                    })
                    ->values()
                    ->toArray(),
            ];

            return ApiResponse::sendResponse(200, 'Course details retrieved successfully', $courseDetails);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Something went wrong: ' . $e->getMessage());
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
                'course_image' => $course->getFirstMediaUrl('images'),
                'isSubscribed' => $isSubscribed,
                'units' => $course->units->map(function ($unit) use ($isSubscribed) {
                    return [
                        'unit_name' => $unit->title,
                        'lessons' => $unit->lessons->map(function ($lesson) use ($isSubscribed) {
                            return [
                                'lesson_id' => $lesson->id,
                                'lesson_title' => $lesson->title,
                                'is_free' => $lesson->is_free,
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

    public function getLessonsWithQuiz(Course $course)
    {
        try {
            $course->load(['units.lessons' => function ($query) {
                $query->whereHas('quiz');
            }]);

            $unitsWithLessons = $course->units->filter(function ($unit) {
                return $unit->lessons->isNotEmpty();
            })->map(function ($unit) {
                return [
                    'unit_id' => $unit->id,
                    'unit_title' => $unit->title,
                    'lessons' => $unit->lessons->map(function ($lesson) {
                        return [
                            'lesson_id' => $lesson->id,
                            'lesson_title' => $lesson->title,
                            'quiz_title' => $lesson->quiz->title,
                        ];
                    }),
                ];
            });

            return ApiResponse::sendResponse(200, 'Units with Lessons and Quiz retrieved successfully', $unitsWithLessons);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function getLessonsWithCards(Course $course)
    {
        try {
            $course->load(['units.lessons' => function ($query) {
                $query->whereHas('cards');
            }]);

            $unitsWithLessons = $course->units->filter(function ($unit) {
                return $unit->lessons->isNotEmpty();
            })->map(function ($unit) {
                return [
                    'unit_id' => $unit->id,
                    'unit_title' => $unit->title,
                    'lessons' => $unit->lessons->map(function ($lesson) {
                        return [
                            'lesson_id' => $lesson->id,
                            'lesson_title' => $lesson->title,
                        ];
                    }),
                ];
            });

            return ApiResponse::sendResponse(200, 'Units with Lessons and Cards retrieved successfully', $unitsWithLessons);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Something went wrong: ' . $e->getMessage());
        }
    }}

