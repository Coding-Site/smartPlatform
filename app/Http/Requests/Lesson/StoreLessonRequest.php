<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'title_en'              => 'required|string',
            'title_ar'              => 'required|string',
            'url'                   => 'required|url',
            'unit_id'               => 'required|exists:units,id',
            'lesson_note'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];
    }
}
