<?php

namespace App\Http\Requests\Auth\Student;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender'   => 'in:male,female',
            'grade'    => 'required|integer',
            'stage'    => 'required|string',
            'phone' => [
                'required',
                'unique:users,phone,',
                'regex:/(01)[0-9]{9}/',
                'digits:11',
                'min:11',
                'max:11',
            ],
        ];
    }
}