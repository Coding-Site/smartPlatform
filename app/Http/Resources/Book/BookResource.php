<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name'        => $this->name,
            'price'       => $this->price,
            'file_sample' => $this->getFirstMediaUrl('file_samples'),
            'quantity'    => $this->quantity,
            'teacher'     => $this->teacher->name,
            'term'        => $this->term->id,
            'grade'       => $this->grade->name,
            'image'         => $this->getFirstMediaUrl('image'),
        ];
    }
}
