<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@postingcinta.local'],
            [
                'name' => 'Admin Dinas',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@puskesmas.local'],
            [
                'name' => 'Petugas Puskesmas',
                'password' => Hash::make('password'),
                'role' => 'puskesmas',
                'puskesmas_id' => 1,
                'is_active' => true,
            ]
        );

        $kader = User::firstOrCreate(
            ['email' => 'kader@posyandu.local'],
            [
                'name' => 'Kader Posyandu',
                'password' => Hash::make('password'),
                'role' => 'kader',
                'puskesmas_id' => 1,
                'is_active' => true,
            ]
        );
    }
}
