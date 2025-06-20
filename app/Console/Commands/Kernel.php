<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CancelOverdueOrders::class, // <<< Tambahkan ini
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ... (contoh schedule lainnya jika ada) ...

        // Jadwalkan command untuk berjalan setiap jam
        $schedule->command('orders:cancel-overdue')->hourly();
        // Atau setiap 15 menit: $schedule->command('orders:cancel-overdue')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}