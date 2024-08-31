<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CREATE USER (admin)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'position_id' => 1
        ]);
        // CREATE USER (user)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'role' => 'user',
            'position_id' => 1
        ]);
        // CREATE USER (banned)
        User::factory()->create([
            'name' => 'Banned User',
            'email' => 'banned@example.com',
            'role' => 'banned',
            'position_id' => 1
        ]);
    }
}
