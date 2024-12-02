<?php

namespace Database\Seeders;

use App\Models\Term\Term;
use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = [
            [
                // 'grade_id' => 1,
                'en' => ['name' => 'First Term'],
                'ar' => ['name' => 'الترم الأول'],
            ],
            [
                // 'grade_id' => 1,
                'en' => ['name' => 'Second Term'],
                'ar' => ['name' => 'الترم الثاني'],
            ],
        ];

        foreach ($terms as $termData) {
            $term = new Term();
            // $term->grade_id = $termData['grade_id'];

            foreach ($termData as $locale => $data) {
                if ($locale !== 'grade_id') {
                    $term->translateOrNew($locale)->name = $data['name'];
                }
            }

            $term->save();
        }
    }
}
