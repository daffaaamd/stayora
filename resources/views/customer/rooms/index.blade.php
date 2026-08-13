@extends('layouts.app')

@section('title', 'Rooms & Suites — Stayora Resort Bali')
@section('meta_description', 'Explore luxury rooms, suites, and private villas at Stayora Resort Bali. Check real-time availability, amenities, and book directly for the best rates.')

@section('content')
{{-- Header Banner --}}
<section class="bg-charcoal-900 text-white py-16 relative overflow-hidden">
    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1600&q=80"
         alt="Luxury Rooms"
         class="absolute inset-0 w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-charcoal-900/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold mb-2 block">Stayora Accommodations</span>
        <h1 class="font-display text-4xl sm:text-5xl font-bold">Rooms & Luxury Suites</h1>
        <p class="text-warm-200 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            Find your perfect sanctuary. Each room offers bespoke amenities, refined interior design, and breathtaking ocean or tropical garden views.
        </p>
    </div>
</section>

{{-- Search & Filter Bar --}}
<section class="bg-white border-b border-charcoal-100 sticky top-16 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal-500 mb-1">Check-in</label>
                <input type="date" name="check_in"
                       value="{{ request('check_in', $checkIn) }}"
                       min="{{ now()->format('Y-m-d') }}"
                       class="w-full rounded-md border-charcoal-200 text-xs py-2 focus:border-gold-500 focus:ring-gold-500">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal-500 mb-1">Check-out</label>
                <input type="date" name="check_out"
                       value="{{ request('check_out', $checkOut) }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full rounded-md border-charcoal-200 text-xs py-2 focus:border-gold-500 focus:ring-gold-500">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal-500 mb-1">Guests</label>
                <select name="guests" class="w-full rounded-md border-charcoal-200 text-xs py-2 focus:border-gold-500 focus:ring-gold-500">
                    <option value="">Any</option>
                    <option value="1" {{ request('guests', $guests) == 1 ? 'selected' : '' }}>1 Guest</option>
                    <option value="2" {{ request('guests', $guests) == 2 ? 'selected' : '' }}>2 Guests</option>
                    <option value="3" {{ request('guests', $guests) == 3 ? 'selected' : '' }}>3 Guests</option>
                    <option value="4" {{ request('guests', $guests) == 4 ? 'selected' : '' }}>4+ Guests</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal-500 mb-1">Room Type</label>
                <select name="room_type" class="w-full rounded-md border-charcoal-200 text-xs py-2 focus:border-gold-500 focus:ring-gold-500">
                    <option value="">All Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ request('room_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal-500 mb-1">Sort By</label>
                <select name="sort" class="w-full rounded-md border-charcoal-200 text-xs py-2 focus:border-gold-500 focus:ring-gold-500">
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rating</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full btn-primary btn-sm py-2 justify-center">
                    Filter & Search
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Main Listing Section --}}
<section class="py-12 bg-warm-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Search Status Summary --}}
        @if($hasSearch)
            <div class="mb-8 p-4 bg-gold-50 border border-gold-200 rounded-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gold-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-xs sm:text-sm text-gold-900 font-medium">
                        Showing available rooms for stay: <strong>{{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}</strong> ({{ \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) }} nights)
                    </span>
                </div>
                <a href="{{ route('rooms.index') }}" class="text-xs text-gold-700 underline font-semibold hover:text-gold-800">Clear Search</a>
            </div>
        @endif

        {{-- Rooms Grid --}}
        @if($rooms->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($rooms as $room)
                    <div class="card overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col bg-white">
                        {{-- Image & Badges --}}
                        <div class="relative h-64 overflow-hidden bg-charcoal-100">
                            <img src="{{ $room->primary_image_url }}" alt="{{ $room->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                            <div class="absolute top-3 left-3">
                                <span class="badge bg-white/95 text-charcoal-900 font-semibold shadow-sm">{{ $room->roomType->name }}</span>
                            </div>
                            <div class="absolute top-3 right-3">
                                @if($hasSearch)
                                    <span class="badge bg-emerald-500 text-white font-medium shadow-sm">Available</span>
                                @else
                                    <span class="badge {{ $room->isAvailable() ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $room->isAvailable() ? 'Available' : 'Booked' }}
                                    </span>
                                @endif
                            </div>
                            @if($room->view_type)
                                <div class="absolute bottom-3 left-3">
                                    <span class="text-[11px] bg-charcoal-900/80 text-white px-2.5 py-1 rounded backdrop-blur-sm">
                                        {{ $room->view_type }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-charcoal-400 uppercase tracking-wider">
                                        Room {{ $room->room_number }} · Floor {{ $room->floor }}
                                    </span>
                                    <div class="flex items-center gap-1 text-amber-500 text-xs font-semibold">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>{{ number_format($room->average_rating, 1) }}</span>
                                        <span class="text-charcoal-400 font-normal">({{ $room->reviews_count ?? $room->reviews()->count() }})</span>
                                    </div>
                                </div>

                                <h3 class="font-display text-xl font-bold text-charcoal-900 mb-2 group-hover:text-gold-600 transition-colors">
                                    {{ $room->name }}
                                </h3>

                                <p class="text-xs text-charcoal-600 mb-4 line-clamp-2 leading-relaxed">
                                    {{ $room->description }}
                                </p>

                                {{-- Features row --}}
                                <div class="grid grid-cols-3 gap-2 py-3 border-y border-charcoal-100 text-xs text-charcoal-600 mb-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        <span>Max {{ $room->max_occupancy }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                        <span class="truncate">{{ $room->bed_type ?? 'King Bed' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                                        <span>{{ $room->size_sqm ?? 45 }} m²</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Price & CTA --}}
                            <div class="pt-2 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] text-charcoal-400 block">Starting from</span>
                                    <span class="font-display text-lg font-bold text-charcoal-900">
                                        Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-charcoal-500">/night</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('rooms.show', ['slug' => $room->slug, 'check_in' => $checkIn, 'check_out' => $checkOut, 'guests' => $guests]) }}"
                                       class="btn-primary btn-sm">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $rooms->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl p-12 text-center border border-charcoal-200 max-w-md mx-auto">
                <svg class="w-12 h-12 text-charcoal-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                <h3 class="font-display text-lg font-bold text-charcoal-900 mb-2">No Rooms Available</h3>
                <p class="text-xs text-charcoal-500 mb-6">We couldn't find any rooms matching your selected dates or criteria. Please adjust your dates or filters.</p>
                <a href="{{ route('rooms.index') }}" class="btn-secondary btn-sm">Reset All Filters</a>
            </div>
        @endif
    </div>
</section>
@endsection
