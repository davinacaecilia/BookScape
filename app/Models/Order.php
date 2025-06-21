<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'total_price', 'status', 'payment_proof', 'alamat_id'];
    public $timestamps = true;
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function cancelOrder()
    {
        // Pastikan order belum berstatus 'completed' atau 'canceled' sebelumnya
        if ($this->status === 'completed' || $this->status === 'canceled') {
            return false; // Order tidak bisa dibatalkan jika sudah selesai atau sudah dibatalkan
        }

        try {
            DB::beginTransaction(); // Mulai transaksi database

            // Ubah status order menjadi 'canceled'
            $this->status = 'canceled';
            $this->save();

            // Kembalikan stok untuk setiap item dalam order ini
            foreach ($this->orderItems as $orderItem) {
                $buku = $orderItem->buku; // Dapatkan buku terkait melalui relasi orderItem
                if ($buku) {
                    $buku->stock += $orderItem->quantity; // Tambahkan stok kembali
                    $buku->save();
                }
            }

            DB::commit(); // Selesaikan transaksi

            return true;
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi error
            \Log::error('Error cancelling order ' . $this->id . ': ' . $e->getMessage());
            return false;
        }
    }
}
