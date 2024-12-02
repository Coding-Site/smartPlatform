<?php

namespace Database\Seeders;

use App\Models\Choice\Choice;
use App\Models\Lesson\Lesson;
use App\Models\Question\Question;
use App\Models\Quiz\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $quiz1 = Quiz::create([
            'title' => 'Mcq Quiz for Course 1',
            'lesson_id' =>1,
        ]);

        $question1 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What is the capital of France?',
        ]);

        Choice::create([
            'question_id' => $question1->id,
            'choice_text' => 'Paris',
            'is_correct' => true
        ]);
        Choice::create([
            'question_id' => $question1->id,
            'choice_text' => 'Berlin',
            'is_correct' => false
        ]);
        Choice::create([
            'question_id' => $question1->id,
            'choice_text' => 'Madrid',
            'is_correct' => false
        ]);
        Choice::create([
            'question_id' => $question1->id,
            'choice_text' => 'Rome',
            'is_correct' => false
        ]);

        $question2 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which planet is known as the Red Planet?',
        ]);

        Choice::create([
            'question_id' => $question2->id,
            'choice_text' => 'Mars',
            'is_correct' => true
        ]);
        Choice::create([
            'question_id' => $question2->id,
            'choice_text' => 'Venus',
            'is_correct' => false
        ]);
        Choice::create([
            'question_id' => $question2->id,
            'choice_text' => 'Jupiter',
            'is_correct' => false
        ]);
        Choice::create([
            'question_id' => $question2->id,
            'choice_text' => 'Saturn',
            'is_correct' => false
        ]);
    }
}
