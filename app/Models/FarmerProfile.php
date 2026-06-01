<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        'kecamatan',
        'status',
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
