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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount', 8, 2);
            $table->enum('type', ['total', 'eligible', 'equal', 'tax', 'required']);
            $table->enum('discount_type', ['fixed', 'percent']);
            $table->timestamp('expired_at');
            $table->timestamps();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
