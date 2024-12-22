<?php

namespace Database\Seeders;

use App\Enums\Package\Type;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $basePackages = [
            [
                'name' => 'Diamond Package',
                'type' => Type::Diamond->value,
                'description' => 'A premium package for courses and books',
                'price' => 200.00,
                'expiry_day' => Carbon::now()->addMonths(3),
                'translations' => [
                    'en' => ['name' => 'Diamond Package', 'description' => 'A premium package for courses and books'],
                    'ar' => ['name' => 'باقة الماسة', 'description' => 'باقة متميزة للدورات والكتب'],
                ],
            ],
            [
                'name' => 'Course Package',
                'type' => Type::Course->value,
                'description' => 'A premium package for courses',
                'price' => 50.00,
                'expiry_day' => Carbon::now()->addYear(),
                'translations' => [
                    'en' => ['name' => 'Course Package', 'description' => 'A premium package for courses'],
                    'ar' => ['name' => 'باقة الدورات', 'description' => 'باقة متميزة للدورات'],
                ],
            ],
            [
                'name' => 'Book Package',
                'type' => Type::Book->value,
                'description' => 'A premium package for Books',
                'price' => 150.00,
                'expiry_day' => Carbon::now()->addMonths(6),
                'translations' => [
                    'en' => ['name' => 'Book Package', 'description' => 'A premium package for Books'],
                    'ar' => ['name' => 'باقة الكتب', 'description' => 'باقة متميزة للكتب'],
                ],
            ],
        ];

        foreach (range(1, 3) as $stageId) {
            foreach (range(1, 5) as $gradeId) {
                foreach ($basePackages as $packageData) {
                    $packageId = DB::table('packages')->insertGetId([
                        'type' => $packageData['type'],
                        'price' => $packageData['price'],
                        'expiry_day' => $packageData['expiry_day'],
                        'is_active' => 1,
                        'stage_id' => $stageId,
                        'grade_id' => $gradeId,
                    ]);

                    foreach ($packageData['translations'] as $locale => $translation) {
                        DB::table('package_translations')->insert([
                            'package_id' => $packageId,
                            'locale' => $locale,
                            'name' => $translation['name'],
                            'description' => $translation['description'],
                        ]);
                    }
                }
            }
        }
    }
}
