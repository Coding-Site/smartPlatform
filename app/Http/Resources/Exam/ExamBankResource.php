<?php

namespace App\Http\Resources\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamBankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course' => $this->course->name,
            'grade' => $this->grade->name,
            'unresolved' => $this->getFirstMediaUrl('unresolved') ?? null,
            'solved' => $this->getFirstMediaUrl('solved') ?? null,
            'book_solution' => $this->getFirstMediaUrl('book_solution') ?? null,
        ];
    }
}
