<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run()
    {
        DB::table('buku')->insert([
            ['judul_buku' => 'Laskar Pelangi', 'penulis_buku' => 'Andrea Hirata', 'sinopsis' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit', 'harga' => 400000, 'stock' => 5, 'created_at' => now(), 'updated_at' => now(), 'gambar_sampul' => 'background.png'],

            ['judul_buku' => 'Negeri 5 Menara', 'penulis_buku' => 'Ahmad Fuadi', 'sinopsis' => 'Consectetur adipiscing elit quisque faucibus ex sapien vitae', 'harga' => 300000, 'stock' => 10, 'created_at' => now(), 'updated_at' => now(), 'gambar_sampul' => 'background.png'],

            ['judul_buku' => 'Bumi Manusia', 'penulis_buku' => 'Pramoedya Ananta Toer', 'sinopsis' => 'Ex sapien vitae pellentesque sem placerat in id', 'harga' => 200000, 'stock' => 15, 'created_at' => now(), 'updated_at' => now(), 'gambar_sampul' => 'background.png'],

            ['judul_buku' => 'Perahu Kertas', 'penulis_buku' => 'Dewi Lestari', 'sinopsis' => 'Placerat in id cursus mi pretium tellus duis', 'harga' => 100000, 'stock' => 20, 'created_at' => now(), 'updated_at' => now(), 'gambar_sampul' => 'background.png'],
        ]);
    }
}
