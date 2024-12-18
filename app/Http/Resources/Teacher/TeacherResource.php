<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'type'                  => $this->type,
            'image'                 => $this->getFirstMediaUrl('image'),
            'bio'                   => $this->bio ?? null,
            'average_rating'        => round($this->averageRating(), 1),
        ];
    }
}
