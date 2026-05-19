<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyChecklistItem extends Model
{
    protected $fillable = [
        'proposal_id',
        'surveyor_id',
        'item',
        'is_met',
        'notes',
        'photo',
        'checked_at',
        'sort_order',
    ];

    protected $casts = [
        'is_met'     => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }
}
