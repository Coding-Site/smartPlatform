<?php

namespace App\Http\Controllers\Exam;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\ExamRequest;
use App\Http\Resources\Exam\ExamResource;
use App\Models\Exam\Exam;
use App\Repositories\Exam\ExamRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExamController extends Controller
{
    protected $examRepository;

    public function __construct(ExamRepositoryInterface $examRepository)
    {
        $this->examRepository = $examRepository;
    }


    public function index()
    {
        try {
            $exams = $this->examRepository->getAllExams();
            return ApiResponse::sendResponse(200, 'All Exams', ExamResource::collection($exams));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch exams');
        }
    }


    public function getExamsForCourse($courseId)
    {
        $exams = $this->examRepository->getExamsByCourse($courseId);
        return ApiResponse::sendResponse(200, 'Exams for Course', ExamResource::collection($exams));
    }


    public function show(Exam $exam)
    {
        try {
            return ApiResponse::sendResponse(200, 'The Exam', new ExamResource($exam));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch exam');
        }
    }


    public function store(ExamRequest $request)
    {
        try {
            $data = $request->validated();
            $exam = $this->examRepository->createExam($data);
            return ApiResponse::sendResponse(201, 'Exam Created', new ExamResource($exam));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to create exam');
        }
    }


    public function update(ExamRequest $request, Exam $exam)
    {
        try {
            $data = $request->validated();
            $exam = $this->examRepository->updateExam($exam->id, $data);
            return ApiResponse::sendResponse(200, 'Exam Updated', new ExamResource($exam));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to update exam');
        }
    }


    public function destroy(Exam $exam)
    {
        try {
            $this->examRepository->deleteExam($exam->id);
            return ApiResponse::sendResponse(200, 'Exam Deleted');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to delete exam');
        }
    }


    public function download(Exam $exam, $fileType)
    {
        try {
            if (!in_array($fileType, ['short_first', 'short_second', 'solved_exams', 'unsolved_exams', 'final_review'])) {
                return ApiResponse::sendResponse(400, 'Invalid file type');
            }

            return $this->examRepository->downloadExamFile($exam->id, $fileType);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to download file');
        }
    }

}
