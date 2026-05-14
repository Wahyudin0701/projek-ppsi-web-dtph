<?php

namespace Database\Seeders;

use App\Models\Alsintan;
use Illuminate\Database\Seeder;

class AlsintanSeeder extends Seeder
{
    public function run(): void
    {
        // Update alat yang ada (status rusak) jadi tersedia
        Alsintan::where('status', '!=', 'tersedia')->update(['status' => 'tersedia']);

        $alsintans = [
            [
                'name'        => 'Traktor Roda Empat',
                'merk'        => 'Yanmar YT347',
                'category'    => 'traktor',
                'capacity'    => '35 HP / 1.2 Ha per jam',
                'stock'       => 2,
                'status'      => 'tersedia',
                'description' => 'Traktor roda empat bertenaga 35 HP cocok untuk pengolahan lahan basah maupun kering. Dilengkapi transmisi otomatis dan kabin ergonomis untuk meningkatkan efisiensi kerja petani.',
            ],
            [
                'name'        => 'Combine Harvester',
                'merk'        => 'Kubota DC-70',
                'category'    => 'panen',
                'capacity'    => '0.3 Ha per jam',
                'stock'       => 1,
                'status'      => 'tersedia',
                'description' => 'Mesin pemanen padi serbaguna yang dapat memanen, mengirik, dan membersihkan gabah sekaligus dalam satu operasi. Mengurangi losses panen secara signifikan.',
            ],
            [
                'name'        => 'Pompa Air Sentrifugal',
                'merk'        => 'Grundfos CM5',
                'category'    => 'irigasi',
                'capacity'    => '5 m3 per jam',
                'stock'       => 4,
                'status'      => 'tersedia',
                'description' => 'Pompa air irigasi bertenaga diesel dengan daya hisap tinggi dan konsumsi bahan bakar yang efisien. Cocok untuk pengairan sawah di musim kemarau.',
            ],
            [
                'name'        => 'Rice Transplanter',
                'merk'        => 'Kubota SPW-48C',
                'category'    => 'tanam',
                'capacity'    => '4 baris / 0.1 Ha per jam',
                'stock'       => 2,
                'status'      => 'tersedia',
                'description' => 'Alat tanam padi otomatis 4 baris yang meningkatkan kecepatan tanam, menjaga keseragaman jarak tanam, dan mengurangi tenaga kerja manual secara drastis.',
            ],
            [
                'name'        => 'Power Thresher',
                'merk'        => 'Agrindo GD-800',
                'category'    => 'pasca panen',
                'capacity'    => '800 kg per jam',
                'stock'       => 3,
                'status'      => 'tersedia',
                'description' => 'Mesin perontok padi multi-komoditas dengan kapasitas 800 kg/jam. Dapat digunakan untuk padi, jagung, dan kedelai. Dirancang untuk mengurangi kehilangan hasil panen.',
            ],
            [
                'name'        => 'Cultivator Rotary',
                'merk'        => 'Quick Razor 800',
                'category'    => 'traktor',
                'capacity'    => '0.8 Ha per jam',
                'stock'       => 3,
                'status'      => 'tersedia',
                'description' => 'Kultivator rotary untuk pengolahan tanah ringan dan penyiangan. Ideal untuk lahan sempit, lahan kering, dan area perkebunan hortikultura.',
            ],
        ];

        foreach ($alsintans as $data) {
            // Cek apakah sudah ada berdasarkan name, jika belum baru insert
            Alsintan::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
