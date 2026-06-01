<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'nip', 'pangkat_gol', 'role', 'foto', 'bidang'];
}
