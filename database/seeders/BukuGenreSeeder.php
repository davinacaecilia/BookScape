<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuGenreSeeder extends Seeder
{
    public function run()
    {
        DB::table('buku_genre')->insert([
            ['buku_id' => 1, 'genre_id' => 1],
            ['buku_id' => 1, 'genre_id' => 3],
            ['buku_id' => 2, 'genre_id' => 1],
            ['buku_id' => 3, 'genre_id' => 5],
            ['buku_id' => 4, 'genre_id' => 4],
        ]);
    }
}