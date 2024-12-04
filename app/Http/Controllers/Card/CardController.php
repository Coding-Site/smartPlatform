<?php

namespace App\Http\Controllers\Card;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Card\CardResource;
use App\Models\Card\Card;
use App\Models\Lesson\Lesson;

class CardController extends Controller
{
    public function get(Lesson $lesson)
    {
        $cards = $lesson->cards;

        return ApiResponse::sendResponse(200,'Cards retrieved successfully', CardResource::collection($cards));
    }

    public function save(Card $card)
    {
        $card->update(['status' => 1]);

        return ApiResponse::sendResponse(200, 'Card saved successfully');
    }

    public function forget(Card $card)
    {
        $card->update(['status' => 0]);

        return ApiResponse::sendResponse(200, 'Card forgotten successfully');    }

    public function calculateScore(Lesson $lesson)
    {
        $totalCards = $lesson->cards()->count();

        $savedCards = $lesson->cards()->where('status', 1)->count();

        return ApiResponse::sendResponse(200, 'Completed successfully', [
            'score' => "{$savedCards}/{$totalCards}"
        ]);
    }
}
