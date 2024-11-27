<?php

namespace Database\Seeders;

use App\Models\Term\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                $term->translateOrNew($locale)->name = $data['name'];
            }

            $term->save();
        }
    }
}
