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
                'translations' => [
                    'en' => ['name' => 'Primary School'],
                    'ar' => ['name' => 'المرحلة الابتدائية'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Preparatory School'],
                    'ar' => ['name' => 'المرحلة المتوسطة'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'High School'],
                    'ar' => ['name' => 'المرحلة الثانوية'],
                ],
            ],
        ];

        foreach ($stages as $stageData) {
            $stage = new Stage();

            foreach ($stageData['translations'] as $locale => $translation) {
                $stage->translateOrNew($locale)->name = $translation['name'];
            }

            $stage->save();
        }
    }
}
