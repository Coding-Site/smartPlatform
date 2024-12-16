<?php

namespace App\Http\Resources\Package;

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
            'description' => $this->description,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'expiry_day' => $this->expiry_day,
            'grade'       => $this->grade->name,
            'is_active' => $this->is_active,
            'courses'   => $this->courses->pluck('name'),
            'books'     => $this->books->pluck('name'),

        ];
    }
}
