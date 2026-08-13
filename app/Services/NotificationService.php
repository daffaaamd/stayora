<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user.
     */
    public function notify(int $userId, string $type, string $title, string $message, ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Notify all staff with given roles.
     */
    public function notifyStaff(array $roles, string $type, string $title, string $message, ?array $data = null): void
    {
        $staffUsers = User::whereIn('role', $roles)->where('status', 'active')->get();
        foreach ($staffUsers as $user) {
            $this->notify($user->id, $type, $title, $message, $data);
        }
    }

    public function notifyBookingCreated(Booking $booking): void
    {
        // Notify customer
        $this->notify(
            $booking->user_id,
            'booking_created',
            'Booking Created',
            "Your booking {$booking->booking_number} has been created. Please complete your payment.",
            ['booking_id' => $booking->id]
        );

        // Notify staff
        $this->notifyStaff(
            ['admin', 'front_desk'],
            'new_booking',
            'New Booking',
            "New booking {$booking->booking_number} by {$booking->guest_name}.",
            ['booking_id' => $booking->id]
        );
    }

    public function notifyPaymentSuccess(Booking $booking): void
    {
        $this->notify(
            $booking->user_id,
            'payment_success',
            'Payment Successful',
            "Payment for booking {$booking->booking_number} has been received.",
            ['booking_id' => $booking->id]
        );

        $this->notifyStaff(
            ['admin', 'front_desk', 'finance'],
            'payment_received',
            'Payment Received',
            "Payment received for booking {$booking->booking_number}.",
            ['booking_id' => $booking->id]
        );
    }

    public function notifyBookingConfirmed(Booking $booking): void
    {
        $this->notify(
            $booking->user_id,
            'booking_confirmed',
            'Booking Confirmed',
            "Your booking {$booking->booking_number} has been confirmed. See you on {$booking->check_in->format('M d, Y')}!",
            ['booking_id' => $booking->id]
        );
    }

    public function notifyCheckIn(Booking $booking): void
    {
        $this->notify(
            $booking->user_id,
            'checked_in',
            'Check-in Completed',
            "Welcome! You have been checked in to Room {$booking->room->room_number}. Enjoy your stay!",
            ['booking_id' => $booking->id]
        );
    }

    public function notifyCheckOut(Booking $booking): void
    {
        $this->notify(
            $booking->user_id,
            'checked_out',
            'Check-out Completed',
            "Thank you for staying with us! Your check-out for booking {$booking->booking_number} is complete.",
            ['booking_id' => $booking->id]
        );
    }

    public function notifyBookingCancelled(Booking $booking): void
    {
        $this->notify(
            $booking->user_id,
            'booking_cancelled',
            'Booking Cancelled',
            "Your booking {$booking->booking_number} has been cancelled.",
            ['booking_id' => $booking->id]
        );
    }
}
