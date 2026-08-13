@extends('layouts.admin')

@section('page_title', 'Room Performance Report')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Room Utilization & Yield Report</h2>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Name</th>
                        <th>Type</th>
                        <th>Nightly Rate</th>
                        <th>Total Bookings</th>
                        <th>Gross Yield Generated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td class="font-mono font-bold text-xs">Room {{ $room->room_number }}</td>
                            <td class="text-xs font-semibold text-charcoal-900">{{ $room->name }}</td>
                            <td><span class="badge bg-warm-100 text-charcoal-800 text-[10px]">{{ $room->roomType->name }}</span></td>
                            <td class="text-xs">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</td>
                            <td class="text-xs font-bold">{{ $room->bookings_count }} Stays</td>
                            <td class="text-xs font-bold text-gold-800">
                                Rp {{ number_format($room->bookings_sum_total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
