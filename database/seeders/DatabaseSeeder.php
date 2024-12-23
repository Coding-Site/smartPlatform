<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            TeachersTableSeeder::class,
            TermsTableSeeder::class,
            StagesTableSeeder::class,
            GradesTableSeeder::class,
            CoursesTableSeeder::class,
            UnitsTableSeeder::class,
            LessonSeeder::class,
            QuizSeeder::class,
            CommentSeeder::class,
            BooksTableSeeder::class,
            // VideosTableSeeder::class,
            // RolePermissionsSeeder::class,
            PackageSeeder::class,
            BookPackageSeeder::class,
            CoursePackageSeeder::class,
            CardSeeder::class,
            ReviewSeeder::class,
            CitySeeder::class,
            MandubSeeder::class,
            ContactUsSeeder::class,
            TeacherCourseSeeder::class,
        ]);
    }
}
