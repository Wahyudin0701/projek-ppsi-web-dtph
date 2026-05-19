<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pimpinan DTPH',
            'email' => 'pimpinan@dtph.go.id',
            'password' => Hash::make('pimpinan123'),
            'role' => 'pimpinan',
        ]);
    }
}
