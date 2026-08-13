<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\CheckOutService;

class CheckOutController extends Controller
{
    protected CheckOutService $checkOutService;

    public function __construct(CheckOutService $checkOutService)
    {
        $this->checkOutService = $checkOutService;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'room.roomType', 'serviceOrders'])
            ->where('status', 'checked_in')
            ->orderBy('check_out')
            ->paginate(15);

        return view('admin.checkout.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return redirect()->route('admin.checkout.index')
                ->with('error', 'This booking is not checked in.');
        }

        $summary = $this->checkOutService->getCheckOutSummary($booking);
        return view('admin.checkout.show', compact('summary'));
    }

    public function process(Booking $booking)
    {
        try {
            $this->checkOutService->checkOut($booking);
            return redirect()->route('admin.checkout.index')
                ->with('success', "Guest {$booking->guest_name} checked out from Room {$booking->room->room_number}.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
