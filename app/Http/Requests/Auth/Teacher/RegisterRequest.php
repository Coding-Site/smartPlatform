<?php

namespace App\Http\Requests\Auth\Teacher;

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
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'email'     => ['required', 'email', new UniqueEmailAcrossGuards],
            'password'  => 'required|string|min:8|confirmed',
            'phone'     => ['required','unique:teachers,phone','digits:8','min:8','max:8'],
            'years_of_experience' => 'nullable|integer|min:0',
            'video_preview'       => 'nullable|url',
            'grade_id'            => 'required|string',
            'specialization'      => 'required|string',
            'type'                => 'nullable|string|in:online_course,recorded_course,private_teacher',
            'video_profit_rate'   => 'nullable|int',
            'book_profit'         => 'nullable|int',
            'bio_ar'              => 'nullable|string|max:500',
            'bio_en'              => 'nullable|string|max:500',
            'description_ar'      => 'nullable|string',
            'description_en'      => 'nullable|string',
        ];

    }
}
