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

        // like end point
        // $unit_name
        $voiceNoteUrl = $this->getFirstMediaUrl('voice_notes');
            // count of likes
        $response = [
            'id' => $this->id,
            'created_at' => $this->created_at->diffForHumans(),
        ];

        if ($this->teacher_id) {
            $response['teacher_name'] = $this->teacher ? $this->teacher->name : null;
            $response['image']        = $this->teacher ? $this->getFirstMediaUrl('image') : null;
            //image
        } else {
            $response['user_name'] = $this->user ? $this->user->name : null;
            $response['image']        = $this->user ? $this->user->image : null;

            // image
        }

        if ($voiceNoteUrl) {
            $response['voice_note'] = $voiceNoteUrl;
        } else {
            $response['content'] = $this->content;
        }

        if ($this->replies->isNotEmpty()) {
            $response['replies'] = CommentResource::collection($this->replies);
        }
        return $response;
    }
}
