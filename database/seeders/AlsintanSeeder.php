<?php

namespace Database\Seeders;

use App\Models\Alsintan;
use Illuminate\Database\Seeder;

class AlsintanSeeder extends Seeder
{
    public function run(): void
    {
        $alsintans = [
            [
                'name'        => 'Rice Transplanter',
                'merk'        => 'Kubota SPW-48C',
                'category'    => 'tanam',
                'capacity'    => '4 baris / 0.1 Ha per jam',
                'stock'       => 2,
                'borrowed_count' => 0,
                'broken_count'   => 0,
                'description' => 'Alat tanam padi otomatis 4 baris yang meningkatkan kecepatan tanam, menjaga keseragaman jarak tanam, dan mengurangi tenaga kerja manual secara drastis.',
            ],
        ];

        foreach ($alsintans as $data) {
            // Cek apakah sudah ada berdasarkan name, jika belum baru insert
            Alsintan::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
