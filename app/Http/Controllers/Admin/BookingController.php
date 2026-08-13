<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room.roomType', 'payment']);

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date_from')) $query->where('check_in', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->where('check_out', '<=', $request->date_to);
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_number', 'like', "%{$request->search}%")
                  ->orWhere('guest_name', 'like', "%{$request->search}%");
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room.roomType', 'room.images', 'payment', 'serviceOrders.service', 'review']);
        $services = Service::where('is_active', true)->get();
        return view('admin.bookings.show', compact('booking', 'services'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending_payment,confirmed,checked_in,checked_out,completed,cancelled']);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Booking status updated.');
    }

    public function addServiceOrder(Request $request, Booking $booking)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($request->service_id);

        ServiceOrder::create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'quantity' => $request->quantity,
            'price' => $service->price,
            'total' => $service->price * $request->quantity,
            'status' => 'completed',
            'notes' => $request->notes,
        ]);

        return back()->with('success', "Service '{$service->name}' added to booking.");
    }
}
