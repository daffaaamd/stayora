@extends('layouts.admin')

@section('page_title', 'Front Desk — Guest Check-Out')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Currently In-House Guests (Check-Out)</h2>
            <p class="text-xs text-charcoal-500">Active guests scheduled for check-out and final billing folio settlement.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest</th>
                        <th>Occupied Room</th>
                        <th>Check-in Date</th>
                        <th>Scheduled Departure</th>
                        <th>Extra Services</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="font-mono text-xs font-bold text-gold-800">{{ $booking->booking_number }}</td>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $booking->guest_name }}</div>
                                <span class="text-[11px] text-charcoal-500">{{ $booking->guest_phone ?? $booking->guest_email }}</span>
                            </td>
                            <td class="text-xs">
                                <span class="font-bold text-charcoal-900">Room {{ $booking->room->room_number }}</span>
                                <span class="block text-[11px] text-charcoal-400">{{ $booking->room->roomType->name }}</span>
                            </td>
                            <td class="text-xs">{{ $booking->check_in->format('d M Y') }}</td>
                            <td class="text-xs font-semibold {{ $booking->check_out->isToday() ? 'text-amber-600' : 'text-charcoal-900' }}">
                                {{ $booking->check_out->format('d M Y') }}
                                @if($booking->check_out->isToday()) <span class="badge badge-warning text-[9px] ml-1">Today</span> @endif
                            </td>
                            <td class="text-xs">
                                @if($booking->serviceOrders->isNotEmpty())
                                    <span class="font-bold text-gold-800">{{ $booking->serviceOrders->count() }} Orders</span>
                                    <span class="block text-[10px] text-charcoal-400">+Rp {{ number_format($booking->serviceOrders->sum('total'), 0, ',', '.') }}</span>
                                @else
                                    <span class="text-charcoal-400 text-[11px]">No extras</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.checkout.show', $booking) }}" class="btn-primary btn-sm py-1.5 px-3">
                                    Review Folio & Check Out →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-charcoal-400">No in-house guests currently active.</td>
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
