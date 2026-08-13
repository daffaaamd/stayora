<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    protected NotificationService $notificationService;
    protected AuditService $auditService;

    public function __construct(NotificationService $notificationService, AuditService $auditService)
    {
        $this->notificationService = $notificationService;
        $this->auditService = $auditService;
    }

    /**
     * Process a mock payment.
     */
    public function processPayment(Booking $booking, string $method): Payment
    {
        return DB::transaction(function () use ($booking, $method) {
            // Create payment record
            $payment = Payment::create([
                'payment_number' => Payment::generatePaymentNumber(),
                'booking_id' => $booking->id,
                'method' => $method,
                'amount' => $booking->total,
                'status' => 'paid', // Mock: always successful
                'paid_at' => now(),
                'transaction_ref' => 'TXN-' . strtoupper(Str::random(12)),
            ]);

            // Update booking status
            $booking->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            // Send notifications
            $this->notificationService->notifyPaymentSuccess($booking);
            $this->notificationService->notifyBookingConfirmed($booking);

            // Audit
            $this->auditService->log('payment_processed', $payment, null, $payment->toArray());

            return $payment;
        });
    }

    /**
     * Get revenue statistics.
     */
    public function getRevenueStatistics(): array
    {
        $today = now();

        return [
            'daily' => Payment::where('status', 'paid')
                ->whereDate('paid_at', $today)->sum('amount'),
            'weekly' => Payment::where('status', 'paid')
                ->whereBetween('paid_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])
                ->sum('amount'),
            'monthly' => Payment::where('status', 'paid')
                ->whereMonth('paid_at', $today->month)
                ->whereYear('paid_at', $today->year)
                ->sum('amount'),
            'yearly' => Payment::where('status', 'paid')
                ->whereYear('paid_at', $today->year)
                ->sum('amount'),
        ];
    }

    /**
     * Get monthly revenue data for charts.
     */
    public function getMonthlyRevenue(int $year): array
    {
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $amount = Payment::where('status', 'paid')
                ->whereYear('paid_at', $year)
                ->whereMonth('paid_at', $month)
                ->sum('amount');
            $data[] = [
                'month' => \Carbon\Carbon::create($year, $month, 1)->format('M'),
                'amount' => (float) $amount,
            ];
        }
        return $data;
    }

    /**
     * Get revenue by room type.
     */
    public function getRevenueByRoomType(int $year): array
    {
        return DB::table('payments')
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->where('payments.status', 'paid')
            ->whereYear('payments.paid_at', $year)
            ->select('room_types.name', DB::raw('SUM(payments.amount) as total'))
            ->groupBy('room_types.name')
            ->get()
            ->toArray();
    }
}
