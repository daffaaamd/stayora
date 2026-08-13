@extends('layouts.app')

@section('title', 'Guest Dashboard — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Greeting Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs uppercase tracking-wider text-gold-600 font-semibold">Welcome Back</span>
                <h1 class="font-display text-3xl font-bold text-charcoal-900 mt-0.5">
                    Hello, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs text-charcoal-500 mt-1">Manage your upcoming stays, reservation history, and personalized preferences.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('rooms.index') }}" class="btn-primary btn-sm">
                    Book a Room
                </a>
            </div>
        </div>

        {{-- KPI Quick Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="kpi-card">
                <span class="text-[11px] font-semibold text-charcoal-400 uppercase tracking-wider block">Total Bookings</span>
                <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">{{ $totalBookings }}</p>
                <span class="text-[11px] text-charcoal-500 mt-1 block">Lifetime reservations</span>
            </div>

            <div class="kpi-card">
                <span class="text-[11px] font-semibold text-charcoal-400 uppercase tracking-wider block">Total Spending</span>
                <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                <span class="text-[11px] text-emerald-600 mt-1 block">Valued Member</span>
            </div>

            <div class="kpi-card">
                <span class="text-[11px] font-semibold text-charcoal-400 uppercase tracking-wider block">Upcoming Stays</span>
                <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">{{ $upcomingStays->count() }}</p>
                <span class="text-[11px] text-gold-600 mt-1 block">Confirmed trips</span>
            </div>

            <div class="kpi-card">
                <span class="text-[11px] font-semibold text-charcoal-400 uppercase tracking-wider block">Unread Alerts</span>
                <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">{{ auth()->user()->unreadNotifications()->count() }}</p>
                <a href="{{ route('customer.notifications') }}" class="text-[11px] text-gold-600 hover:underline mt-1 block">View all →</a>
            </div>
        </div>

        {{-- Upcoming Stays Section --}}
        @if($upcomingStays->isNotEmpty())
            <div class="mb-10">
                <h2 class="font-display text-xl font-bold text-charcoal-900 mb-4">Upcoming Stay</h2>
                @foreach($upcomingStays->take(1) as $upcoming)
                    <div class="bg-white rounded-2xl overflow-hidden border border-gold-200 shadow-md flex flex-col lg:flex-row">
                        <div class="lg:w-96 h-64 lg:h-auto relative bg-charcoal-100 shrink-0">
                            <img src="{{ $upcoming->room->primary_image_url }}" alt="{{ $upcoming->room->name }}" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="badge bg-white/95 text-charcoal-900 font-bold shadow">{{ $upcoming->room->roomType->name }}</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="badge {{ $upcoming->status_badge_class }} shadow">{{ ucfirst(str_replace('_', ' ', $upcoming->status)) }}</span>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-mono text-xs font-bold text-gold-800 bg-gold-50 px-2.5 py-1 rounded">
                                        {{ $upcoming->booking_number }}
                                    </span>
                                    <span class="text-xs text-charcoal-500">Room {{ $upcoming->room->room_number }} · Floor {{ $upcoming->room->floor }}</span>
                                </div>

                                <h3 class="font-display text-2xl font-bold text-charcoal-900 mb-4">{{ $upcoming->room->name }}</h3>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 p-4 bg-warm-50 rounded-xl border border-charcoal-100 text-xs mb-6">
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase font-semibold">Check-in</span>
                                        <p class="font-bold text-charcoal-900 mt-0.5">{{ $upcoming->check_in->format('D, d M Y') }}</p>
                                        <span class="text-[11px] text-charcoal-500">14:00 WITA</span>
                                    </div>
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase font-semibold">Check-out</span>
                                        <p class="font-bold text-charcoal-900 mt-0.5">{{ $upcoming->check_out->format('D, d M Y') }}</p>
                                        <span class="text-[11px] text-charcoal-500">12:00 WITA</span>
                                    </div>
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase font-semibold">Guests & Duration</span>
                                        <p class="font-bold text-charcoal-900 mt-0.5">{{ $upcoming->guests }} Guests</p>
                                        <span class="text-[11px] text-charcoal-500">{{ $upcoming->nights }} Nights Stay</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-charcoal-100">
                                <div class="flex items-center gap-2 text-xs text-emerald-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Reservation confirmed & ready for arrival</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('customer.bookings.pdf', $upcoming) }}" class="btn-outline btn-sm bg-white">
                                        Download Voucher
                                    </a>
                                    <a href="{{ route('customer.bookings.show', $upcoming) }}" class="btn-primary btn-sm">
                                        View Stay Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Recent Bookings Table --}}
        <div class="bg-white rounded-xl border border-charcoal-200 shadow-sm overflow-hidden mb-10">
            <div class="px-6 py-4 border-b border-charcoal-100 flex items-center justify-between">
                <h3 class="font-display text-lg font-bold text-charcoal-900">Recent Booking History</h3>
                <a href="{{ route('customer.bookings') }}" class="text-xs text-gold-700 hover:text-gold-800 font-semibold">View All Bookings →</a>
            </div>

            @if($recentBookings->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Booking Number</th>
                                <th>Room</th>
                                <th>Stay Dates</th>
                                <th>Nights</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                                <tr>
                                    <td class="font-mono font-semibold text-charcoal-900">{{ $booking->booking_number }}</td>
                                    <td>
                                        <div class="font-medium text-charcoal-900">{{ $booking->room->name }}</div>
                                        <span class="text-[11px] text-charcoal-500">{{ $booking->room->roomType->name }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $booking->check_in->format('d M') }} — {{ $booking->check_out->format('d M Y') }}</span>
                                    </td>
                                    <td>{{ $booking->nights }}</td>
                                    <td class="font-semibold text-charcoal-900">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.bookings.show', $booking) }}" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Details →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="p-8 text-center text-xs text-charcoal-400">No booking history yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
