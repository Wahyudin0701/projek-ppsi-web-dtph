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
            ]
        ];

        foreach ($programs as $p) {
            Program::create($p);
        }
    }
}
