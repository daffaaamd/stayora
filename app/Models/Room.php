<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'name',
        'slug',
        'floor',
        'size_sqm',
        'view_type',
        'bed_type',
        'max_occupancy',
        'price_per_night',
        'description',
        'status',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'size_sqm' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        if ($primary && $primary->image_path) {
            if (str_starts_with($primary->image_path, 'http://') || str_starts_with($primary->image_path, 'https://')) {
                return $primary->image_path;
            }
            return asset('storage/' . $primary->image_path);
        }
        $first = $this->images()->first();
        if ($first && $first->image_path) {
            if (str_starts_with($first->image_path, 'http://') || str_starts_with($first->image_path, 'https://')) {
                return $first->image_path;
            }
            return asset('storage/' . $first->image_path);
        }
        return 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80';
    }

    public function getAverageRatingAttribute(): ?float
    {
        $avg = $this->reviews()->where('is_visible', true)->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_visible', true)->count();
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->status === 'available';
    }

    public function isAvailableForDates($checkIn, $checkOut): bool
    {
        if (!$this->is_active || $this->status === 'maintenance' || $this->status === 'out_of_service') {
            return false;
        }

        return !$this->bookings()
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                      ->where('check_out', '>', $checkIn);
                });
            })
            ->exists();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('is_active', true);
    }
}
