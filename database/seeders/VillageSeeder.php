<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = public_path('daftar_desa_kelurahan_muaro_jambi.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("File not found: " . $csvFile);
            return;
        }

        $file = fopen($csvFile, 'r');
        
        // Skip header
        $header = fgetcsv($file);

        $villages = [];
        while (($data = fgetcsv($file)) !== false) {
            // Kabupaten, Kecamatan, Status, Nama_Wilayah
            if (count($data) >= 4) {
                $villages[] = [
                    'kecamatan' => strtoupper(trim($data[1])), // Ensure uppercase to match frontend
                    'status' => trim($data[2]),
                    'name' => trim($data[3]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        fclose($file);

        if (count($villages) > 0) {
            \App\Models\Village::insert($villages);
            $this->command->info("Inserted " . count($villages) . " villages.");
        }
    }
}
