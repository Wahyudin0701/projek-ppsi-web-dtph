<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            // Verifikasi Administrasi
            $table->boolean('is_surat_permohonan_sesuai')->default(false)->after('status_kepemilikan');
            $table->string('ket_surat_permohonan')->nullable()->after('is_surat_permohonan_sesuai');
            $table->boolean('is_ktp_sesuai')->default(false)->after('ket_surat_permohonan');
            $table->string('ket_ktp')->nullable()->after('is_ktp_sesuai');
            $table->boolean('is_sk_desa_sesuai')->default(false)->after('ket_ktp');
            $table->string('ket_sk_desa')->nullable()->after('is_sk_desa_sesuai');
            $table->boolean('is_simluhtan_sesuai')->default(false)->after('ket_sk_desa');
            $table->string('ket_simluhtan')->nullable()->after('is_simluhtan_sesuai');
            $table->boolean('is_notula_rapat_sesuai')->default(false)->after('ket_simluhtan');
            $table->string('ket_notula_rapat')->nullable()->after('is_notula_rapat_sesuai');
            $table->boolean('is_titik_koordinat_sesuai')->default(false)->after('ket_notula_rapat');
            $table->string('ket_titik_koordinat')->nullable()->after('is_titik_koordinat_sesuai');
            $table->boolean('is_tidak_menerima_bantuan_sama')->default(false)->after('ket_titik_koordinat');
            $table->string('ket_tidak_menerima_bantuan_sama')->nullable()->after('is_tidak_menerima_bantuan_sama');

            // Teknis Lahan Baru
            $table->string('jenis_tanah')->nullable()->after('ket_tidak_menerima_bantuan_sama');
            $table->string('sumber_air')->nullable()->after('jenis_tanah');
            $table->string('rawan_bencana')->nullable()->after('sumber_air');
            $table->string('pemanfaatan_lahan_sebelumnya')->nullable()->after('rawan_bencana');
            $table->string('pengalaman_budidaya')->nullable()->after('pemanfaatan_lahan_sebelumnya');

            // Petugas Lapangan
            $table->string('petugas_dokumentasi')->nullable()->after('pengalaman_budidaya');
            $table->string('petugas_pemetaan')->nullable()->after('petugas_dokumentasi');
            $table->string('no_hp_pemetaan')->nullable()->after('petugas_pemetaan');

            // Tanda Tangan
            $table->string('penandatangan_poktan_nama')->nullable()->after('no_hp_pemetaan');
            $table->string('penandatangan_poktan_jabatan')->nullable()->after('penandatangan_poktan_nama');
            $table->string('nama_ppl')->nullable()->after('penandatangan_poktan_jabatan');
            $table->string('nip_ppl')->nullable()->after('nama_ppl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->dropColumn([
                'is_surat_permohonan_sesuai', 'ket_surat_permohonan',
                'is_ktp_sesuai', 'ket_ktp',
                'is_sk_desa_sesuai', 'ket_sk_desa',
                'is_simluhtan_sesuai', 'ket_simluhtan',
                'is_notula_rapat_sesuai', 'ket_notula_rapat',
                'is_titik_koordinat_sesuai', 'ket_titik_koordinat',
                'is_tidak_menerima_bantuan_sama', 'ket_tidak_menerima_bantuan_sama',
                'jenis_tanah', 'sumber_air', 'rawan_bencana', 'pemanfaatan_lahan_sebelumnya', 'pengalaman_budidaya',
                'petugas_dokumentasi', 'petugas_pemetaan', 'no_hp_pemetaan',
                'penandatangan_poktan_nama', 'penandatangan_poktan_jabatan',
                'nama_ppl', 'nip_ppl'
            ]);
        });
    }
};
