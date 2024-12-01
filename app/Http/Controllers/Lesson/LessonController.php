<?php

namespace App\Http\Controllers\Lesson;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Http\Resources\Lesson\LessonResource;
use App\Repositories\Lesson\LessonRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LessonController extends Controller
{
    protected $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function index()
    {
        try {
            $lessons = $this->lessonRepository->getAll();
            return ApiResponse::sendResponse(200,'All Lessons',LessonResource::collection($lessons));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch lessons.'.$e->getMessage());
        }
    }

    public function store(StoreLessonRequest $request)
    {
        try {
            $validated = $request->all();
            $lesson = $this->lessonRepository->create($validated);
            return ApiResponse::sendResponse(201,'lesson Created Successfully',new LessonResource($lesson));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to create unit' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $lesson = $this->lessonRepository->getById($id);
            return ApiResponse::sendResponse(200,'Lesson',new LessonResource($lesson));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Unit not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch Unit'.$e->getMessage());
        }
    }

    public function update(UpdateLessonRequest $request, $id)
    {
        try {
            $validated = $request->all();
            $lesson = $this->lessonRepository->update($id, $validated);
            return ApiResponse::sendResponse(200,'Lesson Updated Successfully',new LessonResource($lesson));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Unit not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Update Unit'.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->lessonRepository->delete($id);
            return ApiResponse::sendResponse(200,'Lesson deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Lesson not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Delete Lesson'.$e->getMessage());
        }
    }
}
