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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('taxes', 8, 2);
            $table->decimal('total', 8, 2);
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('discount', 8, 2);
            $table->decimal('subtotal_after_discount', 8, 2);
            $table->decimal('taxes_after_discount', 8, 2);
            $table->decimal('total_after_discount', 8, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
