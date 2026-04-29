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
        Schema::table('transactions', function (Blueprint $table) {
            // Kita ubah struktur status agar cocok dengan kode riwayat lama.
            $table->dropColumn('status');
            $table->enum('order_status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending')->after('redeemed_points');
            $table->enum('payment_status', ['pending', 'lunas', 'gagal'])->default('pending')->after('order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['order_status', 'payment_status']);
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');
        });
    }
};
