<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class CheckOutService
{
    protected NotificationService $notificationService;
    protected AuditService $auditService;

    public function __construct(NotificationService $notificationService, AuditService $auditService)
    {
        $this->notificationService = $notificationService;
        $this->auditService = $auditService;
    }

    /**
     * Get check-out summary for a booking.
     */
    public function getCheckOutSummary(Booking $booking): array
    {
        $booking->load(['room.roomType', 'serviceOrders.service', 'payment']);

        $roomCharges = $booking->total;
        $additionalCharges = $booking->serviceOrders()
            ->where('status', 'completed')
            ->sum('total');

        return [
            'booking' => $booking,
            'room_charges' => $roomCharges,
            'additional_charges' => $additionalCharges,
            'service_orders' => $booking->serviceOrders()->with('service')->where('status', 'completed')->get(),
            'final_total' => $roomCharges + $additionalCharges,
        ];
    }

    /**
     * Process check-out.
     */
    public function checkOut(Booking $booking): Booking
    {
        if ($booking->status !== 'checked_in') {
            throw new \Exception('Only checked-in bookings can be checked out.');
        }

        return DB::transaction(function () use ($booking) {
            $oldData = $booking->toArray();

            $booking->update([
                'status' => 'completed',
                'checked_out_at' => now(),
            ]);

            // Set room to cleaning
            $booking->room->update(['status' => 'cleaning']);

            // Notify
            $this->notificationService->notifyCheckOut($booking);

            // Audit
            $this->auditService->log('checked_out', $booking, $oldData, $booking->fresh()->toArray());

            return $booking->fresh();
        });
    }
}
