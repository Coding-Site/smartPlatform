<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'term_price'            => 'required|numeric',
            'monthly_price'         => 'required|numeric',
            'term_id'               => 'required|exists:terms,id',
            'grade_id'              => 'required|exists:grades,id',
            'translations'          => 'required|array',
            'translations.*.locale' => 'required|string|max:2',
            'translations.*.name'   => 'required|string|max:255',
        ];
    }

}