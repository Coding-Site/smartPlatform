<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\DetailedTeacherResource;
use App\Http\Resources\Teacher\TeacherResource;
use App\Models\Teacher\Teacher;
use App\Repositories\Teacher\TeacherRepository;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        try {
            $type = $request->query('type');

            $teachers = Teacher::query()
                ->filter($type)
                ->paginate(10);

            return ApiResponse::sendResponse(200, 'All Teachers', TeacherResource::collection($teachers)
            );
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Unable to fetch teachers', $e->getMessage());
        }
    }

    public function show(Teacher $teacher)
    {
        try {
            return ApiResponse::sendResponse(200,'Teacher details',new DetailedTeacherResource($teacher));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch teacher details',$e->getMessage());
        }
    }
}
