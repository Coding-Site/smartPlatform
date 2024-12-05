<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\Lesson;

class LessonRepository
{
    public function getAll()
    {
        return Lesson::get();
    }

    public function getById($id)
    {
        return Lesson::findOrFail($id);
    }

    public function create(array $data)
    {
        $lesson = Lesson::create($data);
        foreach ($data['translations'] as $translation) {
            $lesson->translateOrNew($translation['locale'])->title = $translation['title'];
        }
        $lesson->save();
        return$lesson;
    }

    public function update($id, array $data)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($data);

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $lesson->translateOrNew($translation['locale'])->title = $translation['title'];
            }
            $lesson->save();
        }
        return $lesson;
    }

    public function delete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
    }
}

