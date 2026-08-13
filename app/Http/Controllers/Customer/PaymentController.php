<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        if ($booking->status !== 'pending_payment') {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('warning', 'This booking has already been paid.');
        }

        $booking->load(['room.roomType', 'room.images']);

        return view('customer.payment.show', compact('booking'));
    }

    public function process(Booking $booking, Request $request)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        if ($booking->status !== 'pending_payment') {
            return redirect()->route('customer.bookings.show', $booking);
        }

        $request->validate([
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet,cash',
        ]);

        try {
            $this->paymentService->processPayment($booking, $request->payment_method);
            return redirect()->route('customer.bookings.show', $booking)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
