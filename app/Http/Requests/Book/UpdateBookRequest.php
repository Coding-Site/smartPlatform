<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'name'        => 'sometimes|required|string|max:255',
            'price'       => 'sometimes|required|numeric|min:0',
            'file_sample' => 'nullable |file|mimes:pdf,doc,docx|max:2048',
            'quantity'    => 'sometimes|required|integer|min:0',
            'term_id'     => 'sometimes|required|exists:terms,id',
            'grade_id'    => 'sometimes|required|exists:grades,id',
        ];
    }
}
