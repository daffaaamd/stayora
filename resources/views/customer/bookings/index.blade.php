@extends('layouts.app')

@section('title', 'My Bookings — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">My Reservations</h1>
                <p class="text-xs sm:text-sm text-charcoal-500 mt-1">Manage and view your upcoming and past stays at Stayora Resort.</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn-primary btn-sm">
                Book Another Stay
            </a>
        </div>

        {{-- Bookings List --}}
        @if($bookings->isNotEmpty())
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-xl overflow-hidden border border-charcoal-200 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row">
                        <div class="md:w-72 h-48 md:h-auto shrink-0 relative bg-charcoal-100">
                            <img src="{{ $booking->room->primary_image_url }}" alt="{{ $booking->room->name }}" class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="badge bg-white/95 text-charcoal-900 font-semibold shadow-sm">{{ $booking->room->roomType->name }}</span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs font-bold text-gold-700 bg-gold-50 px-2 py-0.5 rounded">
                                            {{ $booking->booking_number }}
                                        </span>
                                        <span class="text-xs text-charcoal-400">Booked {{ $booking->created_at->format('d M Y') }}</span>
                                    </div>
                                    <span class="badge {{ $booking->status_badge_class }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </div>

                                <h3 class="font-display text-xl font-bold text-charcoal-900 mb-1">
                                    {{ $booking->room->name }}
                                </h3>
                                <p class="text-xs text-charcoal-500 mb-4">Room {{ $booking->room->room_number }} · Floor {{ $booking->room->floor }}</p>

                                {{-- Stay Info --}}
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-3 bg-warm-50 rounded-lg text-xs text-charcoal-600 mb-4">
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase">Check-in</span>
                                        <span class="font-semibold text-charcoal-900">{{ $booking->check_in->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase">Check-out</span>
                                        <span class="font-semibold text-charcoal-900">{{ $booking->check_out->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase">Duration</span>
                                        <span class="font-semibold text-charcoal-900">{{ $booking->nights }} Nights</span>
                                    </div>
                                    <div>
                                        <span class="text-charcoal-400 block text-[10px] uppercase">Total</span>
                                        <span class="font-semibold text-charcoal-900">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-charcoal-100">
                                <div>
                                    @if($booking->payment)
                                        <span class="text-xs text-emerald-600 font-medium">✓ Paid via {{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</span>
                                    @else
                                        <span class="text-xs text-amber-600 font-medium">⚠ Payment Pending</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($booking->status === 'pending_payment')
                                        <a href="{{ route('customer.payment.show', $booking) }}" class="btn-primary btn-sm">
                                            Pay Now
                                        </a>
                                    @endif
                                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn-secondary btn-sm">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl p-12 text-center border border-charcoal-200 max-w-md mx-auto">
                <svg class="w-12 h-12 text-charcoal-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <h3 class="font-display text-lg font-bold text-charcoal-900 mb-2">No Bookings Found</h3>
                <p class="text-xs text-charcoal-500 mb-6">You haven't made any room reservations yet. Explore our luxury rooms to plan your escape.</p>
                <a href="{{ route('rooms.index') }}" class="btn-primary btn-sm">Explore Rooms</a>
            </div>
        @endif
    </div>
</div>
@endsection
