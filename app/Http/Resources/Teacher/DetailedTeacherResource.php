<?php

namespace App\Http\Resources\Teacher;

use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Review\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        $totalUsers = $this->courses->sum(function ($course) {
//            return $course->users->count();
//        });

        $totalVideos = $this->courses->sum(function ($course) {
            return $course->units->sum(function ($unit) {
                return $unit->lessons->count();
            });
        });


        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
            'image'                 => $this->getFirstMediaUrl('image'),
            'bio'                   => $this->bio ?? null,
            'description'           => $this->description ?? null,
            'years_of_experience'   => $this->years_of_experience ?? null,
            'average_rating'        => round($this->averageRating(), 1),
            'stage'                 => $this->stage->translations->firstWhere('locale', request()->get('lang', app()->getLocale()))->name ,
           // 'totalUsers'            => $totalUsers,
            'totalVideos'           => $totalVideos,
            'courses'               => CourseResource::collection($this->courses),
            'reviews'               => ReviewResource::collection($this->reviews),
        ];

    }
}
