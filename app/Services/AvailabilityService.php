<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Check if a specific room is available for the given date range.
     */
    public function isRoomAvailable(int $roomId, string $checkIn, string $checkOut): bool
    {
        $room = Room::find($roomId);
        if (!$room) return false;

        return $room->isAvailableForDates($checkIn, $checkOut);
    }

    /**
     * Get available rooms for the given criteria.
     */
    public function getAvailableRooms(string $checkIn, string $checkOut, ?int $guests = null, ?int $roomTypeId = null)
    {
        $query = Room::query()
            ->with(['roomType', 'images', 'amenities'])
            ->where('is_active', true)
            ->whereNotIn('status', ['maintenance', 'out_of_service']);

        // Exclude rooms that have overlapping bookings
        $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->whereNotIn('status', ['cancelled', 'completed'])
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });

        if ($guests) {
            $query->where('max_occupancy', '>=', $guests);
        }

        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }

        return $query;
    }

    /**
     * Get all rooms with their availability status for the given dates.
     */
    public function getRoomsWithAvailability(string $checkIn, string $checkOut)
    {
        $rooms = Room::with(['roomType', 'images', 'amenities'])
            ->where('is_active', true)
            ->get();

        return $rooms->map(function ($room) use ($checkIn, $checkOut) {
            $room->is_available = $room->isAvailableForDates($checkIn, $checkOut);
            return $room;
        });
    }

    /**
     * Get occupancy data for dashboard.
     */
    public function getOccupancyData(?string $date = null): array
    {
        $date = $date ? Carbon::parse($date) : now();

        $totalRooms = Room::count();
        $totalActive = Room::where('is_active', true)->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $cleaningRooms = Room::where('status', 'cleaning')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $occupancyRate = $totalActive > 0 ? round(($occupiedRooms / $totalActive) * 100, 1) : 0;

        return [
            'total_rooms' => $totalRooms,
            'total_active' => $totalActive,
            'occupied_rooms' => $occupiedRooms,
            'occupied' => $occupiedRooms,
            'available_rooms' => $availableRooms,
            'available' => $availableRooms,
            'cleaning' => $cleaningRooms,
            'maintenance' => $maintenanceRooms,
            'occupancy_rate' => $occupancyRate,
            'rate' => $occupancyRate,
        ];
    }

    /**
     * Get monthly occupancy rates.
     */
    public function getMonthlyOccupancy(int $year): array
    {
        $totalRooms = Room::where('is_active', true)->count();
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $daysInMonth = $startOfMonth->daysInMonth;

            $totalRoomDays = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($year, $month, $day);
                $occupied = Booking::whereIn('status', ['checked_in', 'checked_out', 'completed'])
                    ->where('check_in', '<=', $date)
                    ->where('check_out', '>', $date)
                    ->count();
                $totalRoomDays += $occupied;
            }

            $maxRoomDays = $totalRooms * $daysInMonth;
            $rate = $maxRoomDays > 0 ? round(($totalRoomDays / $maxRoomDays) * 100, 1) : 0;

            $data[] = [
                'month' => $startOfMonth->format('M'),
                'rate' => $rate,
            ];
        }

        return $data;
    }
}
