<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Promo;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['room.roomType', 'payment'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create(Room $room, Request $request)
    {
        $checkIn = $request->input('check_in', now()->addDay()->format('Y-m-d'));
        $checkOut = $request->input('check_out', now()->addDays(2)->format('Y-m-d'));
        $guests = $request->input('guests', 1);

        $pricing = $this->bookingService->calculatePricing($room, $checkIn, $checkOut);

        return view('customer.bookings.create', compact('room', 'checkIn', 'checkOut', 'guests', 'pricing'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'special_request' => 'nullable|string|max:1000',
            'promo_code' => 'nullable|string|max:30',
        ]);

        $validated['user_id'] = auth()->id();

        try {
            $booking = $this->bookingService->createBooking($validated);
            return redirect()->route('customer.payment.show', $booking)
                ->with('success', 'Booking created! Please complete your payment.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);
        $booking->load(['room.roomType', 'room.images', 'payment', 'serviceOrders.service', 'review']);

        return view('customer.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $this->bookingService->cancelBooking($booking, 'Cancelled by guest');

        return redirect()->route('customer.bookings')
            ->with('success', 'Booking cancelled successfully.');
    }

    public function downloadPdf(Booking $booking)
    {
        $this->authorizeBooking($booking);
        $booking->load(['room.roomType', 'payment', 'user']);

        $pdf = Pdf::loadView('pdf.booking-confirmation', compact('booking'));
        return $pdf->download("booking-{$booking->booking_number}.pdf");
    }

    public function validatePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $promo = Promo::where('code', strtoupper($request->code))->first();

        if (!$promo) {
            return response()->json(['valid' => false, 'message' => 'Promo code not found.']);
        }

        if (!$promo->isValid($request->subtotal)) {
            return response()->json(['valid' => false, 'message' => 'Promo code is invalid or expired.']);
        }

        $discount = $promo->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'promo_name' => $promo->name,
            'message' => "Promo applied! You save " . number_format($discount, 0, ',', '.'),
        ]);
    }

    private function authorizeBooking(Booking $booking): void
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
