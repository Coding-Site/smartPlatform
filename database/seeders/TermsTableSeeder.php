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
                'en' => ['name' => 'First Term'],
                'ar' => ['name' => 'الترم الأول'],
            ],
            [
                'en' => ['name' => 'Second Term'],
                'ar' => ['name' => 'الترم الثاني'],
            ],
        ];

        foreach ($terms as $termData) {
            $term = new Term();

            foreach ($termData as $locale => $data) {
                if ($locale !== 'grade_id') {
                    $term->translateOrNew($locale)->name = $data['name'];
                }
            }

            $term->save();
        }
    }
}
