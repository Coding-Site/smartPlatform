<?php

namespace App\Http\Controllers\Quiz;

use App\Enums\Question\Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\SubmitAnswerRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question\Question;
use App\Models\Quiz\Quiz;
use App\Models\UserAnswer\UserAnswer;
use App\Helpers\ApiResponse;

class QuizController extends Controller
{
    public function getQuestion(Quiz $quiz)
    {
        $quiz->load('questions.choices');

        $firstQuestion = $quiz->questions->first();

        return ApiResponse::sendResponse(200, 'First question retrieved successfully', new QuestionResource($firstQuestion));
    }

    public function submitAnswer(SubmitAnswerRequest $request, Quiz $quiz, Question $question)
    {
        $request->validated();

        $answer = null;
        $storedCorrectAnswer = '';

        if ($question->type === Type::MultipleChoice) {
            $choice = $question->choices()->findOrFail($request->input('choice_id'));
            $storedCorrectAnswer = $question->choices->where('is_correct', 1)->first()->choice_text;
            $answer = $choice->choice_text;

            UserAnswer::create([
                'user_id' => auth()->id(),
                'question_id' => $question->id,
                'choice_id' => $choice->id,
            ]);
        }

        if ($question->type === Type::FillInTheBlank || $question->type === Type::Why) {
            $userAnswer = $request->input('answer');
            $storedCorrectAnswer = $question->correct_answer;
            $answer = $userAnswer;

            UserAnswer::create([
                'user_id' => auth()->id(),
                'question_id' => $question->id,
                'answer' => $userAnswer,
            ]);
        }

        if ($question->type === Type::WhatHappens) {
            $cause = $request->input('cause');
            $effect = $request->input('effect');
            $storedCorrectAnswer = "Cause: {$question->cause}, Effect: {$question->effect}";
            $answer = "Cause: {$cause}, Effect: {$effect}";

            UserAnswer::create([
                'user_id' => auth()->id(),
                'question_id' => $question->id,
                'cause' => $cause,
                'effect' => $effect,
            ]);
        }

        return ApiResponse::sendResponse(200, 'Answer submitted successfully', [
            'answer' => $answer,
            'storedCorrectAnswer' => $storedCorrectAnswer,
        ]);
    }
    public function getNextQuestion(Quiz $quiz, $currentQuestionId)
    {
        $questions = $quiz->questions->pluck('id')->toArray();

        $nextQuestionKey = array_search($currentQuestionId, $questions) + 1;

        if ($nextQuestionKey < count($questions)) {
            $nextQuestion = $quiz->questions()->where('id', $questions[$nextQuestionKey])->first();

            if ($nextQuestion->type === Type::MultipleChoice->value) {
                $nextQuestion->load('choices');
            }

            return ApiResponse::sendResponse(200, 'Next question retrieved successfully', new QuestionResource($nextQuestion));
        }


        return ApiResponse::sendResponse(200, 'No more questions available');
    }

    public function submitSelfAssessmentScore(SubmitAnswerRequest $request, Quiz $quiz, Question $question)
    {
        $score = $request->input('score');

        $userAnswer = UserAnswer::where('user_id', auth()->id())
            ->where('question_id', $question->id)
            ->first();

        if ($userAnswer) {
            $userAnswer->score = $score;
            $userAnswer->save();
        }

        return ApiResponse::sendResponse(200, 'Self-assessment score submitted successfully');
    }
        public function getScore(Quiz $quiz)
    {
        $quiz->load('questions.choices');
        $userResponses = UserAnswer::where('user_id', auth()->id())
            ->whereIn('question_id', $quiz->questions->pluck('id'))
            ->get();

        $correctAnswers = $userResponses->filter(function ($response) {
            return $response->choice && $response->choice->is_correct;
        })->count();

        $selfAssessmentScore = $userResponses->sum('score');

        $totalScore = $correctAnswers + $selfAssessmentScore;

        return ApiResponse::sendResponse(200, 'Score retrieved successfully', [
            'score' => "{$totalScore}/{$quiz->questions->count()}"
        ]);
    }
}
