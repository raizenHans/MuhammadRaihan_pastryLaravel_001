<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menyimpan order_id unik yang dikirim ke Midtrans (format: TRX...-timestamp)
            // Digunakan oleh Webhook resmi Midtrans untuk menemukan transaksi yang tepat
            $table->string('midtrans_order_id')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('midtrans_order_id');
        });
    }
};
