<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Unit\UnitResource;
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
                'term_price'    => $this->term_price,
                'monthly_price' => $this->monthly_price,
                'term'          => $this->term->name ?? null,
                'teacher'       => $this->teacher->name ?? null,
                'grade'         => $this->grade->name ?? null,
                'name'          => $this->name,
                'units'         => UnitResource::collection($this->units),
                // 'translations'  => $this->translations->map(function ($translation) {
                //     return [
                //         'locale' => $translation->locale,
                //         'name'   => $translation->name,
                //     ];
                // }),
            ];
        }
}