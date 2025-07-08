<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua user yang ada
        DB::table('users')->truncate();

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Buat user biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@user.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
} 