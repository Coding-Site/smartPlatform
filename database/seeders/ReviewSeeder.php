<?php

namespace Database\Seeders;

use App\Models\Teacher\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $users = User::limit(5)->get();
        $teachers = Teacher::limit(5)->get();

        if ($users->count() > 0 && $teachers->count() > 0) {
            foreach ($users as $user) {
                foreach ($teachers as $teacher) {
                    DB::table('reviews')->insert([
                        'user_id' => $user->id,
                        'teacher_id' => $teacher->id,
                        'review' => $faker->sentence(),
                        'rating' => $faker->numberBetween(1, 5),
                        'created_at' => now(),
                    ]);
                }
            }
        } else {
            $this->command->info('No users or teachers found in the database.');
        }
    }
}

