<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmumProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'no_wa',
        'alamat',
        'foto_ktp',
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
