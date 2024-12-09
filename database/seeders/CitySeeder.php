<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'New York', 'deliver_price' => 5000],
            ['name' => 'Los Angeles', 'deliver_price' => 4500],
            ['name' => 'Chicago', 'deliver_price' => 4000],
            ['name' => 'Houston', 'deliver_price' => 3500],
            ['name' => 'Phoenix', 'deliver_price' => 3000],
            ['name' => 'Philadelphia', 'deliver_price' => 3200],
            ['name' => 'San Antonio', 'deliver_price' => 3700],
            ['name' => 'San Diego', 'deliver_price' => 4300],
            ['name' => 'Dallas', 'deliver_price' => 4200],
            ['name' => 'San Jose', 'deliver_price' => 4400],
        ];

        DB::table('cities')->insert($cities);
    }
}
