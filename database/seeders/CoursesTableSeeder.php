<?php

namespace Database\Seeders;

use App\Enums\Stage\Type;
use App\Models\Course\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($gradeId = 1; $gradeId <= 12; $gradeId++) {
            $courses = [
                [
                    'term_price'    => 200,
                    'monthly_price' => 100,
                    'term_end_date' => '2025-12-05',
                    'teacher_id' => 1,
                    'term_id' => 1,
                    'stage_id' => 1,
                    'type' => Type::Scientific->value,
                    'grade_id' => $gradeId,

                    'translations' => [
                        'en' => ['name' => 'Mathematics'],
                        'ar' => ['name' => 'الرياضيات'],
                    ],
                ],
                [
                    'term_price' => 150,
                    'monthly_price' => 80,
                    'term_end_date' => '2025-12-05',
                    'teacher_id' => 2,
                    'term_id' => 1,
                    'stage_id' => 1,
                    'type' => Type::Scientific->value,
                    'grade_id' => $gradeId,
                    'translations' => [
                        'en' => ['name' => 'English Language'],
                        'ar' => ['name' => 'اللغة الإنجليزية'],
                    ],
                ],
                [
                    'term_price' => 180,
                    'monthly_price' => 90,
                    'term_end_date' => '2025-12-05',
                    'teacher_id' => 3,
                    'term_id' => 1,
                    'stage_id' => 3,
                    'type' => Type::Literary->value,
                    'grade_id' => $gradeId,
                    'translations' => [
                        'en' => ['name' => 'Science'],
                        'ar' => ['name' => 'العلوم'],
                    ],
                ],
                [
                    'term_price' => 220,
                    'monthly_price' => 110,
                    'term_end_date' => '2025-12-05',
                    'teacher_id' => 1,
                    'term_id' => 1,
                    'stage_id' => 3,
                    'grade_id' => $gradeId,
                    'translations' => [
                        'en' => ['name' => 'History'],
                        'ar' => ['name' => 'التاريخ'],
                    ],
                ],
                [
                    'term_price'    => 210,
                    'monthly_price' => 105,
                    'term_end_date' => '2025-03-15',
                    'teacher_id'    => 2,
                    'term_id'       => 1,
                    'stage_id'      => 2,
                    'grade_id'      => $gradeId,
                    'translations'  => [
                        'en' => ['name' => 'Geography'],
                        'ar' => ['name' => 'الجغرافيا'],
                    ],
                ],
            ];

            foreach ($courses as $courseData) {
                $course = Course::create([
                    'term_price'    => $courseData['term_price'],
                    'monthly_price' => $courseData['monthly_price'],
                    'term_end_date' => $courseData['term_end_date'],
                    'teacher_id'    => $courseData['teacher_id'],
                    'term_id'       => $courseData['term_id'],
                    'stage_id'      => $courseData['stage_id'],
                    'type' => $courseData['type'] ?? Type::Scientific->value,
                    'grade_id'      => $courseData['grade_id'],
                ]);

                foreach ($courseData['translations'] as $locale => $translation) {
                    $course->translateOrNew($locale)->name = $translation['name'];
                }

                $course->save();
            }
        }
    }
}
