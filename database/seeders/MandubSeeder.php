<?php

namespace Database\Seeders;

use App\Models\City\City;
use App\Models\Mandub\Mandub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MandubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $mandubs = [
            ['name' => 'John Doe', 'email' => 'johndoe@example.com', 'phone' => '1234567890', 'password' => Hash::make('password123'), 'image' => 'john_doe.jpg', 'city_id' => 1],
            ['name' => 'Jane Smith', 'email' => 'janesmith@example.com', 'phone' => '0987654321', 'password' => Hash::make('password123'), 'image' => 'jane_smith.jpg', 'city_id' => 2],
            ['name' => 'Mohammed Ali', 'email' => 'mohammedali@example.com', 'phone' => '1122334455', 'password' => Hash::make('password123'), 'image' => 'mohammed_ali.jpg', 'city_id' => 1],
            ['name' => 'Ahmed Khan', 'email' => 'ahmedkhan@example.com', 'phone' => '5566778899', 'password' => Hash::make('password123'), 'image' => 'ahmed_khan.jpg' ,'city_id' => 3],
            ['name' => 'Sara Williams', 'email' => 'sarawilliams@example.com', 'phone' => '6677889900', 'password' => Hash::make('password123'), 'image' => 'sara_williams.jpg', 'city_id' => 4,],
        ];

        DB::table('mandubs')->insert($mandubs);

    }
}
