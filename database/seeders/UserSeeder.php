<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'fadhlurthoriq@gmail.com'],
            [
                'name'     => 'thoriq',
                'password' => Hash::make('281008'),
                'role'     => 'penjual',
                'phone'    => '081234567890',
            ]
        );

        User::firstOrCreate(
            ['email' => 'david@gmail.com'],
            [
                'name'     => 'david',
                'password' => Hash::make('281008'),
                'role'     => 'pembeli',
                'phone'    => '089876543210',
            ]
        );
    }
}