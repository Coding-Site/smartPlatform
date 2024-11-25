<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 1,
                'stage_id' =>1
            ],
            [
                'name' => 2,
                'stage_id' =>1
            ],
            [
                'name' => 3,
                'stage_id' =>1
            ],
            [
                'name' => 4,
                'stage_id' =>2
            ],
            [
                'name' => 5,
                'stage_id' =>2
            ],
            [
                'name' => 6,
                'stage_id' =>2
            ],
            [
                'name' => 7,
                'stage_id' =>3
            ],
            [
                'name' => 8,
                'stage_id' =>3
            ],
            [
                'name' => 9,
                'stage_id' =>3
            ],
            [
                'name' => 10,
                'stage_id' =>4
            ],
            [
                'name' => 11,
                'stage_id' =>4
            ],
            [
                'name' => 12,
                'stage_id' =>4
            ],
        ];
        DB::table('classes')->insert($classes);
    }
}
