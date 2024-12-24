<?php

namespace Database\Seeders;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitIds = DB::table('units')->pluck('id');

        foreach ($unitIds as $unitId) {
            $lessons = [
                [

                    'url' => '1041921686',
                    'is_free' => true,
                    'unit_id' => $unitId,
                    'translations' => [
                        'en' => ['title' => 'Introduction to Programming'],
                        'ar' => ['title' => 'مقدمة في البرمجة'],
                    ],
                ],
                [
                    'url' => '1031513196',
                    'is_free' => false,
                    'unit_id' => $unitId,
                    'translations' => [
                        'en' => ['title' => 'Advanced Programming Concepts'],
                        'ar' => ['title' => 'مفاهيم البرمجة المتقدمة'],
                    ],
                ],
                [
                    'url' => '1041919586',
                    'is_free' => false,
                    'unit_id' => $unitId,
                    'translations' => [
                        'en' => ['title' => 'Object-Oriented Programming'],
                        'ar' => ['title' => 'البرمجة كائنية التوجه'],
                    ],
                ],
            ];

            foreach ($lessons as $lessonData) {
                $lesson = Lesson::create([
                    'url' => $lessonData['url'],
                    'is_free' => $lessonData['is_free'],
                    'unit_id' => $lessonData['unit_id'],
                ]);

                foreach ($lessonData['translations'] as $locale => $translation) {
                    DB::table('lesson_translations')->insert([
                        'lesson_id' => $lesson->id,
                        'locale' => $locale,
                        'title' => $translation['title'],
                    ]);
                }

                $lesson->save();
            }
        }
    }
}
