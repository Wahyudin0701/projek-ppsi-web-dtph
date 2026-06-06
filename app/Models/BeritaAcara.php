<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaAcara extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => class_basename($this) . " has been {$eventName}");
    }

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
