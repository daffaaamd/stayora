@extends('layouts.admin')

@section('page_title', 'Final Check-Out Folio — ' . $summary['booking']->booking_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.checkout.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Check-out List</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">
                Departure Settlement Folio #{{ $summary['booking']->booking_number }}
            </h2>
        </div>
    </div>

    {{-- Itemized Folio Summary Card --}}
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-charcoal-200 shadow-sm space-y-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 bg-warm-50 rounded-xl text-xs">
            <div>
                <span class="text-charcoal-400 block uppercase text-[10px]">Guest Name</span>
                <p class="font-bold text-charcoal-900 text-sm">{{ $summary['booking']->guest_name }}</p>
            </div>
            <div>
                <span class="text-charcoal-400 block uppercase text-[10px]">Occupied Room</span>
                <p class="font-bold text-charcoal-900 text-sm">Room {{ $summary['booking']->room->room_number }}</p>
            </div>
            <div>
                <span class="text-charcoal-400 block uppercase text-[10px]">Stay Duration</span>
                <p class="font-semibold text-charcoal-900">{{ $summary['booking']->nights }} Nights</p>
            </div>
            <div>
                <span class="text-charcoal-400 block uppercase text-[10px]">Actual Departure</span>
                <p class="font-semibold text-charcoal-900">{{ now()->format('d M Y, H:i') }}</p>
            </div>
        </div>

        {{-- Itemized Charges Table --}}
        <div>
            <h3 class="font-display text-base font-bold text-charcoal-900 mb-3">Itemized Folio Breakdown</h3>
            <div class="border border-charcoal-100 rounded-xl overflow-hidden text-xs">
                <table class="w-full">
                    <thead class="bg-warm-100 text-charcoal-600 font-semibold border-b border-charcoal-200">
                        <tr>
                            <th class="p-3 text-left">Description</th>
                            <th class="p-3 text-center">Qty / Nights</th>
                            <th class="p-3 text-right">Unit Price</th>
                            <th class="p-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-charcoal-50 text-charcoal-800">
                        <tr>
                            <td class="p-3 font-medium">{{ $summary['booking']->room->name }} (Room {{ $summary['booking']->room->room_number }})</td>
                            <td class="p-3 text-center">{{ $summary['booking']->nights }}</td>
                            <td class="p-3 text-right">Rp {{ number_format($summary['booking']->room->price_per_night, 0, ',', '.') }}</td>
                            <td class="p-3 text-right font-semibold">Rp {{ number_format($summary['booking']->subtotal, 0, ',', '.') }}</td>
                        </tr>

                        @foreach($summary['service_orders'] as $order)
                            <tr>
                                <td class="p-3">{{ $order->service->name }} <span class="text-charcoal-400 text-[11px]">({{ $order->notes ?? 'Service' }})</span></td>
                                <td class="p-3 text-center">{{ $order->quantity }}</td>
                                <td class="p-3 text-right">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                <td class="p-3 text-right font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        @if($summary['booking']->discount > 0)
                            <tr class="text-emerald-700 font-medium">
                                <td class="p-3" colspan="3">Promo Discount ({{ $summary['booking']->promo_code }})</td>
                                <td class="p-3 text-right">- Rp {{ number_format($summary['booking']->discount, 0, ',', '.') }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td class="p-3 text-charcoal-500" colspan="3">Taxes & Service Charge (15%)</td>
                            <td class="p-3 text-right">Rp {{ number_format($summary['booking']->tax + $summary['booking']->service_charge, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-warm-50 font-bold border-t border-charcoal-200">
                        <tr>
                            <td class="p-3 text-sm" colspan="3">Grand Total Folio</td>
                            <td class="p-3 text-right text-base text-gold-800">Rp {{ number_format($summary['grand_total'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="p-3 text-xs text-emerald-700" colspan="3">Pre-paid / Settled Amount</td>
                            <td class="p-3 text-right text-emerald-700">- Rp {{ number_format($summary['paid_amount'], 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-warm-100 text-charcoal-900 font-bold">
                            <td class="p-3 text-sm" colspan="3">Outstanding Balance Due</td>
                            <td class="p-3 text-right text-base {{ $summary['balance_due'] > 0 ? 'text-red-700' : 'text-emerald-700' }}">
                                Rp {{ number_format($summary['balance_due'], 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Complete Check-Out Action --}}
        <div class="pt-4 flex items-center justify-between border-t border-charcoal-100">
            <p class="text-xs text-charcoal-500">
                Checking out will release <strong>Room {{ $summary['booking']->room->room_number }}</strong> to Housekeeping (cleaning status) and mark this booking as Completed.
            </p>
            <form action="{{ route('admin.checkout.process', $summary['booking']) }}" method="POST" onsubmit="return confirm('Complete final check-out?');">
                @csrf
                <button type="submit" class="btn-primary">
                    ✓ Finalize & Complete Check-out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
