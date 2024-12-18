<?php

namespace App\Http\Controllers\Quiz;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Http\Resources\Quiz\QuizResource;
use App\Repositories\Quiz\QuizRepository;
use App\Models\Quiz\Quiz;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardQuizController extends Controller
{
    protected $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }


    public function index()
    {
        try {
            $quizzes = $this->quizRepository->getAll();
            return ApiResponse::sendResponse(200, 'All Quizzes', QuizResource::collection($quizzes));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch quizzes');
            }
    }


    public function store(StoreQuizRequest $request)
    {
        try {
            $validated = $request->validated();
            $quiz = $this->quizRepository->create($validated);
            return ApiResponse::sendResponse(201, 'Quiz created successfully', new QuizResource($quiz));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to create quiz: ' . $e->getMessage());
        }
    }


    public function show(Quiz $quiz)
    {
        try {
            $quiz= $this->quizRepository->findById($quiz);
            return ApiResponse::sendResponse(200, 'Quiz retrieved successfully', new QuizResource($quiz));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Quiz not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch quiz');
        }
    }


    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        try {
            $validated = $request->validated();
            $updatedQuiz = $this->quizRepository->update($quiz, $validated);
            return ApiResponse::sendResponse(200, 'Quiz updated successfully', new QuizResource($updatedQuiz));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Quiz not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to update quiz: ' . $e->getMessage());
        }
    }


    public function destroy(Quiz $quiz)
    {
        try {
            $this->quizRepository->delete($quiz);
            return ApiResponse::sendResponse(200, 'Quiz deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Quiz not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to delete quiz: ' . $e->getMessage());
        }
    }
}
