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
            'image'     => 'nullable|image|max:2048',
            'email'     => 'sometimes|email|unique:teachers,email,',
            'phone'     => [
                'nullable',
                'unique:teachers,phone,',
                'regex:/(01)[0-9]{9}/',
                'digits:11',
                'min:11',
                'max:11',
            ],
            'bio'       => 'sometimes|string|max:255',
            'description'         => 'sometimes|string',
            'years_of_experience' => 'sometimes|integer|min:0',
            'video_preview'       => 'sometimes|url',
        ];
    }
}
