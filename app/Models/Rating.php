<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = ['rating', 'review'];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}