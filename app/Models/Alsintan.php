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

    protected $appends = ['stock', 'broken_count', 'borrowed_count', 'available_stock'];

    protected $fillable = [
        'name',
        'alsintan_category_id',
        'merk',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(AlsintanCategory::class, 'alsintan_category_id');
    }

    public function inventories()
    {
        return $this->hasMany(AlsintanInventory::class);
    }

    public function getStockAttribute(): int
    {
        if ($this->relationLoaded('inventories')) {
            return $this->inventories->count();
        }
        return $this->inventories()->count();
    }

    public function getBrokenCountAttribute(): int
    {
        if ($this->relationLoaded('inventories')) {
            return $this->inventories->where('status_ketersediaan', 'Sedang Rusak')->count();
        }
        return $this->inventories()->where('status_ketersediaan', 'Sedang Rusak')->count();
    }

    public function getBorrowedCountAttribute(): int
    {
        if ($this->relationLoaded('inventories')) {
            return $this->inventories->where('status_ketersediaan', 'Dipinjam')->count();
        }
        return $this->inventories()->where('status_ketersediaan', 'Dipinjam')->count();
    }

    /**
     * Get the available stock.
     */
    public function getAvailableStockAttribute(): int
    {
        if ($this->relationLoaded('inventories')) {
            return $this->inventories->where('status_ketersediaan', 'Tersedia')->count();
        }
        return $this->inventories()->where('status_ketersediaan', 'Tersedia')->count();
    }
}
