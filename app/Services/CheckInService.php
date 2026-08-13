<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class CheckInService
{
    protected NotificationService $notificationService;
    protected AuditService $auditService;

    public function __construct(NotificationService $notificationService, AuditService $auditService)
    {
        $this->notificationService = $notificationService;
        $this->auditService = $auditService;
    }

    /**
     * Process check-in for a booking.
     */
    public function checkIn(Booking $booking): Booking
    {
        // Validate
        if ($booking->status !== 'confirmed') {
            throw new \Exception('Booking must be confirmed before check-in.');
        }

        if (!$booking->payment || $booking->payment->status !== 'paid') {
            throw new \Exception('Payment must be completed before check-in.');
        }

        // Allow check-in from 1 day before to check-in date
        $checkInDate = $booking->check_in;
        if (now()->startOfDay()->diffInDays($checkInDate, false) > 1) {
            throw new \Exception('Check-in is not allowed more than 1 day before the scheduled date.');
        }

        return DB::transaction(function () use ($booking) {
            $oldData = $booking->toArray();

            $booking->update([
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            // Update room status
            $booking->room->update(['status' => 'occupied']);

            // Notify
            $this->notificationService->notifyCheckIn($booking);

            // Audit
            $this->auditService->log('checked_in', $booking, $oldData, $booking->fresh()->toArray());

            return $booking->fresh();
        });
    }
}
