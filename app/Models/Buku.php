<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul_buku', 'penulis_buku', 'sinopsis', 'gambar_sampul', 'harga', 'stock'];
    public $timestamps = true;

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

}
