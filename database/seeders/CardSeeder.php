<?php

namespace Database\Seeders;

use App\Models\Card\Card;
use App\Models\Lesson\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = Lesson::limit(5)->get();

        foreach ($lessons as $lesson) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('cards')->insert([
                    'question' => 'Sample question ' . $i . ' for lesson ' . $lesson->id,
                    'answer' => 'Sample answer ' . $i . ' for lesson ' . $lesson->id,
                    'status' => 0,
                    'lesson_id' => $lesson->id,
                ]);
            }
        }
    }
}
