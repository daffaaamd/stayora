@extends('layouts.app')

@section('title', 'Reservation ' . $booking->booking_number . ' — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Top Action Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('customer.bookings') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-2 inline-flex items-center gap-1">
                    ← Back to My Bookings
                </a>
                <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">
                    Reservation Details
                </h1>
                <p class="text-xs text-charcoal-500 font-mono mt-0.5">Booking Reference: {{ $booking->booking_number }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($booking->isPaid() || $booking->status === 'confirmed' || $booking->status === 'checked_in')
                    <a href="{{ route('customer.bookings.pdf', $booking) }}" class="btn-outline btn-sm inline-flex items-center gap-1.5 bg-white">
                        <svg class="w-4 h-4 text-charcoal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download Voucher (PDF)</span>
                    </a>
                @endif

                @if($booking->status === 'pending_payment')
                    <a href="{{ route('customer.payment.show', $booking) }}" class="btn-primary btn-sm">
                        Complete Payment Now
                    </a>
                @endif

                @if($booking->canReview())
                    <a href="{{ route('customer.reviews.create', $booking) }}" class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span>Write a Review</span>
                    </a>
                @endif

                @if($booking->canBeCancelled())
                    <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        @csrf
                        <button type="submit" class="btn-danger btn-sm">Cancel Booking</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Booking Lifecycle Stepper --}}
        <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm mb-8">
            <h3 class="text-xs font-bold uppercase tracking-wider text-charcoal-500 mb-6">Reservation Status Flow</h3>
            @php
                $steps = [
                    'pending_payment' => 'Pending Payment',
                    'confirmed' => 'Confirmed',
                    'checked_in' => 'Checked In',
                    'checked_out' => 'Checked Out',
                    'completed' => 'Completed',
                ];
                $statuses = array_keys($steps);
                $currentIndex = array_search($booking->status, $statuses);
                if ($currentIndex === false && $booking->status === 'cancelled') {
                    $currentIndex = -1;
                }
            @endphp

            @if($booking->status === 'cancelled')
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-xs flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>This booking was cancelled. Cancellation Reason: {{ $booking->cancellation_reason ?? 'Guest Request' }}</span>
                </div>
            @else
                <div class="grid grid-cols-5 gap-2 text-center">
                    @foreach($steps as $key => $label)
                        @php $stepIndex = array_search($key, $statuses); @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-2
                                {{ $stepIndex <= $currentIndex ? 'bg-gold-500 text-white shadow-sm' : 'bg-charcoal-100 text-charcoal-400' }}">
                                @if($stepIndex < $currentIndex)
                                    ✓
                                @else
                                    {{ $stepIndex + 1 }}
                                @endif
                            </div>
                            <span class="text-[11px] font-medium {{ $stepIndex <= $currentIndex ? 'text-charcoal-900 font-bold' : 'text-charcoal-400' }}">
                                {{ $label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Main Details Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Left 2 cols: Room & Stay Info --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Room Details Card --}}
                <div class="bg-white rounded-xl overflow-hidden border border-charcoal-200 shadow-sm">
                    <div class="relative h-60">
                        <img src="{{ $booking->room->primary_image_url }}" alt="{{ $booking->room->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="badge bg-white/95 text-charcoal-900 font-semibold">{{ $booking->room->roomType->name }}</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-charcoal-500 font-semibold">Room {{ $booking->room->room_number }} · Floor {{ $booking->room->floor }}</span>
                            <span class="text-xs text-charcoal-500">{{ $booking->room->view_type }}</span>
                        </div>
                        <h2 class="font-display text-2xl font-bold text-charcoal-900 mb-4">{{ $booking->room->name }}</h2>

                        {{-- Stay Dates Grid --}}
                        <div class="grid grid-cols-2 gap-4 p-4 bg-warm-50 rounded-xl border border-charcoal-100 mb-6">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-charcoal-400 block">Check-in Date</span>
                                <p class="font-display text-base font-bold text-charcoal-900 mt-0.5">{{ $booking->check_in->format('D, d M Y') }}</p>
                                <span class="text-xs text-charcoal-500">From 14:00 WITA</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-charcoal-400 block">Check-out Date</span>
                                <p class="font-display text-base font-bold text-charcoal-900 mt-0.5">{{ $booking->check_out->format('D, d M Y') }}</p>
                                <span class="text-xs text-charcoal-500">Until 12:00 WITA</span>
                            </div>
                        </div>

                        {{-- Guest Info --}}
                        <div class="space-y-2 text-xs text-charcoal-600">
                            <div class="flex justify-between py-1 border-b border-charcoal-100">
                                <span class="text-charcoal-500">Primary Guest</span>
                                <span class="font-semibold text-charcoal-900">{{ $booking->guest_name }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-charcoal-100">
                                <span class="text-charcoal-500">Email</span>
                                <span class="font-semibold text-charcoal-900">{{ $booking->guest_email }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-charcoal-100">
                                <span class="text-charcoal-500">Phone</span>
                                <span class="font-semibold text-charcoal-900">{{ $booking->guest_phone ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-charcoal-100">
                                <span class="text-charcoal-500">Occupancy</span>
                                <span class="font-semibold text-charcoal-900">{{ $booking->guests }} Guests ({{ $booking->nights }} Nights)</span>
                            </div>
                            @if($booking->special_request)
                                <div class="pt-2">
                                    <span class="text-charcoal-500 block mb-1">Special Requests:</span>
                                    <p class="p-3 bg-warm-100 rounded-lg text-charcoal-800">{{ $booking->special_request }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Additional Service Orders if any --}}
                @if($booking->serviceOrders->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm">
                        <h3 class="font-display text-lg font-bold text-charcoal-900 mb-4">Ordered Services</h3>
                        <div class="space-y-3">
                            @foreach($booking->serviceOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-warm-50 rounded-lg text-xs">
                                    <div>
                                        <p class="font-semibold text-charcoal-900">{{ $order->service->name }} (×{{ $order->quantity }})</p>
                                        <span class="text-charcoal-500 text-[11px]">{{ $order->notes ?? 'Standard Service' }}</span>
                                    </div>
                                    <span class="font-bold text-charcoal-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Customer Review if exists --}}
                @if($booking->review)
                    <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display text-lg font-bold text-charcoal-900">Your Review</h3>
                            <div class="flex items-center gap-1 text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $booking->review->rating ? 'fill-current' : 'fill-charcoal-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs sm:text-sm text-charcoal-700 italic">"{{ $booking->review->comment }}"</p>
                    </div>
                @endif
            </div>

            {{-- Right col: Payment & Billing Recap --}}
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm space-y-4 text-xs">
                    <h3 class="font-display text-base font-bold text-charcoal-900 pb-2 border-b border-charcoal-100">Payment Details</h3>

                    <div class="flex items-center justify-between">
                        <span class="text-charcoal-500">Payment Status</span>
                        @if($booking->payment)
                            <span class="badge {{ $booking->payment->status_badge_class }}">{{ ucfirst($booking->payment->status) }}</span>
                        @else
                            <span class="badge badge-warning">Unpaid</span>
                        @endif
                    </div>

                    @if($booking->payment)
                        <div class="space-y-1.5 text-charcoal-600">
                            <div class="flex justify-between">
                                <span class="text-charcoal-500">Method</span>
                                <span class="font-semibold text-charcoal-900">{{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-charcoal-500">Transaction ID</span>
                                <span class="font-mono text-charcoal-900">{{ $booking->payment->transaction_id }}</span>
                            </div>
                            @if($booking->payment->paid_at)
                                <div class="flex justify-between">
                                    <span class="text-charcoal-500">Paid At</span>
                                    <span>{{ $booking->payment->paid_at->format('d M Y, H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="pt-3 border-t border-charcoal-100 space-y-2">
                        <div class="flex justify-between text-charcoal-600">
                            <span>Room ({{ $booking->nights }} nights)</span>
                            <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>

                        @if($booking->discount > 0)
                            <div class="flex justify-between text-emerald-600 font-medium">
                                <span>Promo ({{ $booking->promo_code }})</span>
                                <span>- Rp {{ number_format($booking->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-charcoal-600">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-charcoal-600">
                            <span>Service Charge (5%)</span>
                            <span>Rp {{ number_format($booking->service_charge, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-3 border-t border-charcoal-200 flex justify-between font-bold text-sm text-charcoal-900">
                            <span>Total Amount</span>
                            <span class="text-gold-800 text-base">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Resort Support Contact Card --}}
                <div class="bg-white rounded-xl p-5 border border-charcoal-200 shadow-sm text-xs space-y-2">
                    <h4 class="font-semibold text-charcoal-900">Need Assistance?</h4>
                    <p class="text-charcoal-500">Our 24/7 Front Desk is always available to assist with airport pickup, room adjustments, or special requests.</p>
                    <p class="font-semibold text-gold-700 pt-1">📞 +62 361 770 888</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
