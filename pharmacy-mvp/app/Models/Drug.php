<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drug extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_price',
        'expiry_date',
        'low_stock_threshold',
        'batch_number',
        'manufacturer'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'unit_price' => 'decimal:2'
    ];

    /**
     * Check if the drug is low in stock
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->low_stock_threshold;
    }

    /**
     * Check if the drug is expired
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if the drug is expiring soon (within 30 days)
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expiry_date && 
               $this->expiry_date->isFuture() && 
               $this->expiry_date->diffInDays(now()) <= $days;
    }

    /**
     * Scope for low stock items
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= low_stock_threshold');
    }

    /**
     * Scope for expired items
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /**
     * Scope for items expiring soon
     */
    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->where('expiry_date', '>', now())
                    ->where('expiry_date', '<=', now()->addDays($days));
    }

    // Relationships
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Analytics methods
    public function getTotalSoldAttribute(): int
    {
        return $this->saleItems()->sum('quantity');
    }

    public function getRevenueAttribute(): float
    {
        return $this->saleItems()->sum('line_total');
    }
}
