<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
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
            'lesson_id' => 'sometimes|integer|exists:lessons,id',
            'title_ar' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'questions' => 'sometimes|array|min:1',
            'questions.*.id' => 'nullable|integer|exists:questions,id',
            'questions.*.question_text' => 'required|string|max:500',
            'questions.*.type' => 'required|string|in:multiple_choice,fill_in_the_blank,what_happens,why',
            'questions.*.correct_answer' => 'nullable|string|max:255',
            'questions.*.cause' => 'nullable|string|max:255',
            'questions.*.effect' => 'nullable|string|max:255',
            'questions.*.choices' => 'sometimes|array|min:2|required_if:questions.*.type,multiple_choice',
            'questions.*.choices.*.choice_text' => 'required_if:questions.*.type,multiple_choice|string|max:255',
            'questions.*.choices.*.is_correct' => 'required_if:questions.*.type,multiple_choice|boolean',
        ];
    }

}
