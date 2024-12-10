<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('course_package')->insert([
            [
                'package_id' => 1,
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => 2,
                'course_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'package_id' => 1,
                'course_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => 2,
                'course_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => 1,
                'course_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => 2,
                'course_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
