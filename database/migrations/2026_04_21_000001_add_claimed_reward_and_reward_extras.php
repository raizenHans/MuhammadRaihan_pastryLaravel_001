<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom hadiah yang diklaim ke tabel transaksi
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('claimed_reward_id')
                  ->nullable()
                  ->after('redeemed_points')
                  ->constrained('rewards')
                  ->onDelete('set null');
            $table->string('claimed_reward_name', 150)
                  ->nullable()
                  ->after('claimed_reward_id')
                  ->comment('Snapshot nama hadiah saat diklaim');
        });

        // Tambah kolom image_path & stock ke tabel rewards
        Schema::table('rewards', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
            $table->integer('stock')->default(0)->after('image_path')
                  ->comment('0 = tidak terbatas');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['claimed_reward_id']);
            $table->dropColumn(['claimed_reward_id', 'claimed_reward_name']);
        });

        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'stock']);
        });
    }
};
