<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run()
    {
        DB::table('genres')->insert([
            ['genre' => 'Comedy'],
            ['genre' => 'Drama'],
            ['genre' => 'Romance'],
            ['genre' => 'Horror'],
            ['genre' => 'Sci-Fi'],
            ['genre' => 'Fantasy'],
            ['genre' => 'Thriller'],
            ['genre' => 'Mystery'],
        ]);

    }
}