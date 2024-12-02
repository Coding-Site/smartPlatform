<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'cart_token'  => $this->cart_token,
            'items'       => CartItemResource::collection($this->items),
            'total_price' => $this->items->sum(function ($item) {
                return $item->price * $item->quantity;
            }),
        ];

    }
}
