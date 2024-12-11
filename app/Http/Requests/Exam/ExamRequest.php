<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'term_id' => 'required|exists:terms,id',
            'grade_id' => 'required|exists:grades,id',
            'short_first' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'short_second' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'solved_exams' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'unsolved_exams' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'final_review' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
