<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'name'     => 'Admin Resto Kemang',
            'email'    => 'admin@restokemang.com',
            'password' => Hash::make('Admin@123456'),
            'role'     => 'admin',
        ]);

        // Buat akun user untuk testing
        User::create([
            'name'     => 'Test User',
            'email'    => 'user@restokemang.com',
            'password' => Hash::make('User@123456'),
            'role'     => 'customer',
        ]);

        // Jalankan seeder lainnya
        $this->call([
            MenuSeeder::class,
        ]);
    }
}
