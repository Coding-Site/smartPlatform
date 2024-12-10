<?php

namespace Database\Seeders;

use App\Enums\Stage\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                "name" => "book 1",
                "teacher_id" =>1,
                "term_id"  => 1,
                "price" => 100,
                "quantity" => 20,
                "stage_id"=> 1,
                "grade_id" => 1
            ],
            [
                "name" => "book 2",
                "teacher_id" =>1,
                "term_id"  => 1,
                "price" => 100,
                "quantity" => 20,
                "stage_id"=> 2,
                "grade_id" => 2

            ],
            [
                "name" => "book 3",
                "teacher_id" =>2,
                "term_id"  => 2,
                "price" => 100,
                "quantity" => 20,
                "stage_id"=> 1,
                "grade_id" => 3
            ],
            [
                "name" => "book 4",
                "teacher_id" =>2,
                "term_id"  => 2,
                "price" => 100,
                "quantity" => 20,
                "stage_id"=> 3,
                "grade_id" => 4
            ],
        ];
        DB::table('books')->insert($books);
    }
}
