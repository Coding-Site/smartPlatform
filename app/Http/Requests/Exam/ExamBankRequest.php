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
            'course_id' => 'required|exists:courses,id',
            'unresolved' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'solved' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'book_solution' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
