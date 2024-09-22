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
            'position_id' => 1,
            'affiliation_id' => 1,
        ]);
        // CREATE USER (user)
        $users = [
            [
                'name' => 'Test User',
                'email' => 'user@example.com',
                'role' => 'user',
                'position_id' => 1,
                'affiliation_id' => 1,
            ],
            [
                'name' => 'Test User2',
                'email' => 'user2@example.com',
                'role' => 'user',
                'position_id' => 1,
                'affiliation_id' => 1,
            ],
            [
                'name' => 'Test User3',
                'email' => 'user3@example.com',
                'role' => 'user',
                'position_id' => 1,
                'affiliation_id' => 1,
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        // CREATE USER (banned)
        User::factory()->create([
            'name' => 'Banned User',
            'email' => 'banned@example.com',
            'role' => 'banned',
            'position_id' => 1,
            'affiliation_id' => 1,
        ]);
    }
}
