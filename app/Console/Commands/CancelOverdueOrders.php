<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order; // Pastikan ini di-import
use Carbon\Carbon;    // Pastikan ini di-import

class CancelOverdueOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membatalkan order yang belum dibayar atau dikonfirmasi dalam 24 jam.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mencari order yang perlu dibatalkan...');

        // Ambil order yang statusnya 'pending' ATAU 'waiting_payment_confirmation'
        // dan created_at-nya (atau timestamp lain yang Anda miliki) sudah lebih dari 24 jam yang lalu.
        $overdueOrders = Order::whereIn('status', ['pending'])
                              ->where('created_at', '<=', Carbon::now()->subHours(24)) // <<< UBAH KE 'created_at' atau nama kolom timestamp Anda
                              ->get();

        if ($overdueOrders->isEmpty()) {
            $this->info('Tidak ada order yang melewati batas waktu.');
            return Command::SUCCESS;
        }

        $canceledCount = 0;
        foreach ($overdueOrders as $order) {
            // Panggil metode cancelOrder yang sudah kita buat di model Order
            if ($order->cancelOrder()) {
                $canceledCount++;
                $this->info("Order #{$order->id} berhasil dibatalkan.");
            } else {
                $this->warn("Gagal membatalkan Order #{$order->id}. Mungkin sudah berstatus selesai atau dibatalkan.");
            }
        }

        $this->info("Total {$canceledCount} order dibatalkan.");

        return Command::SUCCESS;
    }
}