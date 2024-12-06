<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'image'       => 'nullable|image|max:2048',
            'price'       => 'required|numeric|min:0',
            'file_sample' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'quantity'    => 'required|integer|min:0',
            'teacher_id'  => 'required|exists:teachers,id',
            'term_id'     => 'required|exists:terms,id',
            'grade_id'    => 'required|exists:grades,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(input: [
            'teacher_id' => auth()->user()->id
        ]);
    }
}
