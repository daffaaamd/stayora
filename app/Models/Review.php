<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id', 'user_id', 'room_id',
        'rating', 'room_rating', 'service_rating', 'cleanliness_rating',
        'comment', 'is_visible', 'is_moderated',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_moderated' => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
