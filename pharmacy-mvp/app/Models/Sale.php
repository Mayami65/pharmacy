<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'sale_number',
        'customer_name',
        'customer_phone',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'payment_method',
        'amount_paid',
        'change_amount',
        'status',
        'notes',
        'served_by'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2'
    ];

    // Relationships
    public function server(): BelongsTo
    {
        return $this->belongsTo(User::class, 'served_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Helper methods
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            'refunded' => 'orange',
            default => 'gray'
        };
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    public function getNetAmountAttribute(): float
    {
        return $this->subtotal - $this->discount_amount + $this->tax_amount;
    }

    public function generateSaleNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $day = now()->format('d');
        $count = static::whereDate('created_at', today())->count() + 1;
        return "SL{$year}{$month}{$day}" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function calculateChange(): float
    {
        return max(0, $this->amount_paid - $this->total_amount);
    }
}
