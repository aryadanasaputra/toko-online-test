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
        Schema::create('transactions.orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('master.users')->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, awaiting_verification, confirmed, packing, shipped, cancelled
            $table->decimal('total', 12, 2);
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions.orders');
    }
};
