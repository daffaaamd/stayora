<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->withCount('bookings')
            ->withSum(['bookings' => fn($q) => $q->whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'completed'])], 'total');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load(['bookings' => fn($q) => $q->with(['room.roomType', 'payment'])->latest(), 'reviews']);
        return view('admin.customers.show', compact('user'));
    }
}
