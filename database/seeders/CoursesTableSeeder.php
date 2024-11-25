<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                "name"       => "c 1",
                "price"      => 100,
                "teacher_id" => 1,
                "class_id"   => 3
            ],
            [
                "name"       => "c 2",
                "price"      => 100,
                "teacher_id" => 1,
                "class_id"   => 3
            ],
            [
                "name"       => "c 3",
                "price"      => 100,
                "teacher_id" => 1,
                "class_id"   => 5
            ],
            [
                "name"       => "c 4",
                "price"      => 100,
                "teacher_id" => 2,
                "class_id"   => 6
            ],
            [
                "name"       => "c 5",
                "price"      => 100,
                "teacher_id" => 2,
                "class_id"   => 8
            ],
            [
                "name"       => "c 6",
                "price"      => 100,
                "teacher_id" => 1,
                "class_id"   => 10
            ],
        ];
        DB::table('courses')->insert($courses);
    }
}
