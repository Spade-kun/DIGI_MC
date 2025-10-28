<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user for testing
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create additional test users
        User::factory(5)->create();
    }
}