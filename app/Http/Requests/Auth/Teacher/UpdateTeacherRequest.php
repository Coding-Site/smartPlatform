<?php

namespace App\Http\Requests\Auth\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'name'      => 'sometimes|string|max:255',
            'email'     => 'sometimes|email|unique:teachers,email,' ,
            'course_id' => 'sometimes|exists:courses,id',
            'stage_id'  => 'sometimes|exists:stages,id',
            'bio'       => 'sometimes|string|max:255'
        ];
    }
}
