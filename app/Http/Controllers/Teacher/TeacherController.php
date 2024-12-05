<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\DetailedTeacherResource;
use App\Http\Resources\Teacher\TeacherResource;
use App\Models\Teacher\Teacher;
use App\Repositories\Teacher\TeacherRepository;
use Exception;

class TeacherController extends Controller
{
    private $repository;

    public function __construct(TeacherRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index()
    {
        try {
            $teachers = $this->repository->all();

            return ApiResponse::sendResponse(
                200,
                'All Teachers',
                [
                    'teachers' => TeacherResource::collection($teachers),
                    'pagination' => [
                        'current_page' => $teachers->currentPage(),
                        'last_page' => $teachers->lastPage(),
                        'per_page' => $teachers->perPage(),
                        'total' => $teachers->total(),
                    ],
                ]
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
