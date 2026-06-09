<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\UmumProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@dtph.com'],
            [
                'name' => 'IT System Administrator',
                'password' => $password,
                'role' => 'super_admin',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@dtph.com'],
            [
                'name' => 'Admin DTPH',
                'password' => $password,
                'role' => 'admin',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Pimpinan
        User::firstOrCreate(
            ['email' => 'pimpinan@dtph.go.id'],
            [
                'name' => 'Ir. Evi Syahrul, SP, M.Si',
                'password' => $password,
                'role' => 'pimpinan',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Kabid PSP
        User::firstOrCreate(
            ['email' => 'kabid.psp@dtph.go.id'],
            [
                'name' => 'Ahmad Sukri, SP',
                'password' => $password,
                'role' => 'kabid_psp',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Kabid TP
        User::firstOrCreate(
            ['email' => 'kabid.tp@dtph.go.id'],
            [
                'name' => 'Umi Kalsum, SP',
                'password' => $password,
                'role' => 'kabid_tp',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Kabid Hortikultura
        User::firstOrCreate(
            ['email' => 'kabid.hortikultura@dtph.com'],
            [
                'name' => 'Ir. Candrawati',
                'password' => $password,
                'role' => 'kabid_hortikultura',
                'is_verified' => 1,
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

    }
}
