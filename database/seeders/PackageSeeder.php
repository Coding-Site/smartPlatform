<?php

namespace Database\Seeders;

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
        $packages = [
            [
                'name' => 'Course Package',
                'description' => 'A premium package for courses',
                'price' => 50.00,
                'expiry_day' => Carbon::now()->addYear(),
                'is_active' => 1,
                'grade_id' => 1,
                'translations' => [
                    'en' => ['name' => 'Course Package', 'description' => 'A premium package for courses'],
                    'ar' => ['name' => 'باقة الدورات', 'description' => 'باقة متميزة للدورات'],
                ]
            ],
            [
                'name' => 'Book Package',
                'description' => 'A premium package for Books',
                'price' => 150.00,
                'expiry_day' => Carbon::now()->addMonths(6),
                'is_active' => 1,
                'grade_id' => 2,
                'translations' => [
                    'en' => ['name' => 'Book Package', 'description' => 'A premium package for Books'],
                    'ar' => ['name' => 'باقة الكتب', 'description' => 'باقة متميزة للكتب'],
                ]
            ],
            [
                'name' => 'Diamond Package',
                'description' => 'A premium package for courses and books',
                'price' => 200.00,
                'expiry_day' => Carbon::now()->addMonths(3),
                'is_active' => 1,
                'grade_id' => 3,
                'translations' => [
                    'en' => ['name' => 'Diamond Package', 'description' => 'A premium package for courses and books'],
                    'ar' => ['name' => 'باقة الماسة', 'description' => 'باقة متميزة للدورات والكتب'],
                ]
            ]
        ];

        foreach ($packages as $packageData) {
            $packageId = DB::table('packages')->insertGetId([
                'price' => $packageData['price'],
                'expiry_day' => $packageData['expiry_day'],
                'is_active' => $packageData['is_active'],
                'grade_id' => $packageData['grade_id'],
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
