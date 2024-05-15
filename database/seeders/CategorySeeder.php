<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')
            ->insert(['id' => 'MOVIE', 'name' => 'Movie', 'create_at' => '2024-05-15 09:50:10']);
        DB::table('categories')
            ->insert(['id' => 'ANIME', 'name' => 'Anime', 'create_at' => '2024-05-15 09:50:10']);
        DB::table('categories')
            ->insert(['id' => 'KOREAN-DRAMA', 'name' => 'Korean Drama', 'create_at' => '2024-05-15 09:50:10']);
        DB::table('categories')
            ->insert(['id' => 'VARIETY-SHOW', 'name' => 'Variety Show', 'create_at' => '2024-05-15 09:51:10']);
    }
}
