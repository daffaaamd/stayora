<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'discount_type', 'discount_value',
        'min_booking', 'start_date', 'end_date', 'usage_limit', 'used_count', 'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_booking' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function isValid(float $bookingTotal = 0): bool
    {
        if (!$this->is_active) return false;
        if (now()->lt($this->start_date) || now()->gt($this->end_date)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($bookingTotal > 0 && $bookingTotal < $this->min_booking) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percentage') {
            return round($subtotal * ($this->discount_value / 100), 2);
        }
        return min($this->discount_value, $subtotal);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }
}
