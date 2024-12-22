<?php

namespace Database\Seeders;

use App\Enums\Teacher\Type;
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
                "name" => "John Doe",
                "email" => "teacher@teacher.com",
                "phone" => "69734921",
               // "teacher_profit_rate"     => 50,

                "password" => Hash::make('Mm.1@23456'),
                "teacher_profit_rate"     => 50,
                "years_of_experience" => 5,
                "type" => Type::ONLINE_COURSE->value,
                "grade_id" => 1,
            ],
            [
                "name" => "John Doe",

                "email" => "teacher1@teacher.com",
                "phone" => "62734921",
                //"teacher_profit_rate"     => 50,

                "password" => Hash::make('Mm.1@23456'),
                "years_of_experience" => 3,
                "type" => Type::RECORDED_COURSE->value,
                "grade_id" => 1,
            ],
            [
                "name" => "John Doe",

                "email" => "teacher2@teacher.com",
                "phone" => "69714921",
                //"teacher_profit_rate"     => 50,

                "password" => Hash::make('Mm.1@23456'),
                "years_of_experience" => 7,
                "type" => Type::PRIVATE_TEACHER->value,
                "grade_id" => 2,
            ],
            [
                "name" => "John Doe",

                "email" => "teacher3@teacher.com",
                "phone" => "69724921",
                "password" => Hash::make('Mm.1@23456'),
                "teacher_profit_rate"     => 50,

                "years_of_experience" => 2,
                "type" => Type::ONLINE_COURSE->value,
                "grade_id" => 2,
            ],
            [
                "name" => "John Doe",

                "email" => "teacher4@teacher.com",
                "phone" => "69734922",
                "password" => Hash::make('Mm.1@23456'),
                // "teacher_profit_rate"     => 50,

                "years_of_experience" => 4,
                "type" => Type::RECORDED_COURSE->value,
                "grade_id" => 1,
            ],
            [
                "name" => "John Doe",

                "email" => "teacher5@teacher.com",
                "phone" => "69734923",
                "password" => Hash::make('Mm.1@23456'),
                // "teacher_profit_rate"     => 50,

                "years_of_experience" => 6,
                "type" => Type::PRIVATE_TEACHER->value,
                "grade_id" => 2,
            ]
        ];
        DB::table('teachers')->insert($teachers);

        DB::table('teacher_translations')->insert(
            [
            [
                "teacher_id" => 1,
                "locale" => "en",
                "bio" => "Experienced online course teacher",
                "description" => "John Doe has been teaching online courses for over 5 years."
            ],
            [
                "teacher_id" => 1,
                "locale" => "ar",
                //"name" => "جون دو",
                "bio" => "معلم ذو خبرة في الدورات عبر الإنترنت",
                "description" => "جون دو يقوم بتدريس الدورات عبر الإنترنت لأكثر من 5 سنوات."
            ],
            [
                "teacher_id" => 2,
                "locale" => "en",
                //"name" => "Jane Smith",
                "bio" => "Expert in recorded courses",
                "description" => "Jane Smith specializes in creating recorded courses."
            ],
            [
                "teacher_id" => 2,
                "locale" => "ar",
                //"name" => "جين سميث",
                "bio" => "خبير في الدورات المسجلة",
                "description" => "جين سميث متخصص في إنشاء الدورات المسجلة."
            ],
            [
                "teacher_id" => 3,
                "locale" => "en",
                //"name" => "Michael Johnson",
                "bio" => "Private teacher with 7 years of experience",
                "description" => "Michael Johnson offers private teaching sessions."
            ],
            [
                "teacher_id" => 3,
                "locale" => "ar",
                //"name" => "مايكل جونسون",
                "bio" => "معلم خاص مع 7 سنوات من الخبرة",
                "description" => "مايكل جونسون يقدم جلسات تعليمية خاصة."
            ],
            [
                "teacher_id" => 4,
                "locale" => "en",
                //"name" => "Emily Davis",
                "bio" => "New online course teacher",
                "description" => "Emily Davis is a new teacher specializing in online courses."
            ],
            [
                "teacher_id" => 4,
                "locale" => "ar",
                //"name" => "إميلي ديفيس",
                "bio" => "معلم جديد في الدورات عبر الإنترنت",
                "description" => "إميلي ديفيس معلمة جديدة متخصصة في الدورات عبر الإنترنت."
            ],
            [
                "teacher_id" => 5,
                "locale" => "en",
                //"name" => "David Brown",
                "bio" => "Recorded course expert",
                "description" => "David Brown has been creating recorded courses for 4 years."
            ],
            [
                "teacher_id" => 5,
                "locale" => "ar",
                //"name" => "ديفيد براون",
                "bio" => "خبير في الدورات المسجلة",
                "description" => "ديفيد براون يقوم بإنشاء الدورات المسجلة منذ 4 سنوات."
            ],
            [
                "teacher_id" => 6,
                "locale" => "en",
                //"name" => "Sarah Wilson",
                "bio" => "Experienced private teacher",
                "description" => "Sarah Wilson has 6 years of experience as a private teacher."
            ],
            [
                "teacher_id" => 6,
                "locale" => "ar",
                //"name" => "سارة ويلسون",
                "bio" => "معلمة خاصة ذات خبرة",
                "description" => "سارة ويلسون لديها 6 سنوات من الخبرة كمعلمة خاصة."
            ]
        ]);
    }
}
