<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user baru
        $adminUser = User::create([
            'name' => 'Admin Utama',
            'username' => 'admin', // Tambahkan username
            'email' => 'admin@perusahaan.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
        ]);

        // Cari role 'Admin' yang sudah kita buat di RoleSeeder
        $adminRole = Role::findByName('Admin');

        // Berikan role 'Admin' ke user tersebut
        $adminUser->assignRole($adminRole);
    }
}
