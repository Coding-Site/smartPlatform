<?php

namespace App\Http\Requests\Auth\Student;

use App\Rules\UniqueEmailAcrossGuards;
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
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', new UniqueEmailAcrossGuards],
            'password'    => 'required|string|min:8|confirmed',
            'grade_id'    => 'required|string|exists:grades,id',
            'stage_id'    => 'required|string|exists:stages,id',
            'phone'       => ['required','unique:users,phone','digits:8','min:8','max:8'],
            'image'       => 'nullable|image|max:2048',
        ];
    }
}
