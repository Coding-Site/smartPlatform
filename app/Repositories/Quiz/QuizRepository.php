<?php

namespace App\Repositories\Quiz;

use App\Models\Quiz\Quiz;
use Illuminate\Support\Facades\Auth;

class QuizRepository
{
    protected $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function getAll()
    {
        $teacherId = Auth::id();
        return $this->quiz->whereHas('lesson.unit.course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();
    }


    public function findById(Quiz $quiz)
    {
        return $quiz;
    }


    public function create(array $data)
    {
        $quiz = $this->quiz->create($data);

        $quiz->translateOrNew('en')->title = $data['title_en'];
        $quiz->translateOrNew('ar')->title = $data['title_ar'];
        $quiz->save();

        if (isset($data['questions'])) {
            foreach ($data['questions'] as $questionData) {
                $question = $quiz->questions()->create($questionData);

                if (isset($questionData['choices'])) {
                    foreach ($questionData['choices'] as $choiceData) {
                        $question->choices()->create($choiceData);
                    }
                }
            }
        }
        return $quiz;
    }


    public function update(Quiz $quiz, array $data)
    {
        $quiz->update($data);

        if (!empty($data['title_en'])) {
            $quiz->translateOrNew('en')->title = $data['title_en'];
        }

        if (!empty($data['title_ar'])) {
            $quiz->translateOrNew('ar')->title = $data['title_ar'];
        }

        if (isset($data['questions'])) {
            $quiz->questions()->delete();
            foreach ($data['questions'] as $questionData) {
                $question = $quiz->questions()->create($questionData);

                if (isset($questionData['choices'])) {
                    foreach ($questionData['choices'] as $choiceData) {
                        $question->choices()->create($choiceData);
                    }
                }
            }
        }

        return $quiz;
    }


    public function delete(Quiz $quiz)
    {
        return $quiz->delete();
    }
}
