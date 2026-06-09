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
        // === Seed Program Categories ===
        $catAlsintan = \App\Models\ProgramCategory::firstOrCreate(['slug' => 'alsintan'], [
            'name' => 'Alsintan', 'description' => 'Bantuan Alat dan Mesin Pertanian',
            'icon_path' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'icon_color' => 'text-primary-600', 'icon_bg' => 'bg-primary-50'
        ]);

        $catBenih = \App\Models\ProgramCategory::firstOrCreate(['slug' => 'benih'], [
            'name' => 'Bantuan Benih', 'description' => 'Bantuan benih tanaman pangan dan hortikultura',
            'icon_path' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'icon_color' => 'text-green-600', 'icon_bg' => 'bg-green-50'
        ]);

        $catPupuk = \App\Models\ProgramCategory::firstOrCreate(['slug' => 'pupuk'], [
            'name' => 'Bantuan Pupuk', 'description' => 'Bantuan pupuk subsidi dan non-subsidi',
            'icon_path' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            'icon_color' => 'text-lime-600', 'icon_bg' => 'bg-lime-50'
        ]);

        $catInfrastruktur = \App\Models\ProgramCategory::firstOrCreate(['slug' => 'infrastruktur'], [
            'name' => 'Infrastruktur', 'description' => 'Bantuan infrastruktur pertanian',
            'icon_path' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
            'icon_color' => 'text-blue-600', 'icon_bg' => 'bg-blue-50'
        ]);

        $catPelatihan = \App\Models\ProgramCategory::firstOrCreate(['slug' => 'pelatihan'], [
            'name' => 'Pelatihan', 'description' => 'Program pelatihan dan penyuluhan',
            'icon_path' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'icon_color' => 'text-violet-600', 'icon_bg' => 'bg-violet-50'
        ]);

        // === Seed Programs ===
        Program::create([
            'name' => 'Bantuan Benih Padi Inbrida',
            'program_category_id' => $catBenih->id,
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
            'program_category_id' => $catPupuk->id,
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
