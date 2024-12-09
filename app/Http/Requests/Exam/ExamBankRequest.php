<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamBankRequest extends FormRequest
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
            'name'=> 'required|string',
            'course_id' => 'required|exists:courses,id',
            'term_id' => 'required|exists:terms,id',
            'grade_id' => 'required|exists:grades,id',
            'unresolved' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'solved' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'book_solution' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
