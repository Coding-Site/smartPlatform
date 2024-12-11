<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('packages')->insert([
            [
                'name' => 'Course Package',
                'description' => 'A premium package for courses',
                'price' => 50.00,
                'expiry_day' => Carbon::now()->addYear(),
                'is_active' => 1,
                'grade_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Book Package',
                'description' => 'A premium package for Books',
                'price' => 150.00,
                'expiry_day' => Carbon::now()->addMonths(6),
                'is_active' => 1,
                'grade_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Diamond Package',
                'description' => 'A premium package for courses and books',
                'price' => 200.00,
                'expiry_day' => Carbon::now()->addMonths(3),
                'is_active' => 1,
                'grade_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
