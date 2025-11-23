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
        Schema::create('transactions.payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('transactions.orders')->cascadeOnDelete();
            $table->string('status')->default('uploaded'); // uploaded, verified, rejected
            $table->string('file_path');
            $table->foreignId('verified_by')->nullable()->constrained('master.users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions.payments');
    }
};
