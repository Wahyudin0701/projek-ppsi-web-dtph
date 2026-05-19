<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProgramDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Program::truncate(); - Removed because migrate:fresh already empties the table and MySQL blocks truncate on FK referenced tables.

        $programs = [
            [
                'name' => 'Bantuan Traktor Roda 4 Tahap II',
                'type' => 'bantuan_permanen',
                'jenis' => 'alsintan',
                'description' => 'Program hibah traktor roda 4 untuk meningkatkan efisiensi pengolahan lahan sawah bagi kelompok tani di wilayah Kabupaten Muaro Jambi.',
                'sop_description' => "1. Kelompok tani mengajukan proposal.\n2. Verifikasi lapangan oleh tim dinas.\n3. Penetapan penerima melalui SK Bupati.\n4. Penyerahan unit dan pelatihan operasional.",
                'sasaran' => 'Kelompok Tani Padi & Palawija',
                'kuota' => '15 Unit',
                'requirements' => ['Terdaftar di Simluhtan', 'Memiliki luas hamparan minimal 25 Ha', 'Fotocopy KTP Pengurus', 'Berita Acara Pembentukan Kelompok'],
                'open_date' => Carbon::now()->subDays(5),
                'close_date' => Carbon::now()->addDays(10),
            ],
            [
                'name' => 'Pengadaan Benih Padi Inpari 32',
                'type' => 'bantuan_permanen',
                'jenis' => 'benih',
                'description' => 'Penyaluran benih padi varietas unggul Inpari 32 untuk musim tanam mendatang guna meningkatkan produktivitas hasil panen.',
                'sop_description' => 'Pendaftaran dilakukan secara kolektif melalui PPL masing-masing desa untuk diverifikasi kuota lahannya.',
                'sasaran' => 'Petani Sawah Tadah Hujan',
                'kuota' => '5000 Kg',
                'requirements' => ['Anggota Kelompok Tani Aktif', 'Luas lahan maksimal 2 Ha per anggota'],
                'open_date' => Carbon::now()->addDays(7),
                'close_date' => Carbon::now()->addDays(21),
            ],
            [
                'name' => 'Distribusi Pupuk NPK Subsidi',
                'type' => 'usulan_pendanaan',
                'jenis' => 'pupuk',
                'description' => 'Program percepatan distribusi pupuk subsidi untuk memastikan ketersediaan hara bagi tanaman pada fase vegetatif.',
                'sop_description' => 'Validasi berdasarkan e-RDKK yang telah diinput pada tahun sebelumnya.',
                'sasaran' => 'Seluruh Kelompok Tani Terdaftar',
                'kuota' => '200 Ton',
                'requirements' => ['Masuk dalam e-RDKK', 'Membawa kartu tani'],
                'open_date' => Carbon::now()->subDays(10),
                'close_date' => Carbon::now()->addDays(5),
            ],
            [
                'name' => 'Pelatihan Mekanisasi Pertanian Modern',
                'type' => 'usulan_pendanaan',
                'jenis' => 'pelatihan',
                'description' => 'Pelatihan intensif penggunaan teknologi drone sprayer dan alat tanam transplanter untuk efisiensi tenaga kerja.',
                'sop_description' => 'Pelatihan dilaksanakan di Balai Pelatihan Pertanian selama 3 hari kerja.',
                'sasaran' => 'Generasi Muda Tani (Milenial)',
                'kuota' => '40 Peserta',
                'requirements' => ['Usia 19-39 tahun', 'Mampu mengoperasikan smartphone'],
                'open_date' => Carbon::now()->subMonths(1),
                'close_date' => Carbon::now()->subDays(15),
            ],
            [
                'name' => 'Rehabilitasi Jaringan Irigasi Tersier',
                'type' => 'bantuan_permanen',
                'jenis' => 'infrastruktur',
                'description' => 'Perbaikan saluran irigasi yang rusak untuk menjamin suplai air hingga ke ujung petak sawah petani.',
                'sop_description' => 'Pengajuan berdasarkan survey kerusakan infrastruktur oleh P3A (Perkumpulan Petani Pemakai Air).',
                'sasaran' => 'P3A / Kelompok Tani',
                'kuota' => '8 Lokasi Desa',
                'requirements' => ['SK Pengesahan P3A', 'Dokumentasi kerusakan saluran (0%)'],
                'open_date' => Carbon::now()->subDays(2),
                'close_date' => Carbon::now()->addDays(20),
            ],
        ];

        foreach ($programs as $p) {
            Program::create($p);
        }
    }
}
