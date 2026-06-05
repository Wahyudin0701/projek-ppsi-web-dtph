<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Alsintan extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Alsintan has been {$eventName}");
    }

    protected $appends = ['available_stock'];

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
