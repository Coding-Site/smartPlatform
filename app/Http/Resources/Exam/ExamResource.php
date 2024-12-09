<?php

namespace App\Http\Resources\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'short_first' => $this->getFirstMediaUrl('short_first') ?? null,
            'short_second' => $this->getFirstMediaUrl('short_second') ?? null,
            'solved_exams' => $this->getFirstMediaUrl('solved_exams') ?? null,
            'unsolved_exams' => $this->getFirstMediaUrl('unsolved_exams') ?? null,
            'final_review' => $this->getFirstMediaUrl('final_review') ?? null,
        ];
    }
}
