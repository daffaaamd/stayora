<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number', 'user_id', 'room_id',
        'guest_name', 'guest_email', 'guest_phone',
        'check_in', 'check_out', 'guests', 'nights',
        'special_request',
        'room_price', 'subtotal', 'tax', 'service_charge', 'discount', 'promo_code', 'total',
        'status', 'confirmed_at', 'checked_in_at', 'checked_out_at',
        'cancelled_at', 'cancellation_reason',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'room_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Generate unique booking number
    public static function generateBookingNumber(): string
    {
        $year = date('Y');
        $last = static::max('id') ?? 0;
        $sequence = str_pad($last + 1, 5, '0', STR_PAD_LEFT);
        return "STY-{$year}-{$sequence}";
    }

    // Status helpers
    public function isPaid(): bool
    {
        return $this->payment && $this->payment->status === 'paid';
    }

    public function isPendingPayment(): bool
    {
        return $this->status === 'pending_payment';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCheckedIn(): bool
    {
        return $this->status === 'checked_in';
    }

    public function isCheckedOut(): bool
    {
        return $this->status === 'checked_out';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled(): bool
    {
        if (!in_array($this->status, ['pending_payment', 'confirmed'])) {
            return false;
        }
        // Free cancellation: more than 48 hours before check-in
        return $this->check_in->diffInHours(now()) > 48;
    }

    public function canCheckIn(): bool
    {
        return $this->status === 'confirmed'
            && $this->payment
            && $this->payment->status === 'paid'
            && $this->check_in->lte(now()->addDay());
    }

    public function canCheckOut(): bool
    {
        return $this->status === 'checked_in';
    }

    public function canReview(): bool
    {
        return in_array($this->status, ['checked_out', 'completed']) && !$this->review;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending_payment' => 'warning',
            'confirmed' => 'info',
            'checked_in' => 'primary',
            'checked_out' => 'secondary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getAdditionalChargesAttribute(): float
    {
        return $this->serviceOrders()->where('status', 'completed')->sum('total');
    }

    public function getFinalTotalAttribute(): float
    {
        return $this->total + $this->additional_charges;
    }

    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['confirmed', 'checked_in'])
                     ->where('check_in', '>=', now()->startOfDay());
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled']);
    }
}
