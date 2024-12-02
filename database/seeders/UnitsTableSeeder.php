<?php

namespace Database\Seeders;

use App\Models\Unit\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseIds = DB::table('courses')->pluck('id');

        foreach ($courseIds as $courseId) {
            $units = [
                [
                    'course_id' => $courseId,
                    'translations' => [
                        'en' => ['title' => 'Introduction to Programming'],
                        'ar' => ['title' => 'مقدمة في البرمجة'],
                    ],
                ],
                [
                    'course_id' => $courseId,
                    'translations' => [
                        'en' => ['title' => 'Advanced Programming Concepts'],
                        'ar' => ['title' => 'مفاهيم البرمجة المتقدمة'],
                    ],
                ],
                [
                    'course_id' => $courseId,
                    'translations' => [
                        'en' => ['title' => 'Object-Oriented Programming'],
                        'ar' => ['title' => 'البرمجة كائنية التوجه'],
                    ],
                ],
            ];

            foreach ($units as $unitData) {
                $unit = Unit::create([
                    'course_id' => $unitData['course_id'],
                ]);

                foreach ($unitData['translations'] as $locale => $translation) {
                    DB::table('unit_translations')->insert([
                        'unit_id' => $unit->id,
                        'locale' => $locale,
                        'title' => $translation['title'],
                    ]);
                }
            }
        }
    }
}
