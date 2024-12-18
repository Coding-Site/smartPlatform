<?php

namespace Database\Seeders;

use App\Enums\Stage\Type;
use App\Models\Course\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($gradeId = 1; $gradeId <= 12; $gradeId++) {
            $courses = $this->getCoursesData($gradeId);

            foreach ($courses as $courseData) {
                $data = Arr::except($courseData, ['translations', 'image']);

                $course = Course::create($data);

                foreach ($courseData['translations'] as $locale => $translation) {
                    $course->translateOrNew($locale)->name = $translation['name'];
                }

                $course->save();

                if (isset($courseData['image'])) {
                    $course
                        ->addMedia(__DIR__ . '/course_imgs' . $courseData['image'])
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }
        }
    }

    /**
     * Get courses data with translations and image paths.
     */
    private function getCoursesData(int $gradeId): array
    {
        return [
            [
                'term_price'    => 200,
                'monthly_price' => 100,
                'term_end_date' => '2025-12-05',
                'teacher_id'    => 1,
                'term_id'       => 1,
                'stage_id'      => 1,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Mathematics'],
                    'ar' => ['name' => 'الرياضيات'],
                ],
                'image'         => '/math.png',
            ],
            [
                'term_price'    => 150,
                'monthly_price' => 80,
                'term_end_date' => '2025-12-05',
                'teacher_id'    => 2,
                'term_id'       => 1,
                'stage_id'      => 1,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'English Language'],
                    'ar' => ['name' => 'اللغة الإنجليزية'],
                ],
                'image'         => '/english.png',
            ],
            [
                'term_price'    => 180,
                'monthly_price' => 90,
                'term_end_date' => '2025-12-05',
                'teacher_id'    => 3,
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Literary->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Science'],
                    'ar' => ['name' => 'العلوم'],
                ],
                'image'         => '/science.png',
            ],
            [
                'term_price'    => 220,
                'monthly_price' => 110,
                'term_end_date' => '2025-12-05',
                'teacher_id'    => 1,
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Arabic Language'],
                    'ar' => ['name' => 'اللغة العربية'],
                ],
                'image'         => '/arabic.png',
            ],
            [
                'term_price'    => 210,
                'monthly_price' => 105,
                'term_end_date' => '2025-03-15',
                'teacher_id'    => 2,
                'term_id'       => 1,
                'stage_id'      => 2,
                'type'          => Type::Literary->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Geography'],
                    'ar' => ['name' => 'الجغرافيا'],
                ],
                'image'         => '/geography.png',
            ],
        ];
    }
}
