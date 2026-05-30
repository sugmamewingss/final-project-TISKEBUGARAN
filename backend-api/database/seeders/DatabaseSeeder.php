<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat akun Admin
        User::create([
            'name' => 'Alfi',
            'email' => 'admin@kebugaran.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat akun Member
        User::create([
            'name' => 'Member Fit',
            'email' => 'member@kebugaran.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);
    }
}