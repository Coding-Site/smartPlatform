<?php

namespace App\Repositories\Exam;

use App\Models\Book\Book;

interface ExamBankRepositoryInterface
{
    public function getAllExamBanks();
    public function createExamBank(array $data);
    public function getExamBankById($examBankId);
    public function updateExamBank($examBankId, array $data);
    public function deleteExamBank($examBankId);
    public function downloadExamBankFile($examBankId, $fileType);
}
