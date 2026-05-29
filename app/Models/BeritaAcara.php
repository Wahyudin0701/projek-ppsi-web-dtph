<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara';

    protected $fillable = [
        'proposal_id',
        'kabid_id',
        'content',
        'survey_date',
        'location',
        'recommendation',
        'attachment',
    ];

    protected $casts = [
        'survey_date' => 'date',
        'is_approved_by_pimpinan' => 'boolean',
    ];

    /**
     * recommendation: direkomendasikan | tidak_direkomendasikan | perlu_tindak_lanjut
     */
    public function getRecommendationLabelAttribute(): string
    {
        return match($this->recommendation) {
            'direkomendasikan'       => 'Direkomendasikan',
            'tidak_direkomendasikan' => 'Tidak Direkomendasikan',
            'perlu_tindak_lanjut'   => 'Perlu Tindak Lanjut',
            default                  => ucfirst($this->recommendation),
        };
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function kabid(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kabid_id');
    }
}
