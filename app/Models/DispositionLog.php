<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispositionLog extends Model
{
    protected $table = 'proposal_dispositions';

    protected $fillable = [
        'proposal_id', 'disposed_by', 'disposed_to', 'notes', 'disposed_at',
    ];

    public function proposal() { return $this->belongsTo(Proposal::class); }
    public function fromUser() { return $this->belongsTo(User::class, 'disposed_by'); }
    public function toUser() { return $this->belongsTo(User::class, 'disposed_to'); }
}
