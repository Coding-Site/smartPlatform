<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id'      => $this->id,
            'title'   => $this->title,
            'url'     => $this->url,
            'has_quiz'=> $this->quiz()->exists(),
            'has_cards'=> $this->cards()->exists(),
            'unit_name'  => $this->unit->title,
            'note_url'    => $this->getFirstMediaUrl('lesson_note') ? url('/lesson-note/download/' . $this->id) : null,
            'comments'=> CommentResource::collection($this->comments),
        ];
    }
}
