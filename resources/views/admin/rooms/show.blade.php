@extends('layouts.admin')

@section('page_title', 'Room ' . $room->room_number . ' — ' . $room->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.rooms.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Rooms</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">{{ $room->name }} (Room #{{ $room->room_number }})</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-outline btn-sm">Edit Room</a>
            <a href="{{ route('rooms.show', $room->slug) }}" target="_blank" class="btn-secondary btn-sm">View on Site ↗</a>
        </div>
    </div>

    {{-- Specs & Images Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-6">
            {{-- Photo Gallery --}}
            <div class="grid grid-cols-3 gap-3">
                @foreach($room->images as $img)
                    <div class="h-32 rounded-lg overflow-hidden bg-charcoal-100">
                        <img src="{{ $img->image_url }}" alt="" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>

            {{-- Description --}}
            <div>
                <h3 class="font-display text-base font-bold text-charcoal-900 mb-2">Description</h3>
                <p class="text-xs text-charcoal-600 leading-relaxed">{{ $room->description }}</p>
            </div>

            {{-- Amenities --}}
            <div>
                <h3 class="font-display text-base font-bold text-charcoal-900 mb-2">Amenities</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($room->amenities as $amenity)
                        <span class="badge bg-warm-100 text-charcoal-800 text-xs">{{ $amenity->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status & Summary --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-display text-base font-bold text-charcoal-900 pb-2 border-b border-charcoal-100">Room Specifications</h3>

                <div class="flex justify-between">
                    <span class="text-charcoal-500">Current Status</span>
                    <span class="badge {{ $room->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $room->status)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Nightly Rate</span>
                    <span class="font-bold text-charcoal-900">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Room Category</span>
                    <span class="font-semibold text-charcoal-900">{{ $room->roomType->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Floor</span>
                    <span class="font-semibold text-charcoal-900">Floor {{ $room->floor }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Max Occupancy</span>
                    <span class="font-semibold text-charcoal-900">{{ $room->max_occupancy }} Adults</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Bed</span>
                    <span class="font-semibold text-charcoal-900">{{ $room->bed_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Size</span>
                    <span class="font-semibold text-charcoal-900">{{ $room->size_sqm }} m²</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal-500">Average Rating</span>
                    <span class="font-semibold text-amber-600">★ {{ number_format($room->average_rating, 1) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Room Bookings History --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-charcoal-100">
            <h3 class="font-display text-lg font-bold text-charcoal-900">Reservation History for Room #{{ $room->room_number }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest</th>
                        <th>Stay Dates</th>
                        <th>Nights</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($room->bookings as $booking)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-charcoal-900">{{ $booking->booking_number }}</td>
                            <td class="text-xs text-charcoal-900">{{ $booking->guest_name }}</td>
                            <td class="text-xs">{{ $booking->check_in->format('d M') }} — {{ $booking->check_out->format('d M Y') }}</td>
                            <td class="text-xs">{{ $booking->nights }}</td>
                            <td class="text-xs font-semibold text-charcoal-900">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-xs text-charcoal-400">No booking history for this room.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
