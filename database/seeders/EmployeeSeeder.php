<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $structuralRolesList = [
            "Kepala Dinas", 
            "Sekretaris", 
            "Kasubbag Umum Kepegawaian", 
            "Fungsional Perencanaan", 
            "Fungsional Analis Keuangan Pusat dan Daerah", 
            "Kabid. Tanaman Pangan", 
            "Kabid. Hortikultura", 
            "Kabid. PSP", 
            "Kabid. Penyuluhan",
            "UPTD Balai Benih Utama Arang Arang"
        ];

        foreach ($structuralRolesList as $role) {
            Employee::firstOrCreate(
                ["role" => $role],
                ["name" => "Belum Diisi", "nip" => null, "pangkat_gol" => null, "bidang" => null]
            );
        }

        $fungsionalEmployees = [
            ["name" => "Umi Kalsum, SP", "nip" => "198001012010012001", "pangkat_gol" => "Penata / III c", "role" => "Penyuluh Pertanian", "bidang" => "Tanaman Pangan"],
            ["name" => "Budi Santoso, ST", "nip" => "198508172010011002", "pangkat_gol" => "Penata / III c", "role" => "Fungsional Umum", "bidang" => "Tanaman Pangan"],
            ["name" => "Ir. Candrawati", "nip" => "197505122005012003", "pangkat_gol" => "Pembina / IV a", "role" => "Fungsional Umum", "bidang" => "Hortikultura"],
            ["name" => "Ahmad Subandi, M.Si", "nip" => "197812122002121004", "pangkat_gol" => "Pembina TK I / IV b", "role" => "Pengawas Mutu", "bidang" => "PSP"],
            ["name" => "Raifizen, S.Pt", "nip" => "198203042008011005", "pangkat_gol" => "Penata TK I / III d", "role" => "Penyuluh", "bidang" => "Penyuluhan"],
            ["name" => "Ahmad Baikuni, S.TP", "nip" => "199001012015021006", "pangkat_gol" => "Penata Muda TK I / III b", "role" => "Penata Layanan Operasional", "bidang" => "Umum"],
        ];

        foreach ($fungsionalEmployees as $emp) {
            Employee::firstOrCreate(["nip" => $emp["nip"]], $emp);
        }
    }
}
