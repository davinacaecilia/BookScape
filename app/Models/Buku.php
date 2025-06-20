<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $fillable = ['judul_buku', 'penulis_buku', 'sinopsis', 'gambar_sampul', 'harga', 'stock'];
    public $timestamps = true;

    public function genres()
    {
        return $this->belongsToMany(Genre::class, );
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        // Menghitung rata-rata dari kolom 'rating' pada relasi 'ratings'
        // dan memformatnya menjadi 1 angka di belakang koma.
        return number_format($this->ratings()->avg('rating'), 1);
    }

    public function ratingCount()
    {
        // Menghitung jumlah rating yang masuk
        return $this->ratings()->count();
    }

}