<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $statusMap = [
            'pending_verifikasi'     => 'sedang_diverifikasi_admin',
            'menunggu'               => 'sedang_diverifikasi_admin',
            'diteruskan_ke_pimpinan' => 'sedang_diverifikasi_pimpinan',
            'didisposisi_kabid'      => 'persiapan_survei',
            'surat_tugas_terbit'     => 'sedang_survei',
            'survei_selesai'         => 'survei_selesai',
            'menunggu_review_kabid'  => 'verifikasi_cpcl',
            'menunggu_approval_ba'   => 'menunggu_keputusan_akhir',
            'disetujui'              => 'disetujui',
            'ditolak'                => 'ditolak',
        ];

        foreach ($statusMap as $old => $new) {
            DB::table('proposals')->where('status', $old)->update(['status' => $new]);
        }
        
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('status')->default('sedang_diverifikasi_admin')->change();
        });
    }

    public function down(): void
    {
        $statusMap = [
            'sedang_diverifikasi_admin'    => 'pending_verifikasi',
            'sedang_diverifikasi_pimpinan' => 'diteruskan_ke_pimpinan',
            'persiapan_survei'             => 'didisposisi_kabid',
            'sedang_survei'                => 'surat_tugas_terbit',
            'survei_selesai'               => 'survei_selesai',
            'verifikasi_cpcl'              => 'menunggu_review_kabid',
            'menunggu_keputusan_akhir'     => 'menunggu_approval_ba',
            'disetujui'                    => 'disetujui',
            'ditolak'                      => 'ditolak',
        ];

        foreach ($statusMap as $old => $new) {
            DB::table('proposals')->where('status', $old)->update(['status' => $new]);
        }

        Schema::table('proposals', function (Blueprint $table) {
            $table->string('status')->default('menunggu')->change();
        });
    }
};
