<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin global / admin dinas (role: admin)
        $admin = User::firstOrCreate(
            ['email' => 'admin@postingcinta.local'],
            [
                'name'      => 'Admin Dinas',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Admin Dinkes 1
        $lia = User::firstOrCreate(
            ['email' => 'lia.rosita@muaraenimkab.go.id'],
            [
                'name'          => 'Lia Rosita, AMG, SP',
                'password'      => Hash::make('password'),
                'role'          => 'admin',   // sama dengan admin lain
                'puskesmas_id'  => null,     // admin dinas, bukan puskesmas tertentu
                'is_active'     => true,
            ]
        );

        // Admin Dinkes 2
        $sari = User::firstOrCreate(
            ['email' => 'sari.gunda.manalu@muaraenimkab.go.id'],
            [
                'name'          => 'Sari Gunda Manalu, A.Md.Gz',
                'password'      => Hash::make('password'),
                'role'          => 'admin',
                'puskesmas_id'  => null,
                'is_active'     => true,
            ]
        );

        // Akun dummy petugas puskesmas (buat testing)
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@puskesmas.local'],
            [
                'name'          => 'Petugas Puskesmas',
                'password'      => Hash::make('password'),
                'role'          => 'puskesmas',
                'puskesmas_id'  => 1,   // asumsi PKM-001 id = 1
                'is_active'     => true,
            ]
        );

        // Akun dummy kader posyandu (buat testing)
        $kader = User::firstOrCreate(
            ['email' => 'kader@posyandu.local'],
            [
                'name'          => 'Kader Posyandu',
                'password'      => Hash::make('password'),
                'role'          => 'kader',
                'puskesmas_id'  => 1,   // sama, diasosiasikan ke puskesmas pertama
                'is_active'     => true,
            ]
        );
    }
}
