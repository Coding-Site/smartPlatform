<?php

namespace Database\Seeders;

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
                "price" => 100,
                "quantity" => 20,
                "class_id" => 1
            ],
            [
                "name" => "book 2",
                "teacher_id" =>1,
                "price" => 100,
                "quantity" => 20,
                "class_id" => 2

            ],
            [
                "name" => "book 3",
                "teacher_id" =>2,
                "price" => 100,
                "quantity" => 20,
                "class_id" => 3
            ],
            [
                "name" => "book 4",
                "teacher_id" =>2,
                "price" => 100,
                "quantity" => 20,
                "class_id" => 4
            ],
        ];
        DB::table('books')->insert($books);
    }
}
