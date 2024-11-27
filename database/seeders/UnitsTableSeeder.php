<?php

namespace Database\Seeders;

use App\Models\Course\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $unitsData = [
                [
                    'translations' => [
                        'en' => ['title' => 'Unit One'],
                        'ar' => ['title' => 'الوحدة الأولى'],
                    ],
                ],
                [
                    'translations' => [
                        'en' => ['title' => 'Unit Two'],
                        'ar' => ['title' => 'الوحدة الثانية'],
                    ],
                ],
                [
                    'translations' => [
                        'en' => ['title' => 'Unit Three'],
                        'ar' => ['title' => 'الوحدة الثالثة'],
                    ],
                ],
            ];

            foreach ($unitsData as $unitData) {
                $unit = $course->units()->create();

                foreach ($unitData['translations'] as $locale => $translation) {
                    $unit->translateOrNew($locale)->title = $translation['title'];
                }

                $unit->save();
            }
        }

    }
}
