<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Regular User',
            'email' => 'user@santamarta.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user12345'),
            'role' => 'user',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'address' => 'Santa Marta Parish',
            'contact_number' => '09987654321',
        ]);
    }
} 