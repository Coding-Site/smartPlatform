<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name"       => "user",
                "email"      => "user@user.com",
                "phone"      => "01069734921",
                "grade_id"      => 1,
                "stage_id"      => 1,
                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "user 1",
                "email"      => "user1@user.com",
                "phone"      => "01062734921",
                "grade_id"      => 1,
                "stage_id"      => 1,

                'password'   => Hash::make('Mm.1@23456'),
            ],
            [
                "name"       => "user 2",
                "email"      => "user2@user.com",
                "phone"      => "01069714921",
                "grade_id"      => 1,
                "stage_id"      => 1,

                'password'   => Hash::make('Mm.1@23456'),
            ],

        ];

        DB::table('users')->insert($users);
    }
}
