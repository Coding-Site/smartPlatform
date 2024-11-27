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
            // CoursesTableSeeder::class,
            // UnitsTableSeeder::class,
            // BooksTableSeeder::class,
            // VideosTableSeeder::class,
        ]);
    }
}
