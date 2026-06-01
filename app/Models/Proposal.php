<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'alsintan_id',
        'status',
        'nomor_dokumen_final',
        'no_surat_pengajuan',
        'submission_date',
        'rencana_durasi_hari',
        'reviewed_at',
        'decided_at',
        'admin_notes',
        'pimpinan_notes',
        'kabid_id',
        'disposition_notes',
        'kabid_notes',
        'foto_lahan',
        'foto_pemetaan',
        'file_proposal',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'reviewed_at'     => 'datetime',
        'decided_at'      => 'datetime',
    ];

    /**
     * Status flow (Hybrid Digital-Physical):
     * sedang_diverifikasi_admin → sedang_diverifikasi_pimpinan → persiapan_survei
     * → sedang_survei (Kabid terbitkan, survei fisik)
     * → verifikasi_cpcl (Admin input CPCL & generate BA, Kabid review)
     * → menunggu_keputusan_akhir (Kabid teruskan ke Pimpinan) → disetujui | ditolak
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'sedang_diverifikasi_admin'    => 'Sedang Diverifikasi Admin',
            'sedang_diverifikasi_pimpinan' => 'Sedang Diverifikasi Pimpinan',
            'persiapan_survei'             => 'Persiapan Survei',
            'sedang_survei'                => 'Sedang Survei',
            'survei_selesai'               => 'Survei Selesai',
            'verifikasi_cpcl'              => 'Verifikasi CPCL',
            'menunggu_keputusan_akhir'     => 'Menunggu Keputusan Akhir',
            'disetujui'                    => 'Disetujui',
            'ditolak'                      => 'Ditolak',
            default                  => ucfirst($this->status),
        };
    }

    /**
     * Get the user that owns the proposal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program that the proposal belongs to.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the alsintan that the proposal belongs to (if any).
     */
    public function alsintan(): BelongsTo
    {
        return $this->belongsTo(Alsintan::class);
    }

    /**
     * Kabid assigned to this proposal.
     */
    public function kabid(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kabid_id');
    }

    /**
     * Disposition logs for this proposal.
     */
    public function dispositionLogs()
    {
        return $this->hasMany(DispositionLog::class);
    }

    /**
     * Latest disposition log.
     */
    public function latestDispositionLog()
    {
        return $this->hasOne(DispositionLog::class)->latestOfMany();
    }

    /**
     * Survey assignments for this proposal.
     */
    public function surveyAssignments()
    {
        return $this->hasMany(SurveyAssignment::class);
    }

    /**
     * Berita acara for this proposal.
     */
    public function beritaAcara(): HasOne
    {
        return $this->hasOne(BeritaAcara::class);
    }

    /**
     * CPCL Verifications (via SurveyAssignment).
     */
    public function cpclVerifications(): HasManyThrough
    {
        return $this->hasManyThrough(CpclVerification::class, SurveyAssignment::class);
    }

    /**
     * Survey photo documentations.
     */
    public function surveyDocumentations(): HasMany
    {
        return $this->hasMany(SurveyDocumentation::class);
    }
}
