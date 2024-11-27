<?php
namespace App\Repositories\Course;

use App\Models\Course\Course;

class CourseRepository
{
    public function getAll()
    {
        return Course::with('translations')->get();
    }

    public function findById($id)
    {
        return Course::with('translations')->findOrFail($id);
    }

    public function create(array $data): Course
    {
        $course = Course::create($data);

        foreach ($data['translations'] as $translation) {
            $course->translateOrNew($translation['locale'])->name = $translation['name'];
        }

        $course->save();

        return $course;
    }

    public function update($id, array $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $course->translateOrNew($translation['locale'])->name = $translation['name'];
            }
            $course->save();
        }

        return $course;
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
    }
}
