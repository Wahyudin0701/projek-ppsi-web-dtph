<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

class SurveyAssignment extends Model
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

    protected $fillable = [
        'proposal_id', 'nomor_surat', 'no_sk_kelompok_tani', 'valid_from', 'valid_until', 'team_members', 'is_approved_by_pimpinan',
    ];
    
    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'team_members' => 'array',
        'is_approved_by_pimpinan' => 'boolean',
    ];

    public function proposal() { return $this->belongsTo(Proposal::class); }
    public function cpclVerifications() { return $this->hasMany(CpclVerification::class); }
}
