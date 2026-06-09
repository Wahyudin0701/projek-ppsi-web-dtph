<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Bantuan Traktor Roda 4',
                'program_category_id' => \App\Models\ProgramCategory::where('slug', 'alsintan')->first()->id ?? 1,
                'description' => 'Program hibah traktor roda 4 untuk meningkatkan efisiensi pengolahan lahan sawah bagi kelompok tani.',
                'sop_description' => "1. Kelompok tani mengajukan proposal.\n2. Verifikasi lapangan oleh tim dinas.\n3. Penetapan penerima melalui SK Bupati.\n4. Penyerahan unit dan pelatihan operasional.",
                'sasaran' => 'Kelompok Tani Padi & Palawija',
                'kuota' => '15 Unit',
                'requirements' => ['Terdaftar di Simluhtan', 'Memiliki luas hamparan minimal 25 Ha', 'Fotocopy KTP Pengurus', 'Berita Acara Pembentukan Kelompok'],
                'open_date' => Carbon::now()->subDays(5),
                'close_date' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Bantuan Benih Padi Hibrida',
                'program_category_id' => \App\Models\ProgramCategory::where('slug', 'benih')->first()->id ?? 2,
                'description' => 'Program bantuan benih padi unggul bersertifikat untuk meningkatkan produktivitas hasil panen.',
                'sop_description' => "1. Kelompok tani mengajukan permohonan dengan data CPCL.\n2. Validasi luas lahan oleh penyuluh.\n3. Distribusi benih ke titik bagi kelompok.",
                'sasaran' => 'Kelompok Tani Sawah Irigasi',
                'kuota' => '1000 Ha',
                'requirements' => ['Terdaftar di Simluhtan', 'Lahan irigasi teknis/setengah teknis', 'Fotocopy KTP Anggota CPCL'],
                'open_date' => Carbon::now()->subDays(2),
                'close_date' => Carbon::now()->addDays(60),
            ]
        ];

        foreach ($programs as $p) {
            Program::create($p);
        }
    }
}
