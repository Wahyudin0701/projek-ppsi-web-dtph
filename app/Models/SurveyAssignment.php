<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAssignment extends Model
{
    protected $fillable = [
        'proposal_id', 'nomor_surat', 'no_surat_pengajuan', 'no_sk_kelompok_tani', 'valid_from', 'valid_until', 'team_members',
    ];
    
    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'team_members' => 'array',
    ];

    public function proposal() { return $this->belongsTo(Proposal::class); }
    public function cpclVerifications() { return $this->hasMany(CpclVerification::class); }
}
