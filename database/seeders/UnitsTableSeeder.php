<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                "title"     => "unit 1",
                "course_id" => 1
            ],
            [
                "title"     => "unit 2",
                "course_id" => 2
            ],
            [
                "title"     => "unit 3",
                "course_id" => 3
            ],
            [
                "title"     => "unit 4",
                "course_id" => 4
            ],
            [
                "title"     => "unit 5",
                "course_id" => 5
            ],
        ];
        DB::table('units')->insert($units);
    }
}
