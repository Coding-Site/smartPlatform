<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'grade'         => $this->grade->name,
            'grade_id'      => $this->grade_id,
            'image'         => $this->getFirstMediaUrl('images'),
            'term_price'    => $this->term_price,
            'monthly_price' => $this->monthly_price,
        ];
    }
}
