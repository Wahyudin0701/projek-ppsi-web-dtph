<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Proposal;
use App\Models\Program;
use App\Models\Alsintan;
use App\Models\ProposalDisposition;
use App\Models\SurveyAssignment;
use App\Models\CpclVerification;
use App\Models\BeritaAcara;

class DemoProposalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data master
        $farmer = User::where('role', 'user')->first();
        $admin = User::where('role', 'admin')->first();
        $pimpinan = User::where('role', 'pimpinan')->first();
        $kabid = User::where('role', 'kabid_psp')->first() ?? User::where('role', 'kabid_tp')->first();
        $program = Program::first();
        $alsintan = Alsintan::first();

        if (!$farmer || !$kabid || !$pimpinan || !$admin) {
            echo "User tidak lengkap. Jalankan seeder admin, pimpinan, kabid, dan user dulu.\n";
            return;
        }

        Proposal::query()->delete();

        // [Status 1] pending_verifikasi
        Proposal::create([
            'user_id' => $farmer->id,
            'program_id' => $program->id,
            'status' => 'sedang_diverifikasi_admin',
            'submission_date' => now()->subDays(5),
        ]);

        // [Status 2] diteruskan_ke_pimpinan
        Proposal::create([
            'user_id' => $farmer->id,
            'alsintan_id' => $alsintan->id,
            'status' => 'sedang_diverifikasi_pimpinan',
            'submission_date' => now()->subDays(4),
            'reviewed_at' => now()->subDays(3),
            'admin_notes' => 'Dokumen lengkap sesuai SIMLUHTAN.',
        ]);

        // [Status 3] didisposisi_kabid
        $propDisposisi = Proposal::create([
            'user_id' => $farmer->id,
            'program_id' => $program->id,
            'status' => 'persiapan_survei',
            'submission_date' => now()->subDays(6),
            'reviewed_at' => now()->subDays(5),
            'admin_notes' => 'Berkas awal lengkap.',
            'kabid_id' => $kabid->id,
        ]);
        ProposalDisposition::create([
            'proposal_id' => $propDisposisi->id,
            'disposed_by' => $pimpinan->id,
            'disposed_to' => $kabid->id,
            'notes' => 'Tolong segera survei lahan ini.',
            'created_at' => now()->subDays(4),
        ]);

        // [Status 4] surat_tugas_terbit
        $propSurat = Proposal::create([
            'user_id' => $farmer->id,
            'alsintan_id' => $alsintan->id,
            'status' => 'sedang_survei',
            'submission_date' => now()->subDays(7),
            'reviewed_at' => now()->subDays(6),
            'kabid_id' => $kabid->id,
        ]);
        SurveyAssignment::create([
            'proposal_id' => $propSurat->id,
            'nomor_surat' => '001/80.a/Kep-PPK/DTPH/' . date('Y'),
            'valid_from' => now()->subDays(1),
            'valid_until' => now()->addDays(2),
            'team_members' => [
                ['name' => 'Budi Surveyor', 'role' => 'Ketua Tim'],
                ['name' => 'Andi Anggota', 'role' => 'Anggota']
            ]
        ]);

        // [Status 5] survei_selesai
        $propSurvei = Proposal::create([
            'user_id' => $farmer->id,
            'program_id' => $program->id,
            'status' => 'survei_selesai',
            'submission_date' => now()->subDays(10),
            'reviewed_at' => now()->subDays(9),
            'kabid_id' => $kabid->id,
        ]);
        $assignment2 = SurveyAssignment::create([
            'proposal_id' => $propSurvei->id,
            'nomor_surat' => '002/80.a/Kep-PPK/DTPH/' . date('Y'),
            'valid_from' => now()->subDays(5),
            'valid_until' => now()->subDays(3),
            'team_members' => [['name' => 'Budi Surveyor', 'role' => 'Ketua Tim']]
        ]);
        CpclVerification::create([
            'survey_assignment_id' => $assignment2->id,
            'status_kepemilikan' => 'Milik Sendiri',
            'luas_lahan' => 2.5,
            'kondisi_lahan' => 'Tersedia irigasi teknis',
            'kesesuaian_komoditas' => true,
            'rekomendasi_surveyor' => 'Sangat Direkomendasikan',
            'catatan' => 'Lahan sangat memadai untuk program ini.',
        ]);

        // [Status 6] menunggu_approval_ba
        $propBA = Proposal::create([
            'user_id' => $farmer->id,
            'alsintan_id' => $alsintan->id,
            'status' => 'menunggu_keputusan_akhir',
            'submission_date' => now()->subDays(15),
            'reviewed_at' => now()->subDays(14),
            'kabid_id' => $kabid->id,
        ]);
        BeritaAcara::create([
            'proposal_id' => $propBA->id,
            'kabid_id' => $kabid->id,
            'survey_date' => now()->subDays(2),
            'location' => 'Desa Z, Lahan Utama',
            'content' => 'Lahan sangat sesuai dan alsintan sangat dibutuhkan untuk panen.',
            'recommendation' => 'direkomendasikan',
        ]);

        // [Status 7] disetujui
        Proposal::create([
            'user_id' => $farmer->id,
            'program_id' => $program->id,
            'status' => 'disetujui',
            'submission_date' => now()->subDays(20),
            'reviewed_at' => now()->subDays(19),
            'kabid_id' => $kabid->id,
            'decided_at' => now()->subDays(1),
            'pimpinan_notes' => 'Disetujui. Silakan lanjut proses SK/Perjanjian.',
        ]);

        echo "Berhasil membuat Demo Proposals untuk semua stage Hybrid Workflow!\n";
    }
}
