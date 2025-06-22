<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user dengan email dan password tertentu
        User::create([
            'name' => 'Septiawan',
            'email' => 'mseptiawan017@gmail.com',
            'password' => Hash::make('password'), // selalu hash password
        ]);
    }
}
