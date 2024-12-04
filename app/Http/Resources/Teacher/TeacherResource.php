<?php

namespace App\Http\Resources\Teacher;

use App\Http\Resources\Course\CourseResource;
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
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'courses'   => CourseResource::collection($this->courses),
            'stage'     => $this->stage->name,
            "token"     => $this->when(isset($this->token), $this->token),
        ];
    }
}
