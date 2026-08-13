@extends('layouts.admin')

@section('page_title', 'Reservation ' . $booking->booking_number)

@section('content')
<div class="space-y-6" x-data="{ serviceModal: false }">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Bookings</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">
                Reservation #{{ $booking->booking_number }}
            </h2>
            <span class="text-xs text-charcoal-500">Booked by {{ $booking->guest_name }} on {{ $booking->created_at->format('d M Y, H:i') }}</span>
        </div>

        <div class="flex items-center gap-2">
            @if($booking->status === 'checked_in')
                <button type="button" @click="serviceModal = true" class="btn-primary btn-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Room Service / Order</span>
                </button>
            @endif

            @if($booking->status === 'confirmed')
                <form action="{{ route('admin.checkin.process', $booking) }}" method="POST" onsubmit="return confirm('Check in this guest now?');">
                    @csrf
                    <button type="submit" class="btn-primary btn-sm">Process Check-in</button>
                </form>
            @endif

            @if($booking->status === 'checked_in')
                <a href="{{ route('admin.checkout.show', $booking) }}" class="btn-secondary btn-sm">
                    Process Check-out →
                </a>
            @endif
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- 2 Cols Left: Stay & Guest & Services --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Room & Stay --}}
            <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-charcoal-100">
                    <h3 class="font-display text-base font-bold text-charcoal-900">Stay Information</h3>
                    <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 bg-warm-50 rounded-xl text-xs">
                    <div>
                        <span class="text-charcoal-400 block uppercase text-[10px]">Room Number</span>
                        <span class="font-bold text-charcoal-900 text-sm">Room {{ $booking->room->room_number }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block uppercase text-[10px]">Room Type</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->room->roomType->name }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block uppercase text-[10px]">Check-in</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->check_in->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block uppercase text-[10px]">Check-out</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->check_out->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs text-charcoal-600">
                    <div>
                        <span class="text-charcoal-400 block">Primary Guest Name:</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->guest_name }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block">Email:</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->guest_email }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block">Phone:</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->guest_phone ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-charcoal-400 block">Guests & Nights:</span>
                        <span class="font-semibold text-charcoal-900">{{ $booking->guests }} Guests · {{ $booking->nights }} Nights</span>
                    </div>
                </div>

                @if($booking->special_request)
                    <div class="pt-2">
                        <span class="text-xs text-charcoal-400 block mb-1">Special Guest Instructions:</span>
                        <p class="p-3 bg-warm-100 rounded-lg text-xs text-charcoal-800">{{ $booking->special_request }}</p>
                    </div>
                @endif
            </div>

            {{-- Additional Service Orders / Folio Items --}}
            <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-base font-bold text-charcoal-900">Hotel Services & Orders Folio</h3>
                    @if($booking->status === 'checked_in')
                        <button type="button" @click="serviceModal = true" class="text-xs text-gold-700 hover:underline font-semibold">+ Add Service</button>
                    @endif
                </div>

                @if($booking->serviceOrders->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->serviceOrders as $order)
                                    <tr>
                                        <td>
                                            <div class="font-semibold text-charcoal-900 text-xs">{{ $order->service->name }}</div>
                                            <span class="text-[10px] text-charcoal-400">{{ $order->notes ?? 'Standard' }}</span>
                                        </td>
                                        <td class="text-xs">{{ $order->quantity }}</td>
                                        <td class="text-xs">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                        <td class="text-xs font-bold text-charcoal-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td><span class="badge badge-success text-[10px]">{{ ucfirst($order->status) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="p-4 text-center text-xs text-charcoal-400 bg-warm-50 rounded-lg">No additional services charged yet.</p>
                @endif
            </div>

            {{-- Manual Status Override for Admin --}}
            <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm">
                <h3 class="font-display text-base font-bold text-charcoal-900 mb-3">Admin Status Control</h3>
                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select text-xs">
                        <option value="pending_payment" {{ $booking->status === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ $booking->status === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ $booking->status === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn-secondary btn-sm">Update Status</button>
                </form>
            </div>
        </div>

        {{-- 1 Col Right: Billing & Payment Summary --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-display text-base font-bold text-charcoal-900 pb-2 border-b border-charcoal-100">Payment Breakdown</h3>

                <div class="flex justify-between">
                    <span class="text-charcoal-500">Payment Status</span>
                    @if($booking->payment)
                        <span class="badge {{ $booking->payment->status_badge_class }}">{{ ucfirst($booking->payment->status) }}</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </div>

                @if($booking->payment)
                    <div class="space-y-1 text-charcoal-600 bg-warm-50 p-3 rounded-lg">
                        <div class="flex justify-between">
                            <span>Method:</span>
                            <span class="font-semibold text-charcoal-900">{{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ref:</span>
                            <span class="font-mono text-[11px]">{{ $booking->payment->transaction_id }}</span>
                        </div>
                    </div>
                @endif

                <div class="space-y-2 pt-2">
                    <div class="flex justify-between text-charcoal-600">
                        <span>Room ({{ $booking->nights }} nights)</span>
                        <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->discount > 0)
                        <div class="flex justify-between text-emerald-600 font-medium">
                            <span>Discount ({{ $booking->promo_code }})</span>
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

                    @if($booking->serviceOrders->isNotEmpty())
                        <div class="flex justify-between text-gold-800 font-semibold">
                            <span>Services & Orders</span>
                            <span>Rp {{ number_format($booking->serviceOrders->sum('total'), 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-charcoal-200 flex justify-between font-bold text-sm text-charcoal-900">
                        <span>Total Folio</span>
                        <span class="text-gold-800 text-base">
                            Rp {{ number_format($booking->total + $booking->serviceOrders->sum('total'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Service Modal --}}
    <div x-show="serviceModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-charcoal-900/60 backdrop-blur-sm modal-overlay">
        <div @click.away="serviceModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl modal-content space-y-4">
            <h3 class="font-display text-xl font-bold text-charcoal-900">Charge Service to Room</h3>
            <form action="{{ route('admin.bookings.add-service', $booking) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label text-xs">Select Service <span class="text-red-500">*</span></label>
                    <select name="service_id" required class="form-select text-xs">
                        <option value="">Choose service...</option>
                        @foreach($services as $svc)
                            <option value="{{ $svc->id }}">{{ $svc->name }} — Rp {{ number_format($svc->price, 0, ',', '.') }} ({{ $svc->category }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label text-xs">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" required class="form-input text-xs">
                </div>

                <div>
                    <label class="form-label text-xs">Notes (E.g. Table 4, 18:00 delivery)</label>
                    <input type="text" name="notes" placeholder="Optional notes" class="form-input text-xs">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="serviceModal = false" class="btn-outline btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Add to Folio</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
