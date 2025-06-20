<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'BCA',
            'description' => 'Bank Central Asia',
            'account_number' => '0812345678',
            'account_name' => 'Nama Rekening Anda',
            'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png',
        ]);

        PaymentMethod::create([
            'name' => 'BRIVA',
            'description' => 'BRI Virtual Account',
            'account_number' => '1234567890',
            'account_name' => 'Nama Rekening BRI Anda',
            'logo_path' => 'https://developers.bri.co.id/sites/default/files/inline-images/BRIVA-BRI.jpg',
        ]);

        PaymentMethod::create([
            'name' => 'Mandiri',
            'description' => 'Bank Mandiri',
            'account_number' => '1234567890',
            'account_name' => 'Nama Rekening Mandiri Anda',
            'logo_path' => 'https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/2560px-Bank_Mandiri_logo.svg.png',
        ]);

        PaymentMethod::create([
            'name' => 'DANA',
            'description' => 'E-wallet DANA',
            'account_number' => '0876543210',
            'account_name' => 'Nama Akun Dana Anda',
            'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png',
        ]);
    }
}