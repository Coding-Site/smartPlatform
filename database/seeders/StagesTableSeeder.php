<?php

namespace Database\Seeders;

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
                "name" => "primary",
                "term_id" => 1
            ],
            [
                "name" => "secondary",
                "term_id" => 1
            ],
            [
                "name" => "primary",
                "term_id" => 2
            ],
            [
                "name" => "secondary",
                "term_id" => 2
            ],
        ];
        DB::table('stages')->insert($stages);
    }
}
