<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AlsintanInventory extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'alsintan_id',
        'nomor_rangka',
        'nomor_mesin',
        'sumber_dana',
        'tahun_pengadaan',
        'latitude',
        'longitude',
        'status_ketersediaan',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Alsintan Inventory has been {$eventName}");
    }

    public function alsintan()
    {
        return $this->belongsTo(Alsintan::class);
    }
}
