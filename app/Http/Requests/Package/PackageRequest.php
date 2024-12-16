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
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'expiry_day' => 'nullable|date',
            'grade_id' => 'required|exists:grades,id',
            'stage_id' => 'required|exists:stages,id',
            'is_active' => 'required|boolean',
        ];
    }
}
