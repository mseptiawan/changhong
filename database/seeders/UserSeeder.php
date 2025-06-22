<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user marketing jika belum ada
        if (!User::where('email', 'mseptiawan017@gmail.com')->exists()) {
            User::create([
                'name' => 'Septiawan',
                'email' => 'mseptiawan017@gmail.com',
                'password' => Hash::make('password'), // gunakan Hash agar konsisten
                'role' => 'marketing',
            ]);
        }

        // Buat user promotor jika belum ada
        if (!User::where('email', 'promotor@example.com')->exists()) {
            User::create([
                'name' => 'Promotor A',
                'email' => 'promotor@example.com',
                'password' => Hash::make('password'),
                'role' => 'promotor',
            ]);
        }
    }
}
