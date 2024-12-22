<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'deliver_price' => 5000,
                'translations' => [
                    'en' => ['name' => 'New York'],
                    'ar' => ['name' => 'نيويورك'],
                ],
            ],
            [
                'deliver_price' => 4500,
                'translations' => [
                    'en' => ['name' => 'Los Angeles'],
                    'ar' => ['name' => 'لوس أنجلوس'],
                ],
            ],
            [
                'deliver_price' => 4000,
                'translations' => [
                    'en' => ['name' => 'Chicago'],
                    'ar' => ['name' => 'شيكاغو'],
                ],
            ],
            [
                'deliver_price' => 3500,
                'translations' => [
                    'en' => ['name' => 'Houston'],
                    'ar' => ['name' => 'هيوستن'],
                ],
            ],
            [
                'deliver_price' => 3000,
                'translations' => [
                    'en' => ['name' => 'Phoenix'],
                    'ar' => ['name' => 'فينكس'],
                ],
            ],
            [
                'deliver_price' => 3200,
                'translations' => [
                    'en' => ['name' => 'Philadelphia'],
                    'ar' => ['name' => 'فيلادلفيا'],
                ],
            ],
            [
                'deliver_price' => 3700,
                'translations' => [
                    'en' => ['name' => 'San Antonio'],
                    'ar' => ['name' => 'سان أنطونيو'],
                ],
            ],
            [
                'deliver_price' => 4300,
                'translations' => [
                    'en' => ['name' => 'San Diego'],
                    'ar' => ['name' => 'سان دييغو'],
                ],
            ],
            [
                'deliver_price' => 4200,
                'translations' => [
                    'en' => ['name' => 'Dallas'],
                    'ar' => ['name' => 'دالاس'],
                ],
            ],
            [
                'deliver_price' => 4400,
                'translations' => [
                    'en' => ['name' => 'San Jose'],
                    'ar' => ['name' => 'سان خوسيه'],
                ],
            ],
        ];

        foreach ($cities as $cityData) {
            $city = DB::table('cities')->insertGetId([
                'deliver_price' => $cityData['deliver_price'],
            ]);

            foreach ($cityData['translations'] as $locale => $translation) {
                DB::table('cities_translations')->insert([
                    'city_id' => $city,
                    'locale' => $locale,
                    'name' => $translation['name'],
                ]);
            }
        }
    }
}
