<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CpclVerification extends Model
{
    protected $table = 'cpcl_verifications';

    protected $fillable = [
        'survey_assignment_id',
        'luas_lahan',
        'kondisi_lahan',
        'kesesuaian_komoditas',
        'rekomendasi_surveyor',
        'status_kepemilikan',
        'catatan',
        // Verifikasi Administrasi
        'is_surat_permohonan_sesuai', 'ket_surat_permohonan',
        'is_ktp_sesuai', 'ket_ktp',
        'is_sk_desa_sesuai', 'ket_sk_desa',
        'is_simluhtan_sesuai', 'ket_simluhtan',
        'is_notula_rapat_sesuai', 'ket_notula_rapat',
        'is_titik_koordinat_sesuai', 'ket_titik_koordinat',
        'is_tidak_menerima_bantuan_sama', 'ket_tidak_menerima_bantuan_sama'
    ];

    protected $casts = [
        'kesesuaian_komoditas' => 'boolean',
        'luas_lahan'           => 'decimal:2',
        'is_surat_permohonan_sesuai' => 'boolean',
        'is_ktp_sesuai' => 'boolean',
        'is_sk_desa_sesuai' => 'boolean',
        'is_simluhtan_sesuai' => 'boolean',
        'is_notula_rapat_sesuai' => 'boolean',
        'is_titik_koordinat_sesuai' => 'boolean',
        'is_tidak_menerima_bantuan_sama' => 'boolean',
    ];

    public function surveyAssignment(): BelongsTo
    {
        return $this->belongsTo(SurveyAssignment::class);
    }
}
