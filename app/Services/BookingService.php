<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    protected AvailabilityService $availabilityService;
    protected NotificationService $notificationService;
    protected AuditService $auditService;

    public function __construct(
        AvailabilityService $availabilityService,
        NotificationService $notificationService,
        AuditService $auditService
    ) {
        $this->availabilityService = $availabilityService;
        $this->notificationService = $notificationService;
        $this->auditService = $auditService;
    }

    /**
     * Calculate booking pricing.
     */
    public function calculatePricing(Room $room, string $checkIn, string $checkOut, ?string $promoCode = null): array
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $nights = $checkInDate->diffInDays($checkOutDate);

        if ($nights <= 0) $nights = 1;

        $roomPrice = $room->price_per_night;
        $subtotal = $roomPrice * $nights;
        $tax = round($subtotal * 0.11, 2); // 11% tax
        $serviceCharge = round($subtotal * 0.05, 2); // 5% service charge
        $discount = 0;
        $promoApplied = null;

        if ($promoCode) {
            $promo = Promo::where('code', strtoupper($promoCode))->first();
            if ($promo && $promo->isValid($subtotal)) {
                $discount = $promo->calculateDiscount($subtotal);
                $promoApplied = $promo;
            }
        }

        $total = $subtotal + $tax + $serviceCharge - $discount;

        return [
            'room_price' => $roomPrice,
            'nights' => $nights,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'service_charge' => $serviceCharge,
            'discount' => $discount,
            'promo_code' => $promoApplied?->code,
            'total' => max(0, $total),
        ];
    }

    /**
     * Create a new booking.
     */
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $room = Room::findOrFail($data['room_id']);

            // Verify availability
            if (!$room->isAvailableForDates($data['check_in'], $data['check_out'])) {
                throw new \Exception('Room is no longer available for the selected dates.');
            }

            // Calculate pricing
            $pricing = $this->calculatePricing($room, $data['check_in'], $data['check_out'], $data['promo_code'] ?? null);

            // Create booking
            $booking = Booking::create([
                'booking_number' => Booking::generateBookingNumber(),
                'user_id' => $data['user_id'],
                'room_id' => $room->id,
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'] ?? null,
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'] ?? 1,
                'nights' => $pricing['nights'],
                'special_request' => $data['special_request'] ?? null,
                'room_price' => $pricing['room_price'],
                'subtotal' => $pricing['subtotal'],
                'tax' => $pricing['tax'],
                'service_charge' => $pricing['service_charge'],
                'discount' => $pricing['discount'],
                'promo_code' => $pricing['promo_code'],
                'total' => $pricing['total'],
                'status' => 'pending_payment',
            ]);

            // Update room status
            $room->update(['status' => 'reserved']);

            // Increment promo usage
            if ($pricing['promo_code']) {
                Promo::where('code', $pricing['promo_code'])->increment('used_count');
            }

            // Send notification
            $this->notificationService->notifyBookingCreated($booking);

            // Audit log
            $this->auditService->log('created', $booking, null, $booking->toArray());

            return $booking;
        });
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking, string $reason = ''): Booking
    {
        return DB::transaction(function () use ($booking, $reason) {
            $oldData = $booking->toArray();

            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ]);

            // Free up the room if not occupied by another booking
            $room = $booking->room;
            $hasOtherActiveBookings = $room->bookings()
                ->where('id', '!=', $booking->id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->where('check_in', '<=', now())
                ->where('check_out', '>', now())
                ->exists();

            if (!$hasOtherActiveBookings && $room->status === 'reserved') {
                $room->update(['status' => 'available']);
            }

            // Refund payment if paid
            if ($booking->payment && $booking->payment->status === 'paid') {
                $booking->payment->update([
                    'status' => 'refunded',
                ]);
            }

            $this->notificationService->notifyBookingCancelled($booking);
            $this->auditService->log('cancelled', $booking, $oldData, $booking->fresh()->toArray());

            return $booking->fresh();
        });
    }

    /**
     * Get booking statistics for dashboard.
     */
    public function getStatistics(): array
    {
        $today = now()->startOfDay();

        return [
            'today_checkins' => Booking::where('status', 'confirmed')
                ->whereDate('check_in', $today)->count(),
            'today_checkouts' => Booking::where('status', 'checked_in')
                ->whereDate('check_out', $today)->count(),
            'upcoming_bookings' => Booking::whereIn('status', ['confirmed', 'pending_payment'])
                ->where('check_in', '>', $today)->count(),
            'total_bookings_month' => Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereNotIn('status', ['cancelled'])->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'checked_in' => Booking::where('status', 'checked_in')->count(),
            'pending_payment' => Booking::where('status', 'pending_payment')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get monthly booking trends.
     */
    public function getMonthlyBookingTrends(int $year): array
    {
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Booking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotIn('status', ['cancelled'])
                ->count();
            $data[] = [
                'month' => Carbon::create($year, $month, 1)->format('M'),
                'count' => $count,
            ];
        }
        return $data;
    }
}
