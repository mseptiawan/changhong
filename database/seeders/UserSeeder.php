<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
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
        foreach (['marketing', 'promotor', 'manager'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $marketing = User::firstOrCreate(
            ['email' => 'mseptiawan017@gmail.com'],
            [
                'name' => 'Septiawan',
                'password' => Hash::make('password'),
            ]
        );
        $marketing->assignRole('marketing');

        $promotor = User::firstOrCreate(
            ['email' => 'promotor01@example.com'],
            [
                'name' => 'LIA ANGGRAENINGSIH',
                'id_spgms' => 'SPG01',
                'password' => Hash::make('password'),
            ]
        );
        $promotor->assignRole('promotor');

        $manager = User::firstOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Pak Ronald',
                'password' => Hash::make('password'),
            ]
        );
        $manager->assignRole('manager');
    }
}
