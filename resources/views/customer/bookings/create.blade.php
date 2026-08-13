@extends('layouts.app')

@section('title', 'Complete Your Reservation — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen" x-data="checkoutPage({
    roomPrice: {{ $room->price_per_night }},
    subtotal: {{ $pricing['subtotal'] }},
    tax: {{ $pricing['tax'] }},
    serviceCharge: {{ $pricing['service_charge'] }},
    total: {{ $pricing['total'] }},
    validatePromoUrl: '{{ route('customer.bookings.validate-promo') }}'
})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb & Stepper --}}
        <div class="mb-8">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-gold-500 text-white flex items-center justify-center text-xs font-bold">1</span>
                    <span class="text-xs font-semibold text-charcoal-900">Guest Details</span>
                </div>
                <div class="flex-1 h-0.5 bg-charcoal-200 mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-charcoal-200 text-charcoal-600 flex items-center justify-center text-xs font-bold">2</span>
                    <span class="text-xs font-medium text-charcoal-500">Payment</span>
                </div>
                <div class="flex-1 h-0.5 bg-charcoal-200 mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-charcoal-200 text-charcoal-600 flex items-center justify-center text-xs font-bold">3</span>
                    <span class="text-xs font-medium text-charcoal-500">Confirmation</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Guest Form --}}
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('customer.bookings.store') }}" method="POST" id="bookingForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="check_in" value="{{ $checkIn }}">
                    <input type="hidden" name="check_out" value="{{ $checkOut }}">
                    <input type="hidden" name="guests" value="{{ $guests }}">
                    <input type="hidden" name="promo_code" :value="appliedPromoCode">

                    {{-- Guest Information Card --}}
                    <div class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-200 shadow-sm">
                        <h2 class="font-display text-xl font-bold text-charcoal-900 mb-6">Guest Information</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name) }}" required
                                       class="form-input">
                                @error('guest_name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="guest_email" value="{{ old('guest_email', auth()->user()->email) }}" required
                                       class="form-input">
                                @error('guest_email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="guest_phone" value="{{ old('guest_phone', auth()->user()->phone) }}"
                                       placeholder="+62 812-3456-7890" class="form-input">
                                @error('guest_phone') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="form-label">Special Requests (Optional)</label>
                                <textarea name="special_request" rows="3"
                                          placeholder="E.g. Early check-in preference, airport transfer request, high floor, honeymoon arrangement..."
                                          class="form-textarea">{{ old('special_request') }}</textarea>
                                <p class="text-[11px] text-charcoal-400 mt-1">Special requests are subject to availability upon arrival.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Cancellation Policy Notice --}}
                    <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm">
                        <h3 class="font-display text-base font-bold text-charcoal-900 mb-2">Reservation & Cancellation Policy</h3>
                        <ul class="text-xs text-charcoal-600 space-y-1.5 list-disc pl-4">
                            <li>Check-in begins at 14:00 WITA. Early check-in is subject to room availability.</li>
                            <li>Check-out is before 12:00 WITA. Late check-out may incur additional fees.</li>
                            <li>Free cancellation up to 48 hours prior to check-in date.</li>
                            <li>All rooms are non-smoking. Designated outdoor smoking areas are available.</li>
                        </ul>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('rooms.show', $room->slug) }}" class="btn-outline btn-sm">
                            ← Change Room
                        </a>
                        <button type="submit" class="btn-primary">
                            Continue to Payment →
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right: Reservation Summary & Promo --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Room Summary Card --}}
                <div class="bg-white rounded-xl overflow-hidden border border-charcoal-200 shadow-sm">
                    <img src="{{ $room->primary_image_url }}" alt="{{ $room->name }}" class="w-full h-44 object-cover">
                    <div class="p-6">
                        <span class="badge bg-gold-100 text-gold-800 font-semibold mb-1">{{ $room->roomType->name }}</span>
                        <h3 class="font-display text-lg font-bold text-charcoal-900">{{ $room->name }}</h3>
                        <p class="text-xs text-charcoal-500 mt-1">Room {{ $room->room_number }} · Floor {{ $room->floor }}</p>

                        {{-- Dates Breakdown --}}
                        <div class="mt-4 pt-4 border-t border-charcoal-100 grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-charcoal-400 block uppercase text-[10px] font-semibold">Check-in</span>
                                <span class="font-semibold text-charcoal-900">{{ \Carbon\Carbon::parse($checkIn)->format('D, d M Y') }}</span>
                                <span class="text-charcoal-400 block text-[10px]">From 14:00</span>
                            </div>
                            <div>
                                <span class="text-charcoal-400 block uppercase text-[10px] font-semibold">Check-out</span>
                                <span class="font-semibold text-charcoal-900">{{ \Carbon\Carbon::parse($checkOut)->format('D, d M Y') }}</span>
                                <span class="text-charcoal-400 block text-[10px]">Until 12:00</span>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-t border-charcoal-100 text-xs text-charcoal-600 flex justify-between">
                            <span>Stay Duration</span>
                            <span class="font-semibold text-charcoal-900">{{ $pricing['nights'] }} {{ $pricing['nights'] === 1 ? 'Night' : 'Nights' }}</span>
                        </div>
                        <div class="mt-1 text-xs text-charcoal-600 flex justify-between">
                            <span>Guests</span>
                            <span class="font-semibold text-charcoal-900">{{ $guests }} {{ $guests === 1 ? 'Guest' : 'Guests' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Promo Code Box --}}
                <div class="bg-white rounded-xl p-5 border border-charcoal-200 shadow-sm">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-700 mb-2">Have a Promo Code?</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="promoInput" placeholder="E.g. WELCOME10"
                               class="form-input uppercase text-xs">
                        <button type="button" @click="applyPromo()" :disabled="loadingPromo || !promoInput"
                                class="btn-secondary btn-sm shrink-0">
                            <span x-show="!loadingPromo">Apply</span>
                            <span x-show="loadingPromo">...</span>
                        </button>
                    </div>
                    <p x-show="promoMessage" :class="promoValid ? 'text-emerald-600' : 'text-red-600'"
                       class="text-xs mt-2 font-medium" x-text="promoMessage"></p>
                </div>

                {{-- Price Breakdown Card --}}
                <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm space-y-3 text-xs">
                    <h4 class="font-display text-base font-bold text-charcoal-900 pb-2 border-b border-charcoal-100">Price Details</h4>

                    <div class="flex justify-between text-charcoal-600">
                        <span>Room rate ({{ $pricing['nights'] }} nights)</span>
                        <span>Rp {{ number_format($pricing['subtotal'], 0, ',', '.') }}</span>
                    </div>

                    <div x-show="discount > 0" class="flex justify-between text-emerald-600 font-medium">
                        <span>Promo Discount</span>
                        <span x-text="'- Rp ' + formatRupiah(discount)"></span>
                    </div>

                    <div class="flex justify-between text-charcoal-600">
                        <span>Government Tax (10%)</span>
                        <span x-text="'Rp ' + formatRupiah(currentTax)"></span>
                    </div>

                    <div class="flex justify-between text-charcoal-600">
                        <span>Service Charge (5%)</span>
                        <span x-text="'Rp ' + formatRupiah(currentServiceCharge)"></span>
                    </div>

                    <div class="pt-3 border-t border-charcoal-200 flex justify-between font-bold text-sm text-charcoal-900">
                        <span>Grand Total</span>
                        <span class="text-gold-800 text-lg" x-text="'Rp ' + formatRupiah(currentTotal)"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checkoutPage(config) {
    return {
        roomPrice: config.roomPrice,
        subtotal: config.subtotal,
        originalTax: config.tax,
        originalService: config.serviceCharge,
        originalTotal: config.total,

        promoInput: '',
        appliedPromoCode: '',
        discount: 0,
        promoMessage: '',
        promoValid: false,
        loadingPromo: false,

        get currentSubtotalAfterDiscount() {
            return Math.max(0, this.subtotal - this.discount);
        },
        get currentTax() {
            return Math.round(this.currentSubtotalAfterDiscount * 0.10);
        },
        get currentServiceCharge() {
            return Math.round(this.currentSubtotalAfterDiscount * 0.05);
        },
        get currentTotal() {
            return this.currentSubtotalAfterDiscount + this.currentTax + this.currentServiceCharge;
        },

        async applyPromo() {
            if (!this.promoInput) return;
            this.loadingPromo = true;
            this.promoMessage = '';

            try {
                const response = await fetch(config.validatePromoUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        code: this.promoInput,
                        subtotal: this.subtotal
                    })
                });

                const data = await response.json();
                this.promoValid = data.valid;
                this.promoMessage = data.message;

                if (data.valid) {
                    this.discount = data.discount;
                    this.appliedPromoCode = this.promoInput.toUpperCase();
                } else {
                    this.discount = 0;
                    this.appliedPromoCode = '';
                }
            } catch (e) {
                this.promoValid = false;
                this.promoMessage = 'Failed to validate promo code.';
            } finally {
                this.loadingPromo = false;
            }
        },

        formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    };
}
</script>
@endpush
@endsection
