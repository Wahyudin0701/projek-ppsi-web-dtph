<?php

namespace Database\Seeders;

use App\Models\Alsintan;
use App\Models\Program;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === Seed Programs ===
        Program::create([
            'name' => 'Bantuan Benih Padi Inbrida',
            'type' => 'bantuan_permanen',
            'jenis' => 'Bantuan Benih',
            'description' => 'Program bantuan benih padi inbrida bersertifikat untuk meningkatkan produksi dan produktivitas padi.',
            'requirements' => [
                "Proposal pengajuan dari Kelompok Tani",
                "SK Kelompok Tani/Sertifikat Pengukuhan",
                "Fotokopi KTP Ketua Kelompok",
                "RDKK (Rencana Definitif Kebutuhan Kelompok)",
                "Surat Pernyataan Kesanggupan"
            ],
            'sop_description' => "1. Pengajuan proposal oleh kelompok tani\n2. Verifikasi dokumen administrasi oleh Admin\n3. Survei lapangan (CPCL) oleh Tim Survei\n4. Pembuatan Berita Acara (BA) CPCL oleh Kabid\n5. Persetujuan akhir oleh Pimpinan\n6. Penyerahan bantuan",
            'is_open' => true,
            'open_date' => now(),
            'close_date' => now()->addMonths(3),
        ]);

        Program::create([
            'name' => 'Bantuan Pupuk NPK Non-Subsidi',
            'type' => 'bantuan_permanen',
            'jenis' => 'Bantuan Pupuk',
            'description' => 'Bantuan pupuk majemuk NPK untuk meningkatkan kesuburan tanah dan hasil panen.',
            'requirements' => [
                "Proposal permohonan",
                "Susunan Pengurus Kelompok Tani",
                "Fotokopi KTP pengurus",
                "Rincian luas lahan garapan"
            ],
            'sop_description' => "1. Pengajuan permohonan\n2. Verifikasi data petani\n3. Persetujuan Kabid dan Pimpinan\n4. Distribusi pupuk melalui pengecer/langsung",
            'is_open' => true,
            'open_date' => now(),
            'close_date' => now()->addMonths(2),
        ]);

        // === Seed Alsintan Categories ===
        $catTraktor = \App\Models\AlsintanCategory::firstOrCreate([
            'slug' => 'traktor'
        ], [
            'name' => 'Traktor',
            'description' => 'Mesin pengolah tanah dan penarik alat pertanian lainnya.'
        ]);

        $catPompa = \App\Models\AlsintanCategory::firstOrCreate([
            'slug' => 'pompa-air'
        ], [
            'name' => 'Pompa Air',
            'description' => 'Alat untuk memompa air irigasi ke lahan pertanian.'
        ]);

        $catPascaPanen = \App\Models\AlsintanCategory::firstOrCreate([
            'slug' => 'pasca-panen'
        ], [
            'name' => 'Pasca Panen',
            'description' => 'Alat dan mesin untuk proses setelah panen seperti perontok dan penggiling.'
        ]);

        $catAlatTanam = \App\Models\AlsintanCategory::firstOrCreate([
            'slug' => 'alat-tanam'
        ], [
            'name' => 'Alat Tanam',
            'description' => 'Mesin penanam benih atau bibit secara mekanis.'
        ]);
        
        // Alat-alat kini disemai di AlsintanSeeder.php
    }
}
