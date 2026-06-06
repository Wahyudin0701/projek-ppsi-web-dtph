<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $structuralRoles = [
            "Kepala Dinas" => ["name" => "Ir. EVI SYAHRUL, SP, M.Si", "nip" => "196805101995031001"],
            "Sekretaris" => ["name" => "M. RIDWAN, SP", "nip" => "197002151996031002"],
            "Kasubbag Umum Kepegawaian" => ["name" => "RAIFIZEN, S.Ag, MM", "nip" => "197208201998031003"],
            "Fungsional Perencanaan" => ["name" => "E. SUPERATMAN, SP", "nip" => "197503122000031004"],
            "Fungsional Analis Keuangan Pusat dan Daerah" => ["name" => "ARLIYANZA. SE", "nip" => "197811222002031005"],
            "Kabid. Tanaman Pangan" => ["name" => "UMI KALSUM, SP", "nip" => "197109151997032006"],
            "Kabid. Hortikultura" => ["name" => "Ir. CANDRAWATI", "nip" => "197304181999032007"],
            "Kabid. PSP" => ["name" => "AHMAD SUKRI, SP", "nip" => "197607252001031008"],
            "Kabid. Penyuluhan" => ["name" => "LUTHFI NOOR, SP", "nip" => "197412102000031009"],
            "UPTD Balai Benih Utama Arang Arang" => ["name" => "AHMAD BAIKUNI, S.TP", "nip" => "198005052005031010"]
        ];

        foreach ($structuralRoles as $role => $data) {
            Employee::firstOrCreate(
                ["role" => $role],
                ["name" => $data["name"], "nip" => $data["nip"], "pangkat_gol" => null, "bidang" => null]
            );
        }

        $fungsionalEmployees = [
            ["name" => "Siti Aminah, SP", "nip" => "198001012010012001", "pangkat_gol" => "Penata / III c", "role" => "Penyuluh Pertanian", "bidang" => "Tanaman Pangan"],
            ["name" => "Budi Santoso, ST", "nip" => "198508172010011002", "pangkat_gol" => "Penata / III c", "role" => "Fungsional Umum", "bidang" => "Tanaman Pangan"],
            ["name" => "Ir. Susilawati", "nip" => "197505122005012003", "pangkat_gol" => "Pembina / IV a", "role" => "Fungsional Umum", "bidang" => "Hortikultura"],
            ["name" => "Ahmad Subandi, M.Si", "nip" => "197812122002121004", "pangkat_gol" => "Pembina TK I / IV b", "role" => "Pengawas Mutu", "bidang" => "PSP"],
            ["name" => "Joko Suprianto, S.Pt", "nip" => "198203042008011005", "pangkat_gol" => "Penata TK I / III d", "role" => "Penyuluh", "bidang" => "Penyuluhan"],
            ["name" => "Rahmat Hidayat, S.TP", "nip" => "199001012015021006", "pangkat_gol" => "Penata Muda TK I / III b", "role" => "Penata Layanan Operasional", "bidang" => "Umum"],
        ];

        foreach ($fungsionalEmployees as $emp) {
            Employee::firstOrCreate(["nip" => $emp["nip"]], $emp);
        }
    }
}
