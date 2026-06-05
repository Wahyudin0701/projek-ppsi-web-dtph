<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Program extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Program has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'type',
        'jenis',
        'open_date',
        'close_date',
        'description',
        'sop_description',
        'sasaran',
        'kuota',
        'requirements',
    ];

    protected $casts = [
        'is_open'      => 'boolean',
        'open_date'    => 'date',
        'close_date'   => 'date',
        'requirements' => 'array',
    ];

    /**
     * Compute status automatically from dates.
     * Returns: 'belum_berjalan' | 'berjalan' | 'selesai'
     */
    public function getStatusAttribute(): string
    {
        $now = now()->startOfDay();

        if (!$this->open_date) {
            return 'selesai';
        }

        if ($this->open_date->gt($now)) {
            return 'belum_berjalan';
        }

        // open_date <= today
        if ($this->close_date && $this->close_date->lt($now)) {
            return 'selesai';
        }

        return 'berjalan';
    }

    /**
     * is_open is derived from computed status for backward compatibility.
     */
    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'berjalan';
    }

    /**
     * Get the proposals for the program.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
