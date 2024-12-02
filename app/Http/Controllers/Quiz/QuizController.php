<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\SubmitAnswerRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question\Question;
use App\Models\Quiz\Quiz;
use App\Models\UserAnswer\UserAnswer;

class QuizController extends Controller
{
    public function getQuestion(Quiz $quiz)
    {
        $quiz->load('questions.choices');

        $firstQuestion = $quiz->questions->first();

        return new QuestionResource($firstQuestion);
    }


    public function submitAnswer(SubmitAnswerRequest $request, Quiz $quiz, Question $question)
    {
        $request->validated();

        $choice = $question->choices()->findOrFail($request->input('choice_id'));
        $correctChoice = $question->choices->where('is_correct', 1)->first();
        $isCorrect = $choice->is_correct;

        UserAnswer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'choice_id' => $choice->id,
        ]);

        return response()->json([
            'isCorrect' => $isCorrect,
            'correctAnswer' => $correctChoice->choice_text,
            'userAnswer' => $choice->choice_text,
        ]);
    }


    public function getNextQuestion(Quiz $quiz, $currentQuestionId)
    {
        $questions = $quiz->questions->pluck('id')->toArray();
        $nextQuestionKey = array_search($currentQuestionId, $questions) + 1;

        if ($nextQuestionKey < count($questions)) {
            $nextQuestion = $quiz->questions()->with('choices')->where('id', $questions[$nextQuestionKey])->first();

            return new QuestionResource($nextQuestion);
        }

        return response()->json([
            'message' => 'No more questions available',
        ]);
    }



    public function getScore(Quiz $quiz)
    {
        $quiz->load('questions.choices');

        $userResponses = UserAnswer::where('user_id', auth()->id())
            ->whereIn('question_id', $quiz->questions->pluck('id'))
            ->get();

        $correctAnswers = $userResponses->filter(function ($response) {
            return $response->choice->is_correct;
        })->count();

        return response()->json([
            'score' => "{$correctAnswers}/{$quiz->questions->count()}",
        ]);
    }

}
