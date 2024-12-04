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
            'url'     => $this->url,
            'title'   => $this->title,
            'lesson_note' => $this->lessonNote ? $this->lessonNote->id : null,
            'comments'=> CommentResource::collection($this->comments),
        ];
    }
}
