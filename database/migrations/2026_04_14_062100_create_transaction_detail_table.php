<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->morphs('productable'); // Relasi Polimorfik ke Pastry/Drink/Promo
            $table->string('product_code', 50);
            $table->string('product_name', 100);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('member_benefit', 12, 2)->default(0);
            $table->decimal('final_subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
