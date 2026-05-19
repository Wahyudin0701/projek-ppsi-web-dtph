<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyDocumentation extends Model
{
    protected $table = 'survey_documentations';

    protected $fillable = [
        'proposal_id',
        'file_path',
        'keterangan',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
