<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 50)->unique();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('operator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name', 100);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('final_total', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('change_amount', 12, 2)->default(0);
            $table->integer('earned_points')->default(0);
            $table->integer('redeemed_points')->default(0);
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');
            $table->string('payment_method', 50)->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};