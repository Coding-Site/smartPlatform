<?php
namespace App\Repositories\Course;

use App\Models\Course\Course;
use Illuminate\Support\Facades\Auth;

class CourseRepository
{
    public function getAll()
    {
        $teacherId = Auth::id();
        return Course::where('teacher_id', $teacherId)->get();
    }

    public function findById($id)
    {
        return Course::with('units')->with('translations')->findOrFail($id);
    }

    public function create(array $data): Course
    {
        $teacherId = Auth::id();
        $course = Course::create($data);

        $course->translateOrNew('ar')->name = $data['name_ar'];
        $course->translateOrNew('en')->name = $data['name_en'];

        if (isset($data['image'])) {
            $course->addMedia($data['image'])->toMediaCollection('images');
        }

        if (isset($data['icon'])) {
            $course->addMedia($data['icon'])->toMediaCollection('icons');
        }

        $course->save();
        $course->teachers()->attach($teacherId);

        return $course;
    }

    public function update($id, array $data)
    {
        $teacherId = Auth::id();
        $course = Course::findOrFail($id);

        $course->update($data);

        if (!empty($data['name_ar'])) {
            $course->translateOrNew('ar')->name = $data['name_ar'];
        }

        if (!empty($data['name_en'])) {
            $course->translateOrNew('en')->name = $data['name_en'];
        }

        if (isset($data['image'])) {
            $course->clearMediaCollection('image');
            $course->addMedia($data['image'])->toMediaCollection('images');
        }

        if (isset($data['icon'])) {
            $course->clearMediaCollection('icon');
            $course->addMedia($data['icon'])->toMediaCollection('icons');
        }

        $course->save();
        if (!$course->teachers()->where('teacher_id', $teacherId)->exists()) {
            $course->teachers()->attach($teacherId);
        }

        return $course;
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
    }
}
