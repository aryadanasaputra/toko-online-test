<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);

        // Create sample users for different roles
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'CS Layer 1',
            'email' => 'cs1@example.com',
            'role' => 'cs1',
        ]);

        User::factory()->create([
            'name' => 'CS Layer 2',
            'email' => 'cs2@example.com',
            'role' => 'cs2',
        ]);
    }
}
