<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'drug_id',
        'quantity',
        'unit_price',
        'line_total',
        'discount_amount',
        'batch_number',
        'expiry_date'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'expiry_date' => 'date'
    ];

    // Relationships
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class);
    }

    // Helper methods
    public function getNetTotalAttribute(): float
    {
        return $this->line_total - $this->discount_amount;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if ($this->line_total === 0) {
            return 0;
        }
        return ($this->discount_amount / $this->line_total) * 100;
    }
}
