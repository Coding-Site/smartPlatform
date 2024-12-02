<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'     => $this->course ? 'course' : 'note',
            'name'     => $this->course ? $this->course->name : $this->note->name,
            'quantity' => $this->quantity,
        ];
    }
}
