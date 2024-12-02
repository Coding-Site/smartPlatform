<?php

namespace Database\Seeders;

use App\Models\Grade\Grade;
use App\Models\Stage\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            [
                'stage_id' => 1,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class One'],
                    'ar' => ['name' => 'الصف الاول'],
                ],
            ],
            [
                'stage_id' => 1,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Two'],
                    'ar' => ['name' => 'الصف الثاني'],
                ],
            ],
            [
                'stage_id' => 1,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Three'],
                    'ar' => ['name' => 'الصف الثالث'],
                ],
            ],
            [
                'stage_id' => 1,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Four'],
                    'ar' => ['name' => 'الصف الرابع'],
                ]
                ],
            [
                'stage_id' => 1,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Five'],
                    'ar' => ['name' => 'الصف الخامس'],
                ],
            ],
            [
                'stage_id' => 2,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Six'],
                    'ar' => ['name' => 'الصف السادس'],
                ],
            ],
            [
                'stage_id' => 2,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Seven'],
                    'ar' => ['name' => 'الصف السابع'],
                ],
            ],
            [
                'stage_id' => 2,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Eight'],
                    'ar' => ['name' => 'الصف الثامن'],
                ],
            ],
            [
                'stage_id' => 2,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Nine'],
                    'ar' => ['name' => 'الصف التاسع'],
                ],
            ],
            [
                'stage_id' => 3,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Ten'],
                    'ar' => ['name' => 'الصف العاشر'],
                ],
            ],
            [
                'stage_id' => 3,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Eleven'],
                    'ar' => ['name' => 'الصف الحادي عشر'],
                ],
            ],
            [
                'stage_id' => 3,
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Class Twelve'],
                    'ar' => ['name' => 'الصف الثاني عشر'],
                ],
            ],
        ];

        foreach ($grades as $grade) {
            $class = Grade::create(['stage_id' => $grade['stage_id'], 'term_id' => $grade['term_id']]);

            foreach ($grade['translations'] as $locale => $translation) {
                $class->translateOrNew($locale)->name = $translation['name'];
            }

            $class->save();
        }
    }
    }

