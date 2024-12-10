<?php

namespace App\Repositories\Exam;

use App\Models\Book\Book;

interface ExamRepositoryInterface
{
    public function getAllExams();
    public function getExamsByCourse($courseId);
    public function getExamById($examId);
    public function createExam(array $data);
    public function updateExam($examId, array $data);
    public function deleteExam($examId);
    public function downloadExamFile($examId, $fileType);
}
