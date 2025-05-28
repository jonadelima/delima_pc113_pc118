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
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Teacher user
        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        // Assistant user
        User::create([
            'name' => 'Assistant User',
            'email' => 'assistant@example.com',
            'password' => Hash::make('password123'),
            'role' => 'assistant',
        ]);
    }
}
