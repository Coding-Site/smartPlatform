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
                'name' => 'Basic Package',
                'description' => 'A basic package for beginner courses.',
                'price' => 50.00,
                'expiry_day' => Carbon::now()->addYear(),
                'is_active' => 1,
                'grade_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Premium Package',
                'description' => 'A premium package for advanced learners.',
                'price' => 150.00,
                'expiry_day' => Carbon::now()->addMonths(6),
                'is_active' => 1,
                'grade_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
