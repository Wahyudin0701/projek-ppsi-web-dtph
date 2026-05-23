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
            'requirements' => json_encode([
                "Proposal pengajuan dari Kelompok Tani",
                "SK Kelompok Tani/Sertifikat Pengukuhan",
                "Fotokopi KTP Ketua Kelompok",
                "RDKK (Rencana Definitif Kebutuhan Kelompok)",
                "Surat Pernyataan Kesanggupan"
            ]),
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
            'requirements' => json_encode([
                "Proposal permohonan",
                "Susunan Pengurus Kelompok Tani",
                "Fotokopi KTP pengurus",
                "Rincian luas lahan garapan"
            ]),
            'sop_description' => "1. Pengajuan permohonan\n2. Verifikasi data petani\n3. Persetujuan Kabid dan Pimpinan\n4. Distribusi pupuk melalui pengecer/langsung",
            'is_open' => true,
            'open_date' => now(),
            'close_date' => now()->addMonths(2),
        ]);

        // === Seed Alsintans ===
        Alsintan::create([
            'name' => 'Traktor Roda 4',
            'category' => 'Prapanen',
            'merk' => 'Kubota M6040',
            'nomor_rangka' => 'KUB-6040-2023-001',
            'nomor_mesin' => 'V3300-T-2023-001',
            'tahun_perolehan' => 2023,
            'capacity' => '60 HP',
            'stock' => 5,
            'description' => 'Traktor roda empat kapasitas sedang, cocok untuk pengolahan lahan sawah maupun lahan kering yang luas.',
        ]);

        Alsintan::create([
            'name' => 'Combine Harvester Besar',
            'category' => 'Pascapanen',
            'merk' => 'Yanmar AW82V',
            'nomor_rangka' => 'YAN-82V-2022-045',
            'nomor_mesin' => '4TNV98-2022-045',
            'tahun_perolehan' => 2022,
            'capacity' => '82 HP',
            'stock' => 2,
            'description' => 'Mesin panen padi kombinasi kapasitas besar. Mempercepat waktu panen dan mengurangi susut hasil panen secara signifikan.',
        ]);

        Alsintan::create([
            'name' => 'Pompa Air Irigasi',
            'category' => 'Pengairan',
            'merk' => 'Honda WL30XN',
            'nomor_rangka' => 'HON-30-2024-112',
            'nomor_mesin' => 'GX160-2024-112',
            'tahun_perolehan' => 2024,
            'capacity' => '3 Inch / 1100 L/min',
            'stock' => 15,
            'description' => 'Pompa air irigasi portabel berbahan bakar bensin. Sangat efektif untuk mengatasi kekeringan atau memompa air dari sungai/sumur dangkal ke lahan sawah.',
        ]);
    }
}
