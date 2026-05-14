<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteNonAdminUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua user yang bukan admin beserta relasi (cascade)
        $deleted = User::where('role', '!=', 'admin')->delete();
        echo "Berhasil menghapus {$deleted} user non-admin beserta semua data proposal dan profil mereka.\n";
    }
}
