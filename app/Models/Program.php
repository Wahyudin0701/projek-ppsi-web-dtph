<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'is_open',
        'open_date',
        'close_date',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'open_date' => 'date',
        'close_date' => 'date',
    ];

    /**
     * Get the proposals for the program.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
