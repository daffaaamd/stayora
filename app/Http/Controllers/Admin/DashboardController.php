<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\AvailabilityService;
use App\Services\BookingService;
use App\Services\PaymentService;

class DashboardController extends Controller
{
    public function index(
        AvailabilityService $availabilityService,
        BookingService $bookingService,
        PaymentService $paymentService
    ) {
        $occupancy = $availabilityService->getOccupancyData();
        $bookingStats = $bookingService->getStatistics();
        $revenue = $paymentService->getRevenueStatistics();

        $year = now()->year;
        $monthlyRevenue = $paymentService->getMonthlyRevenue($year);
        $monthlyBookings = $bookingService->getMonthlyBookingTrends($year);
        $revenueByRoomType = $paymentService->getRevenueByRoomType($year);

        // Room performance — top 5 most booked rooms
        $topRooms = Room::withCount(['bookings' => fn($q) => $q->whereNotIn('status', ['cancelled'])])
            ->with('roomType')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        // Recent bookings
        $recentBookings = Booking::with(['user', 'room.roomType', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'occupancy', 'bookingStats', 'revenue',
            'monthlyRevenue', 'monthlyBookings', 'revenueByRoomType',
            'topRooms', 'recentBookings'
        ));
    }
}
