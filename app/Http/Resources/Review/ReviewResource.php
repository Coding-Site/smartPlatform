<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user'        => [
                'name' => $this->user->name,
                'image'  => $this->user->getFirstMediaUrl('image'),
                'stage'  => $this->user->stage->translations->firstWhere('locale', request()->get('lang', app()->getLocale()))->name ,
            ],
            'review'      => $this->review,
        ];
    }
}
