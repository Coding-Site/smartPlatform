<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Course\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'course_id' => $this->course_id,
            'book_id'   => $this->book_id,
            'price'     => $this->price,
            'quantity'  => $this->quantity,
            // 'course'    => $this->course ? new CourseResource($this->course) : null,
        ];
    }
}
