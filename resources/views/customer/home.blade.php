@extends('layouts.app')

@section('title', 'Stayora Resort — A Stay Worth Remembering')
@section('meta_description', 'Experience unparalleled luxury at Stayora Resort Bali. Nestled along the pristine coastline of Nusa Dua, offering world-class villas, suites, wellness spa, and gourmet dining.')

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-[90vh] flex items-center justify-center bg-charcoal-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=2000&q=85"
         alt="Stayora Resort Bali Exterior"
         class="absolute inset-0 w-full h-full object-cover opacity-60"
         data-fallback="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=2000&q=85">
    <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/40 to-charcoal-900/60"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white pt-12 pb-24">
        <span class="inline-block text-xs md:text-sm uppercase tracking-[0.3em] text-gold-400 font-semibold mb-4">
            Luxury Hotel & Resort — Nusa Dua, Bali
        </span>
        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white mb-4 leading-tight">
            Stayora Resort
        </h1>
        <p class="font-display italic text-xl sm:text-2xl lg:text-3xl text-warm-200 font-light mb-3 max-w-2xl mx-auto">
            A stay worth remembering.
        </p>
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-charcoal-900/90 border border-gold-500/50 backdrop-blur-md shadow-xl mb-10 hover:border-gold-400 transition-colors">
            <div class="w-6 h-6 rounded-full bg-gold-500/30 border border-gold-400/80 flex items-center justify-center text-gold-300 font-bold text-[10px] font-display">
                DA
            </div>
            <div class="flex items-center gap-1.5 text-xs sm:text-sm">
                <span class="text-charcoal-300 text-xs">Made by</span>
                <span class="font-bold text-white tracking-wide text-xs sm:text-sm">Daffa Ahmad Baihaqi</span>
            </div>
        </div>

        {{-- Booking Search Widget --}}
        <div class="bg-white/95 backdrop-blur-sm rounded-xl p-4 sm:p-6 shadow-2xl border border-charcoal-100/20 text-charcoal-900 max-w-4xl mx-auto text-left">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1.5">Check-in</label>
                    <input type="date" name="check_in"
                           value="{{ request('check_in', now()->addDay()->format('Y-m-d')) }}"
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full rounded-lg border-charcoal-200 text-sm focus:border-gold-500 focus:ring-gold-500 py-2.5">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1.5">Check-out</label>
                    <input type="date" name="check_out"
                           value="{{ request('check_out', now()->addDays(2)->format('Y-m-d')) }}"
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           class="w-full rounded-lg border-charcoal-200 text-sm focus:border-gold-500 focus:ring-gold-500 py-2.5">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1.5">Guests</label>
                    <select name="guests" class="w-full rounded-lg border-charcoal-200 text-sm focus:border-gold-500 focus:ring-gold-500 py-2.5">
                        <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Guest</option>
                        <option value="2" {{ request('guests', 2) == 2 ? 'selected' : '' }}>2 Guests</option>
                        <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4 Guests</option>
                        <option value="6" {{ request('guests') == 6 ? 'selected' : '' }}>5+ Guests</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal-600 mb-1.5">Room Type</label>
                    <select name="room_type" class="w-full rounded-lg border-charcoal-200 text-sm focus:border-gold-500 focus:ring-gold-500 py-2.5">
                        <option value="">All Room Types</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ request('room_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gold-500 hover:bg-gold-600 text-white font-medium text-sm py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Search Rooms</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- About Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Welcome to Paradise</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-6 leading-tight">
                    An Sanctuary of Serenity on Bali's Pristine Shores
                </h2>
                <p class="text-charcoal-600 leading-relaxed mb-6 text-base">
                    Set on 15 hectares of lush tropical coastline in exclusive Nusa Dua, Stayora Resort harmoniously blends authentic Balinese craftsmanship with modern luxury. Every villa and suite is designed to be an intimate haven overlooking the turquoise Indian Ocean.
                </p>
                <p class="text-charcoal-600 leading-relaxed mb-8 text-base">
                    Whether you seek restorative tranquility in our holistic wellness spa, culinary journeys curated by world-class chefs, or private beachside moments under the stars, Stayora is tailored to create lasting memories.
                </p>
                <div class="grid grid-cols-3 gap-6 pt-4 border-t border-charcoal-100">
                    <div>
                        <p class="font-display text-3xl font-bold text-charcoal-900">30+</p>
                        <p class="text-xs text-charcoal-500 uppercase tracking-wider mt-1">Luxury Suites</p>
                    </div>
                    <div>
                        <p class="font-display text-3xl font-bold text-charcoal-900">5★</p>
                        <p class="text-xs text-charcoal-500 uppercase tracking-wider mt-1">Resort Standard</p>
                    </div>
                    <div>
                        <p class="font-display text-3xl font-bold text-charcoal-900">100%</p>
                        <p class="text-xs text-charcoal-500 uppercase tracking-wider mt-1">Guest Satisfaction</p>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80"
                         alt="Stayora Suite Interior" class="rounded-xl shadow-lg object-cover h-72 w-full">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80"
                         alt="Stayora Infinity Pool" class="rounded-xl shadow-lg object-cover h-72 w-full mt-8">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-gold-50 border border-gold-200 p-6 rounded-xl shadow-md hidden sm:block">
                    <p class="font-display text-2xl font-bold text-gold-800">Best Luxury Resort</p>
                    <p class="text-xs text-gold-700 mt-1">World Travel Awards 2025 Nominee</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Room Types / Categories --}}
<section class="py-16 bg-warm-100 border-y border-charcoal-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Accommodations</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-4">
                Tailored for Refined Living
            </h2>
            <p class="text-charcoal-600 text-sm sm:text-base">
                Discover our signature room types, each thoughtfully appointed with bespoke furnishings, expansive terraces, and sweeping views.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($roomTypes as $type)
                <a href="{{ route('rooms.index', ['room_type' => $type->id]) }}"
                   class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md border border-charcoal-100 transition-all">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ $type->image_url }}" alt="{{ $type->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-charcoal-900/80 text-white text-[11px] font-semibold px-2 py-0.5 rounded">
                            {{ $type->rooms_count ?? $type->rooms()->count() }} Rooms
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-display text-base font-bold text-charcoal-900 group-hover:text-gold-600 transition-colors">{{ $type->name }}</h3>
                        <p class="text-xs text-charcoal-500 mt-1 line-clamp-2">{{ $type->description }}</p>
                        <div class="mt-4 pt-3 border-t border-charcoal-100 flex items-center justify-between">
                            <span class="text-xs text-charcoal-400">From</span>
                            <span class="text-sm font-bold text-gold-700">Rp {{ number_format($type->base_price, 0, ',', '.') }}<span class="text-[10px] font-normal text-charcoal-500">/nt</span></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Rooms --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Curated Stays</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2">
                    Featured Rooms & Suites
                </h2>
            </div>
            <a href="{{ route('rooms.index') }}" class="mt-4 sm:mt-0 text-sm font-medium text-gold-700 hover:text-gold-800 inline-flex items-center gap-1">
                <span>View all rooms</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRooms as $room)
                <div class="card overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $room->primary_image_url }}" alt="{{ $room->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="badge bg-white/90 text-charcoal-900 font-semibold shadow-sm">{{ $room->roomType->name }}</span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="badge {{ $room->isAvailable() ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $room->isAvailable() ? 'Available' : 'Booked' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-charcoal-500">Room {{ $room->room_number }} · Floor {{ $room->floor }}</span>
                                <div class="flex items-center gap-1 text-amber-500 text-xs font-semibold">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span>{{ number_format($room->average_rating, 1) }}</span>
                                </div>
                            </div>
                            <h3 class="font-display text-xl font-bold text-charcoal-900 mb-2 group-hover:text-gold-600 transition-colors">
                                {{ $room->name }}
                            </h3>
                            <p class="text-xs text-charcoal-600 mb-4 line-clamp-2">{{ $room->description }}</p>

                            <div class="flex items-center gap-4 text-xs text-charcoal-500 mb-6">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    {{ $room->max_occupancy }} Guests
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    {{ $room->bed_type ?? 'King Bed' }}
                                </span>
                                @if($room->size_sqm)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                                    {{ $room->size_sqm }} m²
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-4 border-t border-charcoal-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-charcoal-400 block">Rate per night</span>
                                <span class="font-display text-lg font-bold text-charcoal-900">
                                    Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ route('rooms.show', $room->slug) }}" class="btn-secondary btn-sm">
                                View Room
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Facilities Section --}}
<section class="py-20 bg-warm-50 border-t border-charcoal-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Resort Amenities</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-4">
                World-Class Facilities
            </h2>
            <p class="text-charcoal-600 text-sm sm:text-base">
                Immerse yourself in exceptional leisure, wellness, and recreation facilities thoughtfully created for your ultimate comfort.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($facilities as $facility)
                <div class="bg-white rounded-xl overflow-hidden border border-charcoal-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-lg font-bold text-charcoal-900 mb-2">{{ $facility->name }}</h3>
                        <p class="text-xs text-charcoal-600 leading-relaxed">{{ $facility->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Experiences Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Unforgettable Moments</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-4">
                Signature Experiences
            </h2>
            <p class="text-charcoal-600 text-sm sm:text-base">
                From private beachfront cabanas to authentic holistic spa therapies, embrace moments crafted just for you.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="relative rounded-xl overflow-hidden group h-80 shadow-md">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80"
                     alt="Beachfront Leisure" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <h4 class="font-display text-xl font-bold mb-1">Private Beach</h4>
                    <p class="text-xs text-warm-200">White sands, crystal waters, and private loungers.</p>
                </div>
            </div>

            <div class="relative rounded-xl overflow-hidden group h-80 shadow-md">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80"
                     alt="Gourmet Dining" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <h4 class="font-display text-xl font-bold mb-1">Gourmet Dining</h4>
                    <p class="text-xs text-warm-200">International & Balinese culinary mastery.</p>
                </div>
            </div>

            <div class="relative rounded-xl overflow-hidden group h-80 shadow-md">
                <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80"
                     alt="Holistic Spa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <h4 class="font-display text-xl font-bold mb-1">Holistic Spa</h4>
                    <p class="text-xs text-warm-200">Traditional healing massages & organic botanicals.</p>
                </div>
            </div>

            <div class="relative rounded-xl overflow-hidden group h-80 shadow-md">
                <img src="https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?auto=format&fit=crop&w=800&q=80"
                     alt="Ocean Sunset" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <h4 class="font-display text-xl font-bold mb-1">Sunset Cruise</h4>
                    <p class="text-xs text-warm-200">Catamaran excursions along the Nusa Dua coast.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Gallery Preview --}}
<section class="py-20 bg-warm-100 border-y border-charcoal-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Visual Tour</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2">
                    Resort Gallery
                </h2>
            </div>
            <a href="{{ route('gallery') }}" class="mt-4 sm:mt-0 text-sm font-medium text-gold-700 hover:text-gold-800 inline-flex items-center gap-1">
                <span>Explore all photos</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($galleryImages as $image)
                <div class="relative h-48 md:h-60 rounded-xl overflow-hidden group shadow-sm">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-charcoal-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4 text-white">
                        <div>
                            <p class="text-xs font-semibold">{{ $image->title }}</p>
                            <span class="text-[10px] uppercase text-gold-300">{{ $image->category }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Guest Reviews --}}
@if($reviews->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Testimonials</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-4">
                What Our Guests Say
            </h2>
            <p class="text-charcoal-600 text-sm sm:text-base">
                Real feedback from verified guests who experienced the tranquility and warmth of Stayora.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reviews as $review)
                <div class="bg-warm-50 border border-charcoal-100 rounded-xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-1 text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 fill-charcoal-200" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-[11px] text-charcoal-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-charcoal-700 italic mb-6 leading-relaxed">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                    <div class="pt-4 border-t border-charcoal-100 flex items-center gap-3">
                        <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-semibold text-charcoal-900">{{ $review->user->name }}</p>
                            <p class="text-xs text-charcoal-500">Stayed in {{ $review->room->roomType->name ?? 'Suite' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Location & Map Section --}}
<section class="py-20 bg-warm-100 border-t border-charcoal-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-gold-600 font-semibold">Location & Arrival</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-6">
                    A Privileged Setting in Nusa Dua
                </h2>
                <p class="text-charcoal-600 leading-relaxed mb-6 text-sm sm:text-base">
                    Situated only 20 minutes from Ngurah Rai International Airport (DPS), Stayora Resort offers seamless access while retaining complete seclusion amidst coastal greenery and private beachfronts.
                </p>
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-gold-100 text-gold-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-charcoal-900">Address</h4>
                            <p class="text-xs text-charcoal-500">Jl. Pantai Indah No. 88, Kawasan Pariwisata Nusa Dua, Bali 80363</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-gold-100 text-gold-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-charcoal-900">Airport Transfer</h4>
                            <p class="text-xs text-charcoal-500">Private luxury chauffeur available upon request (20 minutes travel time).</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('rooms.index') }}" class="btn-primary">
                    Book Your Stay Today
                </a>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg border border-charcoal-200 h-96 relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.868779601111!2d115.22851167484464!3d-8.798418991254392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244bd91811e5f%3A0xb249f33b1e77e231!2sNusa%20Dua%2C%20Benoa%2C%20South%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
