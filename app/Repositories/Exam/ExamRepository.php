<?php


namespace App\Repositories\Exam;

use App\Models\Exam\Exam;
use Illuminate\Http\Response;
use App\Helpers\ApiResponse;

class ExamRepository implements ExamRepositoryInterface
{
    public function getAllExams()
    {
        return Exam::paginate(10);
    }

    public function createExam(array $data)
    {
        $shortFirstPdf = $data['short_first'] ?? null;
        $shortSecondPdf = $data['short_second'] ?? null;
        $solvedExamsPdf = $data['solved_exams'] ?? null;
        $unsolvedExamsPdf = $data['unsolved_exams'] ?? null;
        $finalRevisionPdf = $data['final_revision'] ?? null;

        unset($data['short_first_pdf'], $data['short_second'], $data['solved_exams'], $data['unsolved_exams'], $data['final_revision']);

        $exam = Exam::create($data);

        if ($shortFirstPdf) {
            $exam->addMedia($shortFirstPdf)->toMediaCollection('short_first');
        }

        if ($shortSecondPdf) {
            $exam->addMedia($shortSecondPdf)->toMediaCollection('short_second');
        }

        if ($solvedExamsPdf) {
            $exam->addMedia($solvedExamsPdf)->toMediaCollection('solved_exams');
        }

        if ($unsolvedExamsPdf) {
            $exam->addMedia($unsolvedExamsPdf)->toMediaCollection('unsolved_exams');
        }

        if ($finalRevisionPdf) {
            $exam->addMedia($finalRevisionPdf)->toMediaCollection('final_revision');
        }

        return $exam;
    }

    public function getExamById($examId)
    {
        return Exam::findOrFail($examId);
    }

    public function updateExam($examId, array $data)
    {
        $exam = Exam::findOrFail($examId);

        $shortFirstPdf = $data['short_first'] ?? null;
        $shortSecondPdf = $data['short_second'] ?? null;
        $solvedExamsPdf = $data['solved_exams'] ?? null;
        $unsolvedExamsPdf = $data['unsolved_exams'] ?? null;
        $finalRevisionPdf = $data['final_revision'] ?? null;

        unset($data['short_first'], $data['short_second'], $data['solved_exams'], $data['unsolved_exams'], $data['final_revision']);

        $exam->update($data);

        if ($shortFirstPdf) {
            $exam->clearMediaCollection('short_first');
            $exam->addMedia($shortFirstPdf)->toMediaCollection('short_first');
        }

        if ($shortSecondPdf) {
            $exam->clearMediaCollection('short_second');
            $exam->addMedia($shortSecondPdf)->toMediaCollection('short_second');
        }

        if ($solvedExamsPdf) {
            $exam->clearMediaCollection('solved_exams');
            $exam->addMedia($solvedExamsPdf)->toMediaCollection('solved_exams');
        }

        if ($unsolvedExamsPdf) {
            $exam->clearMediaCollection('unsolved_exams');
            $exam->addMedia($unsolvedExamsPdf)->toMediaCollection('unsolved_exams');
        }

        if ($finalRevisionPdf) {
            $exam->clearMediaCollection('final_revision');
            $exam->addMedia($finalRevisionPdf)->toMediaCollection('final_revision');
        }

        return $exam;
    }

    public function deleteExam($examId)
    {
        $exam = Exam::findOrFail($examId);

        $exam->clearMediaCollection('short_first');
        $exam->clearMediaCollection('short_second');
        $exam->clearMediaCollection('solved_exams');
        $exam->clearMediaCollection('unsolved_exams');
        $exam->clearMediaCollection('final_revision');

        $exam->delete();

        return true;
    }

    public function downloadExamFile($examId, $fileType)
    {
        $exam = Exam::findOrFail($examId);

        if (!$exam->hasMedia($fileType)) {
            return ApiResponse::sendResponse(Response::HTTP_NOT_FOUND, 'File not found.');
        }

        $file = $exam->getFirstMedia($fileType);
        return response()->download($file->getPath(), $file->file_name);
    }
}




