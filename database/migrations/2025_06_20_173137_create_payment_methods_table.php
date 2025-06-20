<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // BCA, DANA, Mandiri, BRIVA
            $table->string('description');
            $table->string('account_number'); // Nomor rekening/VA/HP
            $table->string('account_name')->nullable(); // Nama pemilik rekening
            $table->string('logo_path')->nullable(); // Path ke logo bank/ewallet
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};