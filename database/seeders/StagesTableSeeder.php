<?php

namespace Database\Seeders;

use App\Models\Stage\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Primary School'],
                    'ar' => ['name' => 'المرحلة الابتدائية'],
                ],
            ],
            [
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Preparatory School'],
                    'ar' => ['name' => 'المرحلة الاعدادية'],
                ],
            ],
            [
                'term_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Middle School'],
                    'ar' => ['name' => 'المرحلة المتوسطة'],
                ],
            ],
            [
                'term_id' => 2,
                'translations' => [
                    'en' => ['name' => 'Primary School'],
                    'ar' => ['name' => 'المرحلة الابتدائية'],
                ],
            ],
            [
                'term_id' => 2,
                'translations' => [
                    'en' => ['name' => 'Middle School'],
                    'ar' => ['name' => 'المرحلة المتوسطة'],
                ],
            ],
            [
                'term_id' => 2,
                'translations' => [
                    'en' => ['name' => 'Secondary School'],
                    'ar' => ['name' => 'المرحلة الثانوية'],
                ],
            ],
        ];

        foreach ($stages as $stageData) {
            $stage = Stage::create(['term_id' => $stageData['term_id']]);

            foreach ($stageData['translations'] as $locale => $translation) {
                $stage->translateOrNew($locale)->name = $translation['name'];
            }

            $stage->save();
        }
    }
}
