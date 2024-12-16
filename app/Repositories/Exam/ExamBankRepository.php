<?php

namespace App\Repositories\Exam;

use App\Models\Exam\ExamBank;
use Illuminate\Http\Response;
use App\Helpers\ApiResponse;

class ExamBankRepository implements ExamBankRepositoryInterface
{
    public function getAllExamBanks()
    {
        return ExamBank::paginate(10);
    }

    public function getBanksByCourse($courseId)
    {
        return ExamBank::where('course_id', $courseId)->get();
    }


    public function getExamBankById($examBankId)
    {
        return ExamBank::findOrFail($examBankId);
    }

    public function createExamBank(array $data)
    {
        $unresolvedPdf = $data['unresolved'] ?? null;
        $solvedPdf = $data['solved'] ?? null;
        $bookSolutionPdf = $data['book_solution'] ?? null;

        unset($data['unresolved'], $data['solved'], $data['book_solution']);

        $existingExamBank = ExamBank::where('course_id', $data['course_id'])->first();

        if ($existingExamBank) {
            foreach (['unresolved', 'solved', 'book_solution'] as $collection) {
                $existingExamBank->clearMediaCollection($collection);
            }
            $existingExamBank->delete();
        }

        $examBank = ExamBank::create($data);

        if ($unresolvedPdf) {
            $examBank->addMedia($unresolvedPdf)->toMediaCollection('unresolved');
        }

        if ($solvedPdf) {
            $examBank->addMedia($solvedPdf)->toMediaCollection('solved');
        }

        if ($bookSolutionPdf) {
            $examBank->addMedia($bookSolutionPdf)->toMediaCollection('book_solution');
        }

        return $examBank;
    }

    public function updateExamBank($examBankId, array $data)
    {
        $examBank = ExamBank::findOrFail($examBankId);

        $unresolvedPdf = $data['unresolved'] ?? null;
        $solvedPdf = $data['solved'] ?? null;
        $bookSolutionPdf = $data['book_solution'] ?? null;

        unset($data['unresolved'], $data['solved'], $data['book_solution']);

        $examBank->update($data);

        if ($unresolvedPdf) {
            $examBank->clearMediaCollection('unresolved');
            $examBank->addMedia($unresolvedPdf)->toMediaCollection('unresolved');
        }

        if ($solvedPdf) {
            $examBank->clearMediaCollection('solved');
            $examBank->addMedia($solvedPdf)->toMediaCollection('solved');
        }

        if ($bookSolutionPdf) {
            $examBank->clearMediaCollection('book_solution');
            $examBank->addMedia($bookSolutionPdf)->toMediaCollection('book_solution');
        }

        return $examBank;
    }

    public function deleteExamBank($examBankId)
    {
        $examBank = ExamBank::findOrFail($examBankId);

        $examBank->clearMediaCollection('unresolved');
        $examBank->clearMediaCollection('solved');
        $examBank->clearMediaCollection('book_solution');

        $examBank->delete();

        return true;
    }

    public function downloadExamBankFile($examBankId, $fileType)
    {
        $examBank = ExamBank::findOrFail($examBankId);

        if (!$examBank->hasMedia($fileType)) {
            return ApiResponse::sendResponse(Response::HTTP_NOT_FOUND, 'File not found.');
        }

        $file = $examBank->getFirstMedia($fileType);
        return response()->download($file->getPath(), $file->file_name);
    }
}

