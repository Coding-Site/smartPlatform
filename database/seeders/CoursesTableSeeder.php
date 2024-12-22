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
        for ($gradeId = 6; $gradeId <= 12; $gradeId++) {
            $courses = $this->getCoursesData($gradeId);

            foreach ($courses as $courseData) {
                $data = Arr::except($courseData, ['translations', 'image', 'icon']);
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

                if (isset($courseData['icon'])) {
                    $course
                        ->addMedia(__DIR__ . '/course_icons' . $courseData['icon'])
                        ->preservingOriginal()
                        ->toMediaCollection('icons');
                }
            }
        }
    }

    private function getCoursesData(int $gradeId): array
    {
        $commonCourses = [
            [
                'term_price'    => 200,
                'monthly_price' => 100,
                'term_end_date' => '2025-12-05',
                'term_id'       => 1,
                'stage_id'      => 2,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Mathematics'],
                    'ar' => ['name' => 'الرياضيات'],
                ],
                'image'         => '/math.png',
                'icon'          => '/Math-icon.png',
            ],
            [
                'term_price'    => 150,
                'monthly_price' => 80,
                'term_end_date' => '2025-12-05',
                'term_id'       => 1,
                'stage_id'      => 2,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'English Language'],
                    'ar' => ['name' => 'اللغة الإنجليزية'],
                ],
                'image'         => '/english.png',
                'icon'          => '/Eng-icon.png',
            ],
            [
                'term_price'    => 180,
                'monthly_price' => 90,
                'term_end_date' => '2025-12-05',
                'term_id'       => 1,
                'stage_id'      => 2,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Science'],
                    'ar' => ['name' => 'العلوم'],
                ],
                'image'         => '/science.png',
                'icon'          => '/Science-icon.png',
            ],
            [
                'term_price'    => 220,
                'monthly_price' => 110,
                'term_end_date' => '2025-12-05',
                'term_id'       => 1,
                'stage_id'      => 2,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Arabic Language'],
                    'ar' => ['name' => 'اللغة العربية'],
                ],
                'image'         => '/arabic.png',
                'icon'          => '/arabic-icon.png',
            ],
            [
                'term_price'    => 210,
                'monthly_price' => 105,
                'term_end_date' => '2025-03-15',
                'term_id'       => 1,
                'stage_id'      => 2,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Social Studies'],
                    'ar' => ['name' => 'الدراسات الاجتماعية'],
                ],
                'image'         => '/social_studies.png',
                'icon'          => '/Social-icon.png',
            ],
        ];

        $additionalCourses = $gradeId >= 10 ? [
            [
                'term_price'    => 200,
                'monthly_price' => 100,
                'term_end_date' => '2025-06-10',
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Chemistry'],
                    'ar' => ['name' => 'الكيمياء'],
                ],
             //   'image'         => '/chemistry.png',
              //  'icon'          => '/Chem-icon.png',
            ],
            [
                'term_price'    => 250,
                'monthly_price' => 120,
                'term_end_date' => '2025-06-10',
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Physics'],
                    'ar' => ['name' => 'الفيزياء'],
                ],
              //  'image'         => '/physics.png',
              //  'icon'          => '/Physics-icon.png',
            ],
            [
                'term_price'    => 220,
                'monthly_price' => 110,
                'term_end_date' => '2025-06-10',
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Literary->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'History'],
                    'ar' => ['name' => 'التاريخ'],
                ],
              //  'image'         => '/history.png',
              // 'icon'          => '/Hist-icon.png',
            ],
            [
                'term_price'    => 230,
                'monthly_price' => 115,
                'term_end_date' => '2025-06-10',
                'term_id'       => 1,
                'stage_id'      => 3,
                'type'          => Type::Scientific->value,
                'grade_id'      => $gradeId,
                'translations'  => [
                    'en' => ['name' => 'Biology'],
                    'ar' => ['name' => 'الأحياء'],
                ],
              //  'image'         => '/biology.png',
              //  'icon'          => '/Bio-icon.png',
            ],
        ] : [];

        if ($gradeId >= 6 && $gradeId <= 9) {
            $commonCourses = array_map(fn ($course) => Arr::except($course, ['type']), $commonCourses);
        }

        return array_merge($commonCourses, $additionalCourses);
    }
}
