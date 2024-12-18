<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'lesson_id' => 'required|integer|exists:lessons,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:500',
            'questions.*.type' => 'required|string|in:multiple_choice,fill_in_the_blank,what_happens,why',
            'questions.*.correct_answer' => 'nullable|string|max:255',
            'questions.*.cause' => 'nullable|string|max:255',
            'questions.*.effect' => 'nullable|string|max:255',
            'questions.*.choices' => 'nullable|array|min:2',
            'questions.*.choices.*.choice_text' => 'required|string|max:255',
            'questions.*.choices.*.is_correct' => 'required|boolean',
        ];
    }


    protected function prepareForValidation()
    {
        $data = $this->all();

        if (isset($data['questions']) && is_array($data['questions'])) {
            foreach ($data['questions'] as $index => $question) {
                if ($question['type'] !== 'multiple_choice') {
                    unset($data['questions'][$index]['choices']);
                }
            }
        }

        $this->merge($data);
    }




}
