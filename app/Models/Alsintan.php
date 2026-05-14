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
        'borrowed_count',
        'broken_count',
        'description',
        'image',
    ];

    /**
     * Get the available stock.
     */
    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stock - $this->borrowed_count - $this->broken_count);
    }
}
