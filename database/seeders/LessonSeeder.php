<?php

namespace Database\Seeders;

use App\Models\Unit\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = Unit::all();

        foreach ($units as $unit) {
            $lessonsData = [
                [
                    'translations' => [
                        'en' => ['title' => 'Lesson One: Introduction to Programming'],
                        'ar' => ['title' => 'الدرس الأول: مقدمة في البرمجة'],
                    ],
                ],
                [
                    'translations' => [
                        'en' => ['title' => 'Lesson Two: Understanding Variables'],
                        'ar' => ['title' => 'الدرس الثاني: فهم المتغيرات'],
                    ],
                ],
                [
                    'translations' => [
                        'en' => ['title' => 'Lesson Three: Functions and Loops'],
                        'ar' => ['title' => 'الدرس الثالث: الدوال والحلقات'],
                    ],
                ],
            ];

            foreach ($lessonsData as $lessonData) {
                $url = 'https://example.com/lessons/' . Str::slug($lessonData['translations']['en']['title']);

                $lesson = $unit->lessons()->create([
                    'url' => $url,
                ]);

                foreach ($lessonData['translations'] as $locale => $translation) {
                    $lesson->translateOrNew($locale)->title = $translation['title'];
                }

                $lesson->save();
            }
        }
    }
}
