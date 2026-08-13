@extends('layouts.admin')

@section('page_title', 'Customer Profile — ' . $user->name)

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.customers.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Customers</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">{{ $user->name }}</h2>
    </div>

    {{-- Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4 text-xs">
            <div class="flex items-center gap-4 pb-4 border-b border-charcoal-100">
                <img src="{{ $user->avatar_url }}" alt="" class="w-14 h-14 rounded-full object-cover">
                <div>
                    <h3 class="font-display text-lg font-bold text-charcoal-900">{{ $user->name }}</h3>
                    <span class="text-charcoal-500">{{ $user->email }}</span>
                </div>
            </div>
            <div class="space-y-2 text-charcoal-600">
                <div class="flex justify-between">
                    <span>Phone:</span>
                    <span class="font-semibold text-charcoal-900">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Member Since:</span>
                    <span class="font-semibold text-charcoal-900">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Bookings:</span>
                    <span class="font-bold text-charcoal-900">{{ $user->bookings->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Lifetime Spend:</span>
                    <span class="font-bold text-gold-800 text-sm">Rp {{ number_format($user->total_spending, 0, ',', '.') }}</span>
                </div>
                @if($user->address)
                    <div class="pt-2">
                        <span class="text-charcoal-400 block mb-1">Address:</span>
                        <p class="p-2 bg-warm-50 rounded text-charcoal-800">{{ $user->address }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bookings History for this Customer --}}
        <div class="md:col-span-2 bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-charcoal-100">
                <h3 class="font-display text-base font-bold text-charcoal-900">Stay & Reservation History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Booking Ref</th>
                            <th>Room</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->bookings as $booking)
                            <tr>
                                <td class="font-mono text-xs font-semibold text-charcoal-900">{{ $booking->booking_number }}</td>
                                <td class="text-xs">
                                    <span class="font-semibold text-charcoal-900">{{ $booking->room->name }}</span>
                                    <span class="block text-charcoal-400 text-[10px]">Room {{ $booking->room->room_number }}</span>
                                </td>
                                <td class="text-xs">{{ $booking->check_in->format('d M') }} — {{ $booking->check_out->format('d M Y') }}</td>
                                <td class="text-xs font-bold text-charcoal-900">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-xs text-charcoal-400">No reservations recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
