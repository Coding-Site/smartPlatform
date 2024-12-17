<?php

namespace Database\Seeders;

use App\Models\Book\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherIds = DB::table('teachers')->pluck('id');
        $termIds = DB::table('terms')->pluck('id');
        $stageIds = DB::table('stages')->pluck('id');
        $gradeIds = DB::table('grades')->pluck('id');

        $books = [
            [
                'translations' => [
                    'en' => ['name' => 'Book 1'],
                    'ar' => ['name' => 'كتاب 1'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Book 2'],
                    'ar' => ['name' => 'كتاب 2'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Book 3'],
                    'ar' => ['name' => 'كتاب 3'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Book 4'],
                    'ar' => ['name' => 'كتاب 4'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Book 5'],
                    'ar' => ['name' => 'كتاب 5'],
                ],
            ],
            [
                'translations' => [
                    'en' => ['name' => 'Book 6'],
                    'ar' => ['name' => 'كتاب 6'],
                ],
            ],
        ];

        foreach ($books as $bookData) {
            $book = Book::create([
                'type' => ['Scientific', 'Literary'][array_rand(['Scientific', 'Literary'])],
                'paper_price' => 50.00,
                'paper_count' => 100,
                'covering_price' => 30.00,
                'price' => 100.00,
                'quantity' => 20,
                'teacher_id' => $teacherIds->random(),
                'term_id' => $termIds->random(),
                'stage_id' => $stageIds->random(),
                'grade_id' => $gradeIds->random(),
            ]);

            foreach ($bookData['translations'] as $locale => $translation) {
                DB::table('book_translations')->insert([
                    'book_id' => $book->id,
                    'locale' => $locale,
                    'name' => $translation['name'],
                ]);
            }
        }
    }
}
