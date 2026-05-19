<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KabidSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Kepala Bidang PSP',
            'email'    => 'kabid.psp@dtph.go.id',
            'password' => Hash::make('kabid123'),
            'role'     => 'kabid_psp',
        ]);

        User::create([
            'name'     => 'Kepala Bidang Tanaman Pangan',
            'email'    => 'kabid.tp@dtph.go.id',
            'password' => Hash::make('kabid123'),
            'role'     => 'kabid_tp',
        ]);

    }
}
