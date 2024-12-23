<?php

namespace Database\Seeders;

use App\Models\Comment\Comment;
use App\Models\Lesson\Lesson;
use App\Models\Teacher\Teacher;
use App\Models\User;
use App\Enums\Comment\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $lessons = Lesson::limit(5)->get();
        $users = User::limit(5)->get();
        $teachers = Teacher::limit(5)->get();

        foreach ($lessons as $lesson) {

            for ($i = 0; $i < 3; $i++) {

                $user = $users->random();

                $comment = Comment::create([
                    'user_id' => $user->id,
                    'teacher_id'=>null,
                    'lesson_id' => $lesson->id,
                    'content' => $faker->paragraph(2),
                    'status' => Status::APPROVED->value,
                ]);

                $this->createReplies($comment, $users, $teachers, $faker);
            }
        }
    }

    private function createReplies(Comment $parentComment, $users, $teachers, $faker)
    {
        $replyCount = rand(2, 3);
        for ($i = 0; $i < $replyCount; $i++) {
            $teacher = $teachers->random();

            Comment::create([
                'user_id' => null,
                'teacher_id'=> $teacher->id,
                'lesson_id' => $parentComment->lesson_id,
                'content' => $faker->sentence(5),
                'status' => Status::APPROVED->value,
                'parent_id' => $parentComment->id,
            ]);
        }
    }
}

