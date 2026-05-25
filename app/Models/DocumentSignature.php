<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSignature extends Model
{
    protected $fillable = [
        'uuid',
        'document_type',
        'document_id',
        'signed_by',
        'signed_at',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function signer()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}
