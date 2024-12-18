<?php

namespace App\Http\Controllers\Exam;


use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\ExamBankRequest;
use App\Http\Resources\Exam\ExamBankResource;
use App\Models\Exam\ExamBank;
use App\Repositories\Exam\ExamBankRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExamBankController extends Controller
{
    protected $examBankRepository;

    public function __construct(ExamBankRepositoryInterface $examBankRepository)
    {
        $this->examBankRepository = $examBankRepository;
    }


    public function index()
    {
        try {
            $examBanks = $this->examBankRepository->getAllExamBanks();
            return ApiResponse::sendResponse(200, 'All Exam Banks', ExamBankResource::collection($examBanks));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch exam banks');
        }
    }

    public function getBanksByCourse($courseId)
    {
        $exams = $this->examBankRepository->getBanksByCourse($courseId);
        return ApiResponse::sendResponse(200, 'Exam Banks for Course', ExamBankResource::collection($exams));
    }


    public function show(ExamBank $examBank)
    {
        try {
            return ApiResponse::sendResponse(200, 'The Exam Bank', new ExamBankResource($examBank));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Bank Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch exam bank');
        }
    }


    public function store(ExamBankRequest $request)
    {
        try {
            $data = $request->validated();
            $examBank = $this->examBankRepository->createExamBank($data);
            return ApiResponse::sendResponse(201, 'Exam Bank Created', new ExamBankResource($examBank));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to create exam bank');
        }
    }


    public function update(ExamBankRequest $request, ExamBank $examBank)
    {
        try {
            $data = $request->validated();
            $examBank = $this->examBankRepository->updateExamBank($examBank->id, $data);
            return ApiResponse::sendResponse(200, 'Exam Bank Updated', new ExamBankResource($examBank));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Bank Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to update exam bank');
        }
    }


    public function destroy(ExamBank $examBank)
    {
        try {
            $this->examBankRepository->deleteExamBank($examBank->id);
            return ApiResponse::sendResponse(200, 'Exam Bank Deleted');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Exam Bank Not Found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to delete exam bank');
        }
    }


    public function download(ExamBank $examBank, $fileType)
    {
        try {
            if (!in_array($fileType, ['unresolved', 'solved', 'book_solution'])) {
                return ApiResponse::sendResponse(400, 'Invalid file type');
            }

            return $this->examBankRepository->downloadExamBankFile($examBank->id, $fileType);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to download file');
        }
    }
}

