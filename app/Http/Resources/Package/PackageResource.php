<?php

namespace App\Http\Resources\Package;

use App\Enums\Package\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'expiry_day' => $this->expiry_day,
            'grade' => $this->grade->name,
            'stage' => $this->stage->name,
            'is_active' => $this->is_active,
            'courses' => $this->courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            }),
            'books' => $this->books->map(function ($book) {
                return [
                    'id' => $book->id,
                    'name' => $book->name,
                ];
            }),
        ];
    }
}
