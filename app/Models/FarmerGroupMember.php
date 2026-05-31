<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_profile_id',
        'nama',
        'nik',
    ];

    public function farmerProfile()
    {
        return $this->belongsTo(FarmerProfile::class);
    }
}
