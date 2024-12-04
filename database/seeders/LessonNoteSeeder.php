<?php

namespace Database\Seeders;

use App\Models\LessonNote\LessonNote;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LessonNoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            LessonNote::create([
                'lesson_id' => $faker->numberBetween(1, 10),
                'file' =>  $faker->word . '.pdf',
            ]);
        }
    }
}

