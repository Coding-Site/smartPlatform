<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                "name"       => "John Doe",
                "email"      => "teacher@teacher.com",
                "phone"      => "69734921",
                "stage_id"   => 1,
                "grade_id"   => 1,
                "type"       => "online_course",

                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "Jane Smith",
                "email"      => "teacher1@teacher.com",
                "phone"      => "62734921",
                "stage_id"   => 2,
                "grade_id"   => 1,
                "type"       => "recorded_course",

                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "Michael Johnson",
                "email"      => "teacher2@teacher.com",
                "phone"      => "69714921",
                "stage_id"   => 1,
                "grade_id"   => 2,
                "type"       => "private_teacher",

                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "Emily Davis",
                "email"      => "teacher3@teacher.com",
                "phone"      => "69724921",
                "stage_id"   => 2,
                "grade_id"   => 2,
                "type"       => "online_course",
                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "David Brown",
                "email"      => "teacher4@teacher.com",
                "phone"      => "69734922",
                "stage_id"   => 3,
                "grade_id"   => 1,
                "type"       => "recorded_course",
                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "Sarah Wilson",
                "email"      => "teacher5@teacher.com",
                "phone"      => "69734923",
                "stage_id"   => 3,
                "grade_id"   => 2,
                "type"       => "private_teacher",
                'password'   => Hash::make('Mm.1@23456')
            ]
        ];
        DB::table('teachers')->insert($teachers);
    }
}
