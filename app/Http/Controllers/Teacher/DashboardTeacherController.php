<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Teacher\RegisterRequest;
use App\Http\Requests\Auth\Teacher\UpdateTeacherRequest;
use App\Models\Teacher\Teacher;
use App\Repositories\Auth\TeacherAuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardTeacherController extends Controller
{

    protected $authRepository;

    public function __construct(TeacherAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function index()
    {
        try {
            $teachers = Teacher::all();
            return ApiResponse::sendResponse(200, 'Teachers retrieved successfully', $teachers);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch teachers. ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            return ApiResponse::sendResponse(200, 'Teacher retrieved successfully', $teacher);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch teacher. ' . $e->getMessage());
        }
    }


    public function store(RegisterRequest $request)
    {
        try {
            $teacher = $this->authRepository->createTeacher($request->validated());
            $teacher->assignRole('super_teacher');

            return ApiResponse::sendResponse(201, 'Teacher created and assigned role successfully', $teacher);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to create teacher. ' . $e->getMessage());
        }
    }

    public function update(UpdateTeacherRequest $request, $id)
    {


        try {
            $teacher = Teacher::findOrFail($id);

            $teacher->update($request->only([
                'name', 'email', 'phone', 'course_id', 'stage_id', 'bio',
            ]));

            return ApiResponse::sendResponse(200, 'Teacher updated successfully', $teacher);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to update teacher. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();
            return ApiResponse::sendResponse(200, 'Teacher deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to delete teacher. ' . $e->getMessage());
        }
    }
}
