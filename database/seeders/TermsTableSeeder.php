<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $term = [
            [
                "name" => 'first'
            ],
            [
                "name" => 'second'
            ]
        ];
        DB::table('terms')->insert($term);
    }
}
