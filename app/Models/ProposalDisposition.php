<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalDisposition extends Model
{
    protected $fillable = [
        'proposal_id',
        'disposed_by',
        'disposed_to',
        'notes',
        'disposed_at',
    ];

    protected $casts = [
        'disposed_at' => 'datetime',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function disposedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disposed_by');
    }

    public function disposedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disposed_to');
    }
}
