@extends('layouts.app')

@section('title', 'Payment — ' . $booking->booking_number)

@section('content')
<div class="bg-warm-50 py-10 min-h-screen" x-data="{
    paymentMethod: 'bank_transfer',
    selectedBank: 'bca',
    cardName: '{{ auth()->user()->name }}',
    cardNumber: '4111 2222 3333 4444',
    cardExpiry: '12/28',
    cardCvv: '123'
}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Stepper --}}
        <div class="mb-8">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">✓</span>
                    <span class="text-xs font-semibold text-charcoal-700">Guest Details</span>
                </div>
                <div class="flex-1 h-0.5 bg-gold-500 mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-gold-500 text-white flex items-center justify-center text-xs font-bold">2</span>
                    <span class="text-xs font-bold text-charcoal-900">Payment</span>
                </div>
                <div class="flex-1 h-0.5 bg-charcoal-200 mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-charcoal-200 text-charcoal-600 flex items-center justify-center text-xs font-bold">3</span>
                    <span class="text-xs font-medium text-charcoal-500">Confirmation</span>
                </div>
            </div>
        </div>

        {{-- Main Payment Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Left: Payment Method Selection --}}
            <div class="md:col-span-2 space-y-6">
                <form action="{{ route('customer.payment.process', $booking) }}" method="POST" id="paymentForm">
                    @csrf
                    <input type="hidden" name="payment_method" :value="paymentMethod">

                    <div class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-200 shadow-sm space-y-6">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-gold-600 font-semibold">Payment Gateway</span>
                            <h2 class="font-display text-2xl font-bold text-charcoal-900 mt-1">Select Payment Method</h2>
                            <p class="text-xs text-charcoal-500 mt-1">Safe and 256-bit SSL encrypted enterprise transaction processing.</p>
                        </div>

                        {{-- Methods Options --}}
                        <div class="grid grid-cols-2 gap-3">
                            {{-- Bank Transfer --}}
                            <label class="border rounded-xl p-4 cursor-pointer transition-all flex flex-col justify-between"
                                   :class="paymentMethod === 'bank_transfer' ? 'border-gold-500 bg-gold-50/50 shadow-sm' : 'border-charcoal-200 hover:border-charcoal-300'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-charcoal-900">Bank Transfer</span>
                                    <input type="radio" name="method_radio" value="bank_transfer" x-model="paymentMethod" class="text-gold-500 focus:ring-gold-500">
                                </div>
                                <span class="text-[11px] text-charcoal-500">Virtual Account (BCA, Mandiri, BNI, BRI)</span>
                            </label>

                            {{-- Credit Card --}}
                            <label class="border rounded-xl p-4 cursor-pointer transition-all flex flex-col justify-between"
                                   :class="paymentMethod === 'credit_card' ? 'border-gold-500 bg-gold-50/50 shadow-sm' : 'border-charcoal-200 hover:border-charcoal-300'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-charcoal-900">Credit / Debit Card</span>
                                    <input type="radio" name="method_radio" value="credit_card" x-model="paymentMethod" class="text-gold-500 focus:ring-gold-500">
                                </div>
                                <span class="text-[11px] text-charcoal-500">Visa, Mastercard, JCB instant</span>
                            </label>

                            {{-- E-Wallet / QRIS --}}
                            <label class="border rounded-xl p-4 cursor-pointer transition-all flex flex-col justify-between"
                                   :class="paymentMethod === 'e_wallet' ? 'border-gold-500 bg-gold-50/50 shadow-sm' : 'border-charcoal-200 hover:border-charcoal-300'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-charcoal-900">QRIS / E-Wallet</span>
                                    <input type="radio" name="method_radio" value="e_wallet" x-model="paymentMethod" class="text-gold-500 focus:ring-gold-500">
                                </div>
                                <span class="text-[11px] text-charcoal-500">GoPay, OVO, ShopeePay, Dana</span>
                            </label>

                            {{-- Cash upon Arrival --}}
                            <label class="border rounded-xl p-4 cursor-pointer transition-all flex flex-col justify-between"
                                   :class="paymentMethod === 'cash' ? 'border-gold-500 bg-gold-50/50 shadow-sm' : 'border-charcoal-200 hover:border-charcoal-300'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-charcoal-900">Pay at Hotel</span>
                                    <input type="radio" name="method_radio" value="cash" x-model="paymentMethod" class="text-gold-500 focus:ring-gold-500">
                                </div>
                                <span class="text-[11px] text-charcoal-500">Cash / Card upon Front Desk Check-in</span>
                            </label>
                        </div>

                        {{-- Dynamic Method Details --}}
                        {{-- 1. Virtual Account Box --}}
                        <div x-show="paymentMethod === 'bank_transfer'" class="p-5 bg-warm-100 rounded-xl border border-charcoal-200 space-y-4">
                            <label class="block text-xs font-semibold text-charcoal-700">Choose Virtual Account Bank:</label>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" @click="selectedBank = 'bca'"
                                        :class="selectedBank === 'bca' ? 'border-gold-600 bg-white font-bold text-gold-800' : 'bg-white/60 border-charcoal-200 text-charcoal-600'"
                                        class="p-3 text-xs border rounded-lg text-center">BCA</button>
                                <button type="button" @click="selectedBank = 'mandiri'"
                                        :class="selectedBank === 'mandiri' ? 'border-gold-600 bg-white font-bold text-gold-800' : 'bg-white/60 border-charcoal-200 text-charcoal-600'"
                                        class="p-3 text-xs border rounded-lg text-center">Mandiri</button>
                                <button type="button" @click="selectedBank = 'bni'"
                                        :class="selectedBank === 'bni' ? 'border-gold-600 bg-white font-bold text-gold-800' : 'bg-white/60 border-charcoal-200 text-charcoal-600'"
                                        class="p-3 text-xs border rounded-lg text-center">BNI</button>
                                <button type="button" @click="selectedBank = 'bri'"
                                        :class="selectedBank === 'bri' ? 'border-gold-600 bg-white font-bold text-gold-800' : 'bg-white/60 border-charcoal-200 text-charcoal-600'"
                                        class="p-3 text-xs border rounded-lg text-center">BRI</button>
                            </div>
                            <div class="p-4 bg-white rounded-lg border border-charcoal-200 text-xs">
                                <span class="text-charcoal-500 block">Simulated Virtual Account Number:</span>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="font-mono text-base font-bold text-charcoal-900">8801 2948 5592 1002</span>
                                    <span class="badge badge-primary">Auto Verify</span>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Credit Card Box --}}
                        <div x-show="paymentMethod === 'credit_card'" class="p-5 bg-warm-100 rounded-xl border border-charcoal-200 space-y-4">
                            <div>
                                <label class="form-label text-xs">Cardholder Name</label>
                                <input type="text" x-model="cardName" class="form-input text-xs">
                            </div>
                            <div>
                                <label class="form-label text-xs">Card Number</label>
                                <input type="text" x-model="cardNumber" class="form-input text-xs font-mono">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label text-xs">Expiry Date</label>
                                    <input type="text" x-model="cardExpiry" class="form-input text-xs font-mono">
                                </div>
                                <div>
                                    <label class="form-label text-xs">CVV</label>
                                    <input type="password" x-model="cardCvv" class="form-input text-xs font-mono">
                                </div>
                            </div>
                        </div>

                        {{-- 3. QRIS Box --}}
                        <div x-show="paymentMethod === 'e_wallet'" class="p-5 bg-warm-100 rounded-xl border border-charcoal-200 text-center space-y-3">
                            <span class="text-xs font-semibold text-charcoal-700 block">Scan QRIS with any e-wallet</span>
                            <div class="w-44 h-44 bg-white p-3 rounded-xl border border-charcoal-200 mx-auto flex items-center justify-center shadow-sm">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=STAYORA-{{ $booking->booking_number }}"
                                     alt="QR Code" class="w-full h-full object-contain">
                            </div>
                            <p class="text-[11px] text-charcoal-500">Supports GoPay, OVO, DANA, LinkAja, ShopeePay, BCA Mobile</p>
                        </div>

                        {{-- 4. Cash Box --}}
                        <div x-show="paymentMethod === 'cash'" class="p-5 bg-warm-100 rounded-xl border border-charcoal-200 text-xs space-y-2">
                            <p class="font-semibold text-charcoal-900">Pay directly upon Check-in at Stayora Resort</p>
                            <p class="text-charcoal-600">Your room is guaranteed and reserved. You can settle the full payment during front desk reception check-in.</p>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full btn-primary py-3 justify-center text-base shadow-lg">
                                Complete Payment (Rp {{ number_format($booking->total, 0, ',', '.') }})
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Right: Reservation Recap --}}
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-charcoal-100 pb-3">
                        <span class="text-[10px] uppercase font-bold text-gold-600 tracking-wider">Booking Number</span>
                        <p class="font-mono text-base font-bold text-charcoal-900">{{ $booking->booking_number }}</p>
                    </div>

                    <div>
                        <h3 class="font-display text-base font-bold text-charcoal-900">{{ $booking->room->name }}</h3>
                        <p class="text-charcoal-500">{{ $booking->room->roomType->name }} · Room {{ $booking->room->room_number }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 py-2 border-y border-charcoal-100">
                        <div>
                            <span class="text-charcoal-400 block text-[10px] uppercase">Check-in</span>
                            <span class="font-semibold text-charcoal-900">{{ $booking->check_in->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-charcoal-400 block text-[10px] uppercase">Check-out</span>
                            <span class="font-semibold text-charcoal-900">{{ $booking->check_out->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-charcoal-600">
                        <div class="flex justify-between">
                            <span>Duration</span>
                            <span class="font-semibold text-charcoal-900">{{ $booking->nights }} Nights</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Guests</span>
                            <span class="font-semibold text-charcoal-900">{{ $booking->guests }} Guests</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Room Subtotal</span>
                            <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->discount > 0)
                            <div class="flex justify-between text-emerald-600 font-medium">
                                <span>Discount ({{ $booking->promo_code }})</span>
                                <span>- Rp {{ number_format($booking->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Service Charge (5%)</span>
                            <span>Rp {{ number_format($booking->service_charge, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-charcoal-200 flex justify-between font-bold text-sm text-charcoal-900">
                        <span>Total Payable</span>
                        <span class="text-gold-800 text-base">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
