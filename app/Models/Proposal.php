<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'alsintan_id',
        'status',
        'submission_date',
        'lokasi_lahan',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
    ];

    /**
     * Get the user that owns the proposal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program that the proposal belongs to.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the alsintan that the proposal belongs to (if any).
     */
    public function alsintan(): BelongsTo
    {
        return $this->belongsTo(Alsintan::class);
    }
}
