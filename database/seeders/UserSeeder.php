<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FarmerProfile;
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

        // Admin
        User::create([
            'name' => 'Admin DTPH',
            'email' => 'admin@dtph.com',
            'password' => $password,
            'role' => 'admin',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Pimpinan
        User::create([
            'name' => 'Ir. Evi Syahrul, SP, M.Si',
            'email' => 'pimpinan@dtph.go.id',
            'password' => $password,
            'role' => 'pimpinan',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Kabid PSP
        User::create([
            'name' => 'Ahmad Sukri, SP',
            'email' => 'kabid.psp@dtph.go.id',
            'password' => $password,
            'role' => 'kabid_psp',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Kabid TP
        User::create([
            'name' => 'Umi Kalsum, SP',
            'email' => 'kabid.tp@dtph.go.id',
            'password' => $password,
            'role' => 'kabid_tp',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Kabid Hortikultura
        User::create([
            'name' => 'Ir. Candrawati',
            'email' => 'kabid.hortikultura@dtph.com',
            'password' => $password,
            'role' => 'kabid_hortikultura',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Umum
        User::create([
            'name' => 'Pengguna Umum',
            'email' => 'user.umum@dtph.com',
            'password' => $password,
            'role' => 'umum',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        // Kelompok Tani 1
        $tani1 = User::create([
            'name' => 'Kelompok Tani Harapan Jaya',
            'email' => 'user1@farmer.com',
            'password' => $password,
            'role' => 'user',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);
        $profile1 = FarmerProfile::create([
            'user_id' => $tani1->id,
            'nama_kelompok' => 'Kelompok Tani Harapan Jaya',
            'ketua' => 'Budi Santoso',
            'nik_ketua' => '5203011234560001',
            'kontak' => '081234567890',
            'alamat' => 'Desa Sukamaju, RT 01 RW 02',
            'kecamatan' => 'Pringgasela',
            'komoditi' => 'Padi, Jagung',
            'komoditi_utama' => 'Padi',
            'luas_lahan' => 15.5,
            'grade' => 'Pemula',
            'status' => 'approved',
        ]);

        \App\Models\FarmerGroupMember::insert([
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203011111110001', 'nama' => 'Supriyanto', 'alamat' => 'Desa Sukamaju', 'luas_lahan' => 1.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203012222220002', 'nama' => 'Joko', 'alamat' => 'Desa Sukamaju', 'luas_lahan' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203013333330003', 'nama' => 'Wahyudi', 'alamat' => 'Desa Sukamaju', 'luas_lahan' => 1.0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kelompok Tani 2
        $tani2 = User::create([
            'name' => 'Kelompok Tani Makmur Bersama',
            'email' => 'user2@farmer.com',
            'password' => $password,
            'role' => 'user',
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);
        $profile2 = FarmerProfile::create([
            'user_id' => $tani2->id,
            'nama_kelompok' => 'Kelompok Tani Makmur Bersama',
            'ketua' => 'Agus Salim',
            'nik_ketua' => '5203021234560002',
            'kontak' => '081987654321',
            'alamat' => 'Desa Sukaasih, RT 03 RW 04',
            'kecamatan' => 'Masbagik',
            'komoditi' => 'Cabai, Tomat',
            'komoditi_utama' => 'Cabai',
            'luas_lahan' => 12.0,
            'grade' => 'Lanjut',
            'status' => 'approved',
        ]);

        \App\Models\FarmerGroupMember::insert([
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203021111110001', 'nama' => 'Slamet', 'alamat' => 'Desa Sukaasih', 'luas_lahan' => 2.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203022222220002', 'nama' => 'Hasan', 'alamat' => 'Desa Sukaasih', 'luas_lahan' => 1.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203023333330003', 'nama' => 'Udin', 'alamat' => 'Desa Sukaasih', 'luas_lahan' => 3.0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
