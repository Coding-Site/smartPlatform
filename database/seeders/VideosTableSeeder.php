<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                "title"   => "video 1",
                "url"     => "link 1",
                "unit_id" => 1
            ],
            [
                "title"   => "video 2",
                "url"     => "link 2",
                "unit_id" => 2
            ],
            [
                "title"   => "video 3",
                "url"     => "link 3",
                "unit_id" => 3
            ],
            [
                "title"   => "video 4",
                "url"     => "link 4",
                "unit_id" => 4
            ],
            [
                "title"   => "video 5",
                "url"     => "link 5",
                "unit_id" => 5
            ],
        ];
        DB::table('videos')->insert($videos);
    }
}
