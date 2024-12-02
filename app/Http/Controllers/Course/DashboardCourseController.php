<?php

namespace App\Http\Controllers\Course;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\Course\DashboardCourseResource;
use App\Models\Course\Course;
use App\Repositories\Course\CourseRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DashboardCourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        try {
            $courses = $this->courseRepository->getAll();
            return ApiResponse::sendResponse(200,'All Courses',DashboardCourseResource::collection($courses));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch courses',$e->getMessage());
        }
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            $validated = $request->validated();
            $course = $this->courseRepository->create($validated);
            return ApiResponse::sendResponse(201,'Course Created Successfully',new DashboardCourseResource($course));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to create course',$e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $course = $this->courseRepository->findById($id);
            return ApiResponse::sendResponse(200,'Course',new DashboardCourseResource($course));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Course not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch course',$e->getMessage());
        }
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $course = $this->courseRepository->update($id, $validated);
            return ApiResponse::sendResponse(200,'Course Updated Successfully',new DashboardCourseResource($course));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Course not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Update course',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->courseRepository->delete($id);
            return ApiResponse::sendResponse(200,'Course deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Course not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Delete course',$e->getMessage());
        }
    }
}
