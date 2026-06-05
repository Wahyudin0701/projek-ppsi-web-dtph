<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SatuanKerja;

class SatuanKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bppList = [
            ['nama' => 'BPP Kec. Sekernan', 'alamat' => 'Jl. Lintas Timur, Sekernan', 'koordinator' => 'Eko Prasetyo, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sekernan+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Sungai Gelam', 'alamat' => 'Jl. Poros Sungai Gelam', 'koordinator' => 'Dewi Lestari, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sungai+Gelam+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Kumpeh', 'alamat' => 'Jl. Raya Kumpeh', 'koordinator' => 'M. Ridwan, S.P.', 'hp' => '0821-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Kumpeh+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Kumpeh Ulu', 'alamat' => 'Jl. Kumpeh Ulu No. 12', 'koordinator' => 'Fitriani, S.P.', 'hp' => '0852-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Kumpeh+Ulu+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Mestong', 'alamat' => 'Jl. Lintas Sumatera, KM 23', 'koordinator' => 'Heri Susanto, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Mestong+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Jambi Luar Kota', 'alamat' => 'Pematang Gajah, Jaluko', 'koordinator' => 'Ani Maryani, S.P.', 'hp' => '0811-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Jambi+Luar+Kota+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Bahar Selatan', 'alamat' => 'Unit 4 Bahar Selatan', 'koordinator' => 'Supriadi, S.P.', 'hp' => '0822-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Bahar+Selatan+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Bahar Utara', 'alamat' => 'Unit 1 Bahar Utara', 'koordinator' => 'Yuni Astuti, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Bahar+Utara+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Taman Rajo', 'alamat' => 'Kec. Taman Rajo', 'koordinator' => 'Darmawan, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Taman+Rajo+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Sungai Bahar', 'alamat' => 'Unit 2 Sungai Bahar', 'koordinator' => 'Ratna Wulan, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sungai+Bahar+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Maro Sebo', 'alamat' => 'Kec. Maro Sebo', 'koordinator' => 'Junaidi, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Maro+Sebo+Muaro+Jambi'],
            ['nama' => 'BPP Kec. Dendang', 'alamat' => 'Kec. Dendang', 'koordinator' => 'Sari Indah, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Dendang+Muaro+Jambi'],
        ];

        foreach ($bppList as $bpp) {
            SatuanKerja::create($bpp);
        }
    }
}
