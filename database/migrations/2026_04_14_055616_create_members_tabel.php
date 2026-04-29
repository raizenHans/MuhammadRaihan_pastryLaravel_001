<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            // Relasi 1-to-1 ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data spesifik member
            $table->string('member_code', 50)->unique(); // Contoh: CS00124...
            $table->string('nik', 20)->unique();
            $table->string('phone', 15)->nullable();
            $table->integer('points')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};