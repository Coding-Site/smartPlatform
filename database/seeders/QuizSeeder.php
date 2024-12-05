<?php

// database/seeders/QuizSeeder.php
namespace Database\Seeders;

use App\Enums\Question\Type;
use App\Models\Choice\Choice;
use App\Models\Question\Question;
use App\Models\Quiz\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $quiz = Quiz::create([
            'title' => 'Sample Quiz: General Knowledge',
            'lesson_id' => 1,
        ]);

        $question1 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'What is the capital of France?',
            'type' => Type::MultipleChoice->value,
        ]);

        $choices1 = [
            'Paris',
            'London',
            'Berlin',
            'Rome',
        ];

        foreach ($choices1 as $choiceText) {
            Choice::create([
                'question_id' => $question1->id,
                'choice_text' => $choiceText,
                'is_correct' => $choiceText === 'Paris',
            ]);
        }

        $question2 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'The largest planet in our solar system is ______.',
            'type' => Type::FillInTheBlank->value,
            'correct_answer' => 'Jupiter',
        ]);

        $question3 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Why is the sky blue?',
            'type' => Type::Why->value,
            'correct_answer' => 'The sky appears blue because of the scattering of sunlight by air molecules.'
        ]);

        $question4 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'What happens if you drop a stone in water?',
            'type' => Type::WhatHappens->value,
            'cause' => 'The stone is dropped in water.',
            'effect' => 'The stone sinks in the water.',
        ]);

        $this->command->info("Sample quiz and questions seeded successfully!");
    }
}
