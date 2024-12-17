<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'expiry_day' => 'nullable|date',
            'grade_id' => 'required|exists:grades,id',
            'stage_id' => 'required|exists:stages,id',
            'is_active' => 'required|boolean',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
            'book_ids' => 'nullable|array',
            'book_ids.*' => 'exists:books,id',
        ];
    }
}
