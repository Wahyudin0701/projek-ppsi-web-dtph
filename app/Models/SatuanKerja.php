<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SatuanKerja extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nama',
        'alamat',
        'koordinator',
        'hp',
        'maps',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'alamat', 'koordinator', 'hp', 'maps'])
            ->logOnlyDirty()
            ->useLogName('satuan_kerja')
            ->setDescriptionForEvent(fn(string $eventName) => "This satuan kerja has been {$eventName}");
    }
}
