<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';
    protected $fillable = ['genre'];
    public $timestamps = false;
    
    public function buku()
    {
        return $this->belongsToMany(Buku::class);
    }
}
