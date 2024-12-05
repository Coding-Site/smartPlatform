<?php

namespace App\Http\Resources\Unit;

use App\Http\Resources\Lesson\LessonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'title'     => $this->title,
            
            // 'translations'  => $this->translations->map(function ($translation) {
            //         return [
            //             'locale' => $translation->locale,
            //             'name'   => $translation->title,
            //         ];
            //     }),
            // 'lessons'   => LessonResource::collection($this->lessons),
        ];
    }
}
