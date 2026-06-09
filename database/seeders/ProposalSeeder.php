<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Program;
use App\Models\Alsintan;
use App\Models\Proposal;
use App\Models\FarmerProfile;
use Illuminate\Support\Str;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'petani')->pluck('id');
        
        // Buat 10 petani dummy dengan profil lengkap jika belum ada cukup user
        if ($users->count() < 5) {
            $kecamatans = ['Jambi Luar Kota', 'Maro Sebo', 'Sekernan', 'Kumpeh Ulu', 'Sungai Gelam', 'Mestong'];
            
            for ($i = 0; $i < 10; $i++) {
                $user = User::create([
                    'name' => 'Petani Dummy ' . ($i + 1),
                    'email' => 'petani_dummy_' . $i . '_' . time() . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'petani',
                    'is_verified' => true,
                ]);
                
                $kecamatan = $kecamatans[array_rand($kecamatans)];
                
                FarmerProfile::create([
                    'user_id' => $user->id,
                    'nama_kelompok' => 'Kelompok Tani ' . Str::random(5),
                    'ketua' => 'Bapak ' . Str::random(5),
                    'nik_ketua' => rand(1000000000000000, 9999999999999999),
                    'kontak' => '08' . rand(1000000000, 9999999999),
                    'pekerjaan' => 'Petani',
                    'luas_lahan' => rand(1, 10),
                    'komoditi_utama' => 'Padi',
                    'alamat' => 'Desa ' . Str::random(5) . ', Jalan Dummy No ' . rand(1, 100),
                    'kecamatan' => $kecamatan,
                    'id_poktan' => 'POKTAN-' . Str::random(8),
                    'no_sk' => 'SK/' . date('Y') . '/' . rand(100, 999),
                ]);
                
                $users->push($user->id);
            }
        }

        $programs = Program::pluck('id');
        if ($programs->isEmpty()) {
            $program = Program::create(['name' => 'Program Bantuan Benih Jagung Hibrida', 'description' => 'Bantuan benih jagung unggul']);
            $programs->push($program->id);
        }
        
        $alsintans = Alsintan::pluck('id');
        if ($alsintans->isEmpty()) {
            $alsintan = Alsintan::create(['name' => 'Traktor Roda 4 (TR4)', 'description' => 'Traktor untuk membajak sawah']);
            $alsintans->push($alsintan->id);
        }

        $proposalsToInsert = [];
        $now = now();

        for ($i = 0; $i < 500; $i++) {
            $isAlsintan = rand(0, 1) == 1 && $alsintans->isNotEmpty();
            $isProgram = !$isAlsintan && $programs->isNotEmpty();
            
            // Buat tanggal acak dalam 6 bulan terakhir agar grafiknya tersebar
            $submissionDate = $now->copy()->subDays(rand(0, 180));
            
            $proposalsToInsert[] = [
                'user_id' => $users->random(),
                'program_id' => $isProgram ? $programs->random() : null,
                'alsintan_id' => $isAlsintan ? $alsintans->random() : null,
                'jumlah_unit' => rand(1, 3),
                'status' => collect(['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'disetujui', 'ditolak'])->random(),
                'submission_date' => $submissionDate,
                'created_at' => $submissionDate,
                'updated_at' => $submissionDate,
            ];
        }

        Proposal::insert($proposalsToInsert);
    }
}
