<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_number', 'booking_id', 'method', 'amount',
        'status', 'paid_at', 'transaction_ref', 'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function generatePaymentNumber(): string
    {
        $year = date('Y');
        $last = static::max('id') ?? 0;
        $sequence = str_pad($last + 1, 5, '0', STR_PAD_LEFT);
        return "PAY-{$year}-{$sequence}";
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getTransactionIdAttribute(): string
    {
        return $this->transaction_ref ?? $this->payment_number ?? 'PAY-' . $this->id;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'paid' => 'badge-success',
            'failed' => 'badge-danger',
            'refunded' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary',
        };
    }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'bank_transfer' => 'Bank Transfer',
            'credit_card' => 'Credit Card',
            'e_wallet' => 'E-Wallet',
            'cash' => 'Cash',
            default => ucfirst($this->method),
        };
    }
}
