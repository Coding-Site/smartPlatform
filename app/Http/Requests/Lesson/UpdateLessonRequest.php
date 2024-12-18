<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'url'                   => 'required|url',
            // 'unit_id'               => 'required|exists:units,id',
            'translations'          => 'nullable|array',
            'translations.*.locale' => 'nullable|string|max:2',
            'translations.*.title'  => 'nullable|string|max:255',
        ];
    }
}
