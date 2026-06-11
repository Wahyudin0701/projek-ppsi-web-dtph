<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FarmerProfile extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Farmer Profile has been {$eventName}");
    }

    protected $fillable = [
        'user_id',
        'status',
        'nama_kelompok',
        'id_poktan',
        'no_sk',
        'ketua',
        'nik_ketua',
        'kontak',
        'grade',
        'luas_lahan',
        'komoditi',
        'komoditi_utama',
        'alamat',
        'desa',
        'kecamatan',
        'sk_pengukuhan_path',
        'rejection_reason',
        'is_verified_acknowledged',
        'change_request_reason',
        'foto_ktp',
    ];

    protected $casts = [
        'is_verified_acknowledged' => 'boolean',
        'luas_lahan' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verificationLogs()
    {
        return $this->hasMany(FarmerVerificationLog::class)->latest();
    }

    public function members()
    {
        return $this->hasMany(FarmerGroupMember::class);
    }
}
