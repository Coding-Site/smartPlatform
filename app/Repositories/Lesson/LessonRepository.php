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

        $lesson->translateOrNew('en')->title = $data['title_en'];
        $lesson->translateOrNew('ar')->title = $data['title_ar'];

        if (isset($data['lesson_note'])) {
            $lesson->addMedia($data['lesson_note'])
                ->toMediaCollection('lesson_note');
        }

        $lesson->save();
        return$lesson;
    }


    public function update($id, array $data)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($data);

        if (!empty($data['title_en'])) {
            $lesson->translateOrNew('en')->title = $data['title_en'];
        }

        if (!empty($data['title_ar'])) {
            $lesson->translateOrNew('ar')->title = $data['title_ar'];
        }

        if (isset($data['lesson_note'])) {
            $lesson->clearMediaCollection('lesson_note');
            $lesson->addMedia($data['lesson_note'])
                ->toMediaCollection('lesson_note');
        }

        $lesson->save();
        return $lesson;
    }


    public function delete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
    }
}

