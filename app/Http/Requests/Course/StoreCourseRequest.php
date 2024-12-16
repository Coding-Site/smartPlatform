<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name_ar'               => 'required|string|max:255',
            'name_en'               => 'required|string|max:255',
            'image'                 => 'nullable|image|max:2048',
            'term_price'            => 'required|numeric',
            'monthly_price'         => 'required|numeric',
            'term_id'               => 'required|exists:terms,id',
            'teacher_id'            => 'required|exists:teachers,id',
            'stage_id'              => 'required|exists:stages,id',
            'grade_id'              => 'required|exists:grades,id',
            'type'                  => 'nullable|string|in:Scientific,Literary',
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'teacher_id' => auth()->guard('teacher')->user()->id,
        ]);
    }
}
