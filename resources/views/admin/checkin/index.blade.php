@extends('layouts.admin')

@section('page_title', 'Front Desk — Guest Check-In')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Arrivals Ready for Check-in</h2>
            <p class="text-xs text-charcoal-500">Confirmed reservations with completed payment ready for guest registration and room assignment.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest Name</th>
                        <th>Assigned Room</th>
                        <th>Expected Stay</th>
                        <th>Nights</th>
                        <th>Payment Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="font-mono text-xs font-bold text-gold-800">
                                {{ $booking->booking_number }}
                            </td>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $booking->guest_name }}</div>
                                <span class="text-[11px] text-charcoal-500">{{ $booking->guest_phone ?? $booking->guest_email }}</span>
                            </td>
                            <td class="text-xs">
                                <span class="font-bold text-charcoal-900">Room {{ $booking->room->room_number }}</span>
                                <span class="block text-[11px] text-charcoal-400">{{ $booking->room->roomType->name }} (Floor {{ $booking->room->floor }})</span>
                            </td>
                            <td class="text-xs text-charcoal-700">
                                <div>{{ $booking->check_in->format('d M Y') }}</div>
                                <span class="text-[11px] text-charcoal-400">until {{ $booking->check_out->format('d M Y') }}</span>
                            </td>
                            <td class="text-xs text-center">{{ $booking->nights }}</td>
                            <td>
                                <span class="badge badge-success text-[10px]">
                                    Paid (Rp {{ number_format($booking->total, 0, ',', '.') }})
                                </span>
                            </td>
                            <td class="text-right">
                                <form action="{{ route('admin.checkin.process', $booking) }}" method="POST" onsubmit="return confirm('Complete check-in for {{ $booking->guest_name }}?');">
                                    @csrf
                                    <button type="submit" class="btn-primary btn-sm py-1.5 px-3">
                                        ✓ Check In Guest
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-charcoal-400">No arrivals waiting for check-in.</td>
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
