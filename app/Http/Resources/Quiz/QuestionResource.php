<?php

namespace App\Http\Resources\Quiz;

use App\Enums\Question\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'id' => $this->id,
                'question_text' => $this->question_text,
                'choices' => $this->when($this->type === Type::MultipleChoice, ChoiceResource::collection($this->choices)),
            ];
    }
}
