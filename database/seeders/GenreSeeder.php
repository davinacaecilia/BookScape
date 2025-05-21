<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run()
    {
        DB::table('genres')->insert([
            ['genre' => 'Fiksi'],
            ['genre' => 'Non-Fiksi'],
            ['genre' => 'Petualangan'],
            ['genre' => 'Romantis'],
            ['genre' => 'Sejarah'],
        ]);

    }
}