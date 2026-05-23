<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmerVerificationLog extends Model
{
    protected $fillable = [
        'farmer_profile_id',
        'admin_id',
        'status',
        'notes',
    ];

    public function farmerProfile()
    {
        return $this->belongsTo(FarmerProfile::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
