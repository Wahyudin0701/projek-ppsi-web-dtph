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
        User::firstOrCreate(
            ['email' => 'admin@dtph.com'],
            [
                'name' => 'Admin DTPH',
                'password' => $password,
                'role' => 'admin',
                'is_verified' => 1,
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
                'email_verified_at' => now(),
            ]
        );

        // Umum
        User::firstOrCreate(
            ['email' => 'user.umum@dtph.com'],
            [
                'name' => 'Pengguna Umum',
                'password' => $password,
                'role' => 'umum',
                'is_verified' => 1,
                'email_verified_at' => now(),
            ]
        );

        // Delete existing farmers
        $existingFarmers = User::where('role', 'user')->get();
        foreach ($existingFarmers as $farmer) {
            if ($farmer->farmerProfile) {
                \App\Models\FarmerGroupMember::where('farmer_profile_id', $farmer->farmerProfile->id)->delete();
                $farmer->farmerProfile->delete();
            }
            $farmer->delete();
        }

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
            'alamat' => 'Tanjung Lebar',
            'kecamatan' => 'BAHAR SELATAN',
            'komoditi' => 'Padi Sawah, Jagung',
            'komoditi_utama' => 'Padi Sawah',
            'luas_lahan' => 15.5,
            'grade' => 'Pemula',
            'status' => 'approved',
        ]);

        \App\Models\FarmerGroupMember::insert([
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203011111110001', 'nama' => 'Supriyanto', 'jabatan' => 'Sekretaris', 'alamat' => 'Tanjung Lebar', 'luas_lahan' => 1.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203012222220002', 'nama' => 'Joko', 'jabatan' => 'Bendahara', 'alamat' => 'Tanjung Lebar', 'luas_lahan' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile1->id, 'nik' => '5203013333330003', 'nama' => 'Wahyudi', 'jabatan' => 'Anggota', 'alamat' => 'Tanjung Lebar', 'luas_lahan' => 1.0, 'created_at' => now(), 'updated_at' => now()],
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
            'alamat' => 'Kasang Pudak',
            'kecamatan' => 'KUMPEH ULU',
            'komoditi' => 'Cabai, Sayuran',
            'komoditi_utama' => 'Cabai',
            'luas_lahan' => 12.0,
            'grade' => 'Madya',
            'status' => 'approved',
        ]);

        \App\Models\FarmerGroupMember::insert([
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203021111110001', 'nama' => 'Slamet', 'jabatan' => 'Sekretaris', 'alamat' => 'Kasang Pudak', 'luas_lahan' => 2.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203022222220002', 'nama' => 'Hasan', 'jabatan' => 'Bendahara', 'alamat' => 'Kasang Pudak', 'luas_lahan' => 1.5, 'created_at' => now(), 'updated_at' => now()],
            ['farmer_profile_id' => $profile2->id, 'nik' => '5203023333330003', 'nama' => 'Udin', 'jabatan' => 'Anggota', 'alamat' => 'Kasang Pudak', 'luas_lahan' => 3.0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
