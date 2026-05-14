<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Akun Admin
        User::create([
            'nama'     => 'Administrator',
            'email'    => 'admin@simak.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Akun User biasa
        User::create([
            'nama'     => 'User Biasa',
            'email'    => 'user@simak.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
        ]);
    }
}