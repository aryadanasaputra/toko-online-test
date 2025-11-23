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
        Schema::create('transactions.order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('transactions.orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('master.products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 12, 2); // price at time of order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions.order_items');
    }
};
