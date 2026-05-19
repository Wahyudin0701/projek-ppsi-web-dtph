<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CpclVerification extends Model
{
    protected $table = 'cpcl_verifications';

    protected $fillable = [
        'survey_assignment_id',
        'status_kepemilikan',
        'luas_lahan',
        'kondisi_lahan',
        'kesesuaian_komoditas',
        'rekomendasi_surveyor',
        'catatan',
    ];

    protected $casts = [
        'kesesuaian_komoditas' => 'boolean',
        'luas_lahan'           => 'decimal:2',
    ];

    public function surveyAssignment(): BelongsTo
    {
        return $this->belongsTo(SurveyAssignment::class);
    }
}
