<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviews()
            ->with(['room.roomType', 'booking'])
            ->latest()
            ->paginate(10);

        return view('customer.reviews.index', compact('reviews'));
    }

    public function create(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        if (!$booking->canReview()) {
            return back()->with('error', 'You cannot review this booking.');
        }

        $booking->load(['room.roomType']);

        return view('customer.reviews.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'room_rating' => 'required|integer|min:1|max:5',
            'service_rating' => 'required|integer|min:1|max:5',
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);
        if ($booking->user_id !== auth()->id() || !$booking->canReview()) {
            abort(403);
        }

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'room_id' => $booking->room_id,
            'rating' => $validated['rating'],
            'room_rating' => $validated['room_rating'],
            'service_rating' => $validated['service_rating'],
            'cleanliness_rating' => $validated['cleanliness_rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Thank you for your review!');
    }
}
