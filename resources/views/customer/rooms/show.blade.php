@extends('layouts.app')

@section('title', $room->name . ' — Stayora Resort Bali')
@section('meta_description', $room->description)

@section('content')
{{-- Breadcrumb --}}
<div class="bg-warm-100 border-b border-charcoal-100 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-charcoal-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-charcoal-900">Home</a>
            <span>/</span>
            <a href="{{ route('rooms.index') }}" class="hover:text-charcoal-900">Rooms</a>
            <span>/</span>
            <span class="text-charcoal-900 font-medium truncate">{{ $room->name }}</span>
        </nav>
    </div>
</div>

<div class="py-10 bg-white" x-data="roomBooking({
    pricePerNight: {{ $room->price_per_night }},
    roomId: {{ $room->id }},
    initialCheckIn: '{{ request('check_in', now()->addDay()->format('Y-m-d')) }}',
    initialCheckOut: '{{ request('check_out', now()->addDays(2)->format('Y-m-d')) }}',
    initialGuests: {{ request('guests', 2) }}
})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Title & Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="badge bg-gold-100 text-gold-800 font-semibold">{{ $room->roomType->name }}</span>
                    <span class="text-xs text-charcoal-500">Room {{ $room->room_number }} · Floor {{ $room->floor }}</span>
                    @if($room->view_type)
                        <span class="text-xs text-charcoal-500">· {{ $room->view_type }}</span>
                    @endif
                </div>
                <h1 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900">{{ $room->name }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <span class="text-xs text-charcoal-400 block">Nightly Rate</span>
                    <span class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">
                        Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-charcoal-500">/night</span>
                </div>
            </div>
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-10 rounded-2xl overflow-hidden" x-data="{ activeImage: '{{ $room->primary_image_url }}' }">
            {{-- Main Big Image --}}
            <div class="md:col-span-3 h-80 sm:h-[450px] relative bg-charcoal-100 overflow-hidden">
                <img :src="activeImage" alt="{{ $room->name }}" class="w-full h-full object-cover transition-all duration-300">
            </div>
            {{-- Thumbnails --}}
            <div class="grid grid-cols-3 md:grid-cols-1 gap-3 max-h-[450px] overflow-y-auto">
                @foreach($room->images as $img)
                    <div class="h-24 sm:h-32 rounded-lg overflow-hidden cursor-pointer border-2 transition-all"
                         :class="activeImage === '{{ $img->image_url }}' ? 'border-gold-500 shadow-md' : 'border-transparent opacity-75 hover:opacity-100'"
                         @click="activeImage = '{{ $img->image_url }}'">
                        <img src="{{ $img->image_url }}" alt="Room angle" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Left: Details, Specs, Amenities, Reviews --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Room Specs Bar --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 bg-warm-50 rounded-xl border border-charcoal-100">
                    <div>
                        <span class="text-[11px] text-charcoal-400 uppercase tracking-wider block">Max Guests</span>
                        <p class="font-display text-lg font-bold text-charcoal-900 mt-0.5">{{ $room->max_occupancy }} Adults</p>
                    </div>
                    <div>
                        <span class="text-[11px] text-charcoal-400 uppercase tracking-wider block">Bed Configuration</span>
                        <p class="font-display text-lg font-bold text-charcoal-900 mt-0.5">{{ $room->bed_type ?? 'King Bed' }}</p>
                    </div>
                    <div>
                        <span class="text-[11px] text-charcoal-400 uppercase tracking-wider block">Room Size</span>
                        <p class="font-display text-lg font-bold text-charcoal-900 mt-0.5">{{ $room->size_sqm ?? 45 }} m²</p>
                    </div>
                    <div>
                        <span class="text-[11px] text-charcoal-400 uppercase tracking-wider block">Scenic View</span>
                        <p class="font-display text-lg font-bold text-charcoal-900 mt-0.5 truncate">{{ $room->view_type ?? 'Ocean View' }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <h3 class="font-display text-2xl font-bold text-charcoal-900 mb-4">About This Room</h3>
                    <div class="text-charcoal-600 text-sm sm:text-base leading-relaxed space-y-4">
                        <p>{{ $room->description }}</p>
                        <p>
                            Designed to provide an elevated experience of Balinese serenity, this sanctuary includes daily housekeeping, high-speed Wi-Fi, premium bathroom amenities, and personal concierge services upon request.
                        </p>
                    </div>
                </div>

                {{-- Amenities --}}
                <div>
                    <h3 class="font-display text-2xl font-bold text-charcoal-900 mb-6">Room Amenities & Features</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($room->amenities as $amenity)
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-charcoal-100 bg-white">
                                <span class="w-8 h-8 rounded-lg bg-gold-50 text-gold-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <span class="text-xs font-medium text-charcoal-800">{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Reviews Section --}}
                <div class="pt-8 border-t border-charcoal-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-display text-2xl font-bold text-charcoal-900">Guest Reviews</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex items-center text-amber-500">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span class="font-bold text-charcoal-900 text-lg">{{ number_format($room->average_rating, 1) }}</span>
                                <span class="text-xs text-charcoal-500">({{ $room->reviews->count() }} reviews)</span>
                            </div>
                        </div>
                    </div>

                    {{-- Review breakdown categories --}}
                    @if($room->reviews->isNotEmpty())
                        <div class="grid grid-cols-3 gap-4 mb-8 p-4 bg-warm-50 rounded-xl">
                            <div>
                                <span class="text-xs text-charcoal-500 block">Room Comfort</span>
                                <span class="text-base font-bold text-charcoal-900">{{ number_format($room->reviews->avg('room_rating') ?? 4.8, 1) }} / 5.0</span>
                            </div>
                            <div>
                                <span class="text-xs text-charcoal-500 block">Service Quality</span>
                                <span class="text-base font-bold text-charcoal-900">{{ number_format($room->reviews->avg('service_rating') ?? 4.9, 1) }} / 5.0</span>
                            </div>
                            <div>
                                <span class="text-xs text-charcoal-500 block">Cleanliness</span>
                                <span class="text-base font-bold text-charcoal-900">{{ number_format($room->reviews->avg('cleanliness_rating') ?? 5.0, 1) }} / 5.0</span>
                            </div>
                        </div>

                        {{-- Individual Reviews --}}
                        <div class="space-y-6">
                            @foreach($room->reviews->take(5) as $review)
                                <div class="p-5 border border-charcoal-100 rounded-xl bg-white">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="w-9 h-9 rounded-full object-cover">
                                            <div>
                                                <h4 class="text-sm font-semibold text-charcoal-900">{{ $review->user->name }}</h4>
                                                <span class="text-[11px] text-charcoal-400">{{ $review->created_at->format('d M Y') }} · Verified Guest</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'fill-charcoal-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs sm:text-sm text-charcoal-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-charcoal-400 italic">No reviews yet for this room.</p>
                    @endif
                </div>
            </div>

            {{-- Right: Interactive Booking Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-charcoal-200 rounded-2xl p-6 shadow-xl sticky top-24">
                    <div class="border-b border-charcoal-100 pb-4 mb-5">
                        <div class="flex items-baseline justify-between">
                            <span class="font-display text-2xl font-bold text-charcoal-900">
                                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-charcoal-500">per night</span>
                        </div>
                        <p class="text-[11px] text-emerald-600 font-medium mt-1">✓ Best rate guarantee · Direct booking</p>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('customer.bookings.create', $room) }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1">Check-in Date</label>
                            <input type="date" name="check_in" x-model="checkIn" @change="calculate()"
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="w-full rounded-lg border-charcoal-300 text-sm focus:border-gold-500 focus:ring-gold-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1">Check-out Date</label>
                            <input type="date" name="check_out" x-model="checkOut" @change="calculate()"
                                   :min="minCheckOut"
                                   class="w-full rounded-lg border-charcoal-300 text-sm focus:border-gold-500 focus:ring-gold-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1">Guests</label>
                            <select name="guests" x-model="guests" class="w-full rounded-lg border-charcoal-300 text-sm focus:border-gold-500 focus:ring-gold-500">
                                @for($i = 1; $i <= $room->max_occupancy; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Calculation Breakdown --}}
                        <div class="pt-4 border-t border-charcoal-100 space-y-2 text-xs">
                            <div class="flex justify-between text-charcoal-600">
                                <span>Duration</span>
                                <span class="font-semibold text-charcoal-900" x-text="nights + ' night' + (nights > 1 ? 's' : '')"></span>
                            </div>
                            <div class="flex justify-between text-charcoal-600">
                                <span>Rate calculation</span>
                                <span>Rp {{ number_format($room->price_per_night, 0, ',', '.') }} × <span x-text="nights"></span></span>
                            </div>
                            <div class="flex justify-between text-charcoal-600">
                                <span>Taxes & Service (15%)</span>
                                <span x-text="'Rp ' + formatRupiah(taxAndService)"></span>
                            </div>
                            <div class="pt-2 border-t border-charcoal-100 flex justify-between font-bold text-sm text-charcoal-900">
                                <span>Estimated Total</span>
                                <span class="text-gold-800 text-base" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                            </div>
                        </div>

                        <div class="pt-4">
                            @auth
                                <button type="submit" class="w-full btn-primary py-3 justify-center shadow-lg">
                                    Reserve Room
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="w-full btn-primary py-3 justify-center text-center shadow-lg block">
                                    Sign In to Book
                                </a>
                            @endauth
                        </div>

                        <p class="text-[11px] text-charcoal-400 text-center">
                            You won't be charged yet. Instant confirmation upon checkout.
                        </p>
                    </form>
                </div>
            </div>
        </div>

        {{-- Related Rooms --}}
        @if($relatedRooms->isNotEmpty())
            <div class="mt-20 pt-12 border-t border-charcoal-100">
                <h3 class="font-display text-2xl font-bold text-charcoal-900 mb-6">Similar Accommodations</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedRooms as $related)
                        <a href="{{ route('rooms.show', $related->slug) }}" class="card overflow-hidden group hover:shadow-md transition-all">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $related->primary_image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-4">
                                <span class="text-[10px] uppercase font-bold text-gold-600 tracking-wider">{{ $related->roomType->name }}</span>
                                <h4 class="font-display text-base font-bold text-charcoal-900 mt-1">{{ $related->name }}</h4>
                                <div class="mt-3 pt-2 border-t border-charcoal-100 flex items-center justify-between text-xs">
                                    <span class="text-charcoal-400">From</span>
                                    <span class="font-bold text-gold-700">Rp {{ number_format($related->price_per_night, 0, ',', '.') }}<span class="font-normal text-charcoal-400">/nt</span></span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function roomBooking(config) {
    return {
        pricePerNight: config.pricePerNight,
        roomId: config.roomId,
        checkIn: config.initialCheckIn,
        checkOut: config.initialCheckOut,
        guests: config.initialGuests,
        nights: 1,
        taxAndService: 0,
        grandTotal: 0,

        init() {
            this.calculate();
        },

        get minCheckOut() {
            if (!this.checkIn) return '';
            const d = new Date(this.checkIn);
            d.setDate(d.getDate() + 1);
            return d.toISOString().split('T')[0];
        },

        calculate() {
            if (!this.checkIn || !this.checkOut) return;
            const start = new Date(this.checkIn);
            const end = new Date(this.checkOut);
            const diffTime = end - start;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays <= 0) diffDays = 1;

            this.nights = diffDays;
            const roomTotal = this.pricePerNight * diffDays;
            this.taxAndService = Math.round(roomTotal * 0.15);
            this.grandTotal = roomTotal + this.taxAndService;
        },

        formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    };
}
</script>
@endpush
@endsection
