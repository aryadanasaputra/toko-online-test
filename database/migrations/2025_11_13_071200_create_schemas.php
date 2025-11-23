<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::connection('pgsql')->statement('CREATE SCHEMA IF NOT EXISTS master');
        DB::connection('pgsql')->statement('CREATE SCHEMA IF NOT EXISTS transactions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS transactions CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS master CASCADE');
    }
};
