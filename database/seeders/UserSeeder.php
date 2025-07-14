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
                'password' => Hash::make('password'),
                'role' => 'marketing',
            ]);
        }

        // Buat user promotor jika belum ada
        if (!User::where('id_spgms', 'SPG01')->exists()) {
            User::create([
                'name' => 'LIA ANGGRAENINGSIH',
                'email' => 'promotor01@example.com',
                'id_spgms' => 'SPG01',
                'password' => Hash::make('password'),
                'role' => 'promotor',
            ]);
        }

        // Buat user manager jika belum ada
        if (!User::where('email', 'manager@gmail.com')->exists()) {
            User::create([
                'name' => 'Pak Ronald',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]);
        }
    }
}
