@extends('layouts.admin')

@section('page_title', 'Reservations & Bookings')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Guest Bookings Ledger</h2>
            <p class="text-xs text-charcoal-500">Monitor all incoming, active, and completed guest reservations.</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Booking #, Guest name..."
                       class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Status</label>
                <select name="status" class="form-select text-xs">
                    <option value="">All Statuses</option>
                    <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">From Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">To Date</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input text-xs">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-secondary btn-sm flex-1 justify-center">Apply Filter</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn-outline btn-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Bookings Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest</th>
                        <th>Room Details</th>
                        <th>Check-in & Out</th>
                        <th>Nights</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="font-mono text-xs font-bold text-gold-800 hover:underline">
                                    {{ $booking->booking_number }}
                                </a>
                                <span class="block text-[10px] text-charcoal-400">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $booking->guest_name }}</div>
                                <span class="text-[11px] text-charcoal-500">{{ $booking->guest_phone ?? $booking->guest_email }}</span>
                            </td>
                            <td class="text-xs">
                                <span class="font-semibold text-charcoal-900">{{ $booking->room->name }}</span>
                                <span class="block text-charcoal-400 text-[11px]">{{ $booking->room->roomType->name }} · Rm {{ $booking->room->room_number }}</span>
                            </td>
                            <td class="text-xs text-charcoal-600">
                                <div>{{ $booking->check_in->format('d M Y') }}</div>
                                <span class="text-[11px] text-charcoal-400">to {{ $booking->check_out->format('d M Y') }}</span>
                            </td>
                            <td class="text-xs text-center font-medium">{{ $booking->nights }}</td>
                            <td class="text-xs font-bold text-charcoal-900">
                                Rp {{ number_format($booking->total, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($booking->payment)
                                    <span class="badge {{ $booking->payment->status_badge_class }} text-[10px]">
                                        {{ ucfirst($booking->payment->status) }}
                                    </span>
                                @else
                                    <span class="badge badge-warning text-[10px]">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $booking->status_badge_class }} text-[10px]">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-outline btn-sm py-1 px-2.5 text-xs">
                                    Manage →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-xs text-charcoal-400">No reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
