<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\CheckInService;

class CheckInController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room.roomType', 'payment'])
            ->where('status', 'confirmed')
            ->whereHas('payment', fn($q) => $q->where('status', 'paid'))
            ->orderBy('check_in')
            ->paginate(15);

        return view('admin.checkin.index', compact('bookings'));
    }

    public function process(Booking $booking, CheckInService $checkInService)
    {
        try {
            $checkInService->checkIn($booking);
            return back()->with('success', "Guest {$booking->guest_name} checked in to Room {$booking->room->room_number}.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
