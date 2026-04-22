<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ruang.id'],
            [
                'username' => 'admin',
                'name' => 'Admin Utama',
                'number' => '089676622270',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );
    }
}
