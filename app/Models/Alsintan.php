<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alsintan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'merk',
        'capacity',
        'stock',
        'description',
        'image',
        'status',
    ];
}
