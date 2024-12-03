<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $voiceNoteUrl = $this->getFirstMediaUrl('voice_notes');

        $response = [
            'id' => $this->id,
            'user' => $this->user->name,
            'created_at' => $this->created_at->diffForHumans(),
        ];

        if ($voiceNoteUrl) {
            $response['voice_note'] = $voiceNoteUrl;
        } else {
            $response['content'] = $this->content;
        }

        $response['replies'] = CommentResource::collection($this->whenLoaded('replies'));

        return $response;
    }
}
