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
            TermsTableSeeder::class,
            StagesTableSeeder::class,
            ClassesTableSeeder::class,
            CoursesTableSeeder::class,
            BooksTableSeeder::class,
            UnitsTableSeeder::class,
            VideosTableSeeder::class,
        ]);
    }
}
