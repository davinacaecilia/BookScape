<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'book_id', 'quantity', 'price'];
    public $timestamps = false;
    
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'book_id');
    }

}