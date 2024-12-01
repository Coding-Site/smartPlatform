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
                "name"       => "teacher",
                "email"      => "teacher@teacher.com",
                "phone"      => "01069734921",
                "course"     => "Arabic",
                "stage"      => "primary",
                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "teacher 1",
                "email"      => "teacher1@teacher.com",
                "phone"      => "01062734921",
                "course"     => "Math",
                "stage"      => "primary",
                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "teacher 2",
                "email"      => "teacher2@teacher.com",
                "phone"      => "01069714921",
                "course"     => "English",
                "stage"      => "primary",
                'password'   => Hash::make('Mm.1@23456'),
            ],
        ];
        DB::table('teachers')->insert($teachers);
    }
}
