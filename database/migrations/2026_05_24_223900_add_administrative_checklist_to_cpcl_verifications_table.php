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
            $table->boolean('is_surat_permohonan_sesuai')->nullable();
            $table->string('ket_surat_permohonan')->nullable();
            
            $table->boolean('is_ktp_sesuai')->nullable();
            $table->string('ket_ktp')->nullable();
            
            $table->boolean('is_sk_desa_sesuai')->nullable();
            $table->string('ket_sk_desa')->nullable();
            
            $table->boolean('is_simluhtan_sesuai')->nullable();
            $table->string('ket_simluhtan')->nullable();
            
            $table->boolean('is_notula_rapat_sesuai')->nullable();
            $table->string('ket_notula_rapat')->nullable();
            
            $table->boolean('is_titik_koordinat_sesuai')->nullable();
            $table->string('ket_titik_koordinat')->nullable();
            
            $table->boolean('is_tidak_menerima_bantuan_sama')->nullable();
            $table->string('ket_tidak_menerima_bantuan_sama')->nullable();
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
                'is_tidak_menerima_bantuan_sama', 'ket_tidak_menerima_bantuan_sama'
            ]);
        });
    }
};
