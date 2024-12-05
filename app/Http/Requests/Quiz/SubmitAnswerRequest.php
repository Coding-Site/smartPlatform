<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAnswerRequest extends FormRequest
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
            'choice_id' => 'required_if:type,multiple_choice|exists:choices,id',
            'answer' => 'required_if:type,fill_in_the_blank,why|nullable|string',
            'cause' => 'required_if:type,what_happens|nullable|string',
            'effect' => 'required_if:type,what_happens|nullable|string',
            'score' => 'nullable|numeric',
        ];
    }
}
