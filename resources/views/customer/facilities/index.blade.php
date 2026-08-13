@extends('layouts.app')

@section('title', 'Resort Facilities — Stayora Resort Bali')
@section('meta_description', 'Discover world-class amenities at Stayora Resort Bali including infinity pools, signature dining, wellness spa, oceanfront yoga, fitness center, and complimentary Wi-Fi.')

@section('content')
<section class="bg-charcoal-900 text-white py-16 relative overflow-hidden">
    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1600&q=80"
         alt="Resort Facilities"
         class="absolute inset-0 w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-charcoal-900/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold mb-2 block">Stayora Experience</span>
        <h1 class="font-display text-4xl sm:text-5xl font-bold">Resort Facilities & Leisure</h1>
        <p class="text-warm-200 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            From rejuvenating spa treatments to beachfront infinity pools, our extensive facilities ensure an unforgettable retreat.
        </p>
    </div>
</section>

<section class="py-16 bg-warm-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-16">
            @foreach($facilities as $index => $facility)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center {{ $index % 2 === 1 ? 'lg:flex-row-reverse' : '' }}">
                    <div class="{{ $index % 2 === 1 ? 'lg:order-2' : '' }} rounded-2xl overflow-hidden shadow-lg h-80 sm:h-96">
                        <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="{{ $index % 2 === 1 ? 'lg:order-1' : '' }} space-y-4">
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-gold-600">0{{ $index + 1 }} · Facility</span>
                        <h2 class="font-display text-3xl font-bold text-charcoal-900">{{ $facility->name }}</h2>
                        <p class="text-charcoal-600 text-sm sm:text-base leading-relaxed">
                            {{ $facility->description }}
                        </p>
                        <div class="pt-4 flex items-center gap-6 text-xs text-charcoal-500 border-t border-charcoal-200">
                            <span class="flex items-center gap-1.5 font-medium text-charcoal-800">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Open Daily: 06:00 – 22:00
                            </span>
                            <span class="flex items-center gap-1.5 font-medium text-charcoal-800">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Complimentary for Guests
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
