<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $upcomingStays = $user->bookings()
            ->with(['room.roomType', 'room.images', 'payment'])
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->where('check_in', '>=', now()->subDay())
            ->orderBy('check_in')
            ->get();

        $recentBookings = $user->bookings()
            ->with(['room.roomType', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $totalBookings = $user->bookings()->count();
        $totalSpending = $user->total_spending;

        return view('customer.dashboard', compact('upcomingStays', 'recentBookings', 'totalBookings', 'totalSpending'));
    }

    public function profile()
    {
        return view('customer.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }
}
