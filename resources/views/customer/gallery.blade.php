@extends('layouts.app')

@section('title', 'Resort Gallery — Stayora Resort Bali')
@section('meta_description', 'Explore high-resolution photography of Stayora Resort Bali, featuring our private beach, luxury villas, restaurants, infinity pools, and tropical gardens.')

@section('content')
<section class="bg-charcoal-900 text-white py-16 relative overflow-hidden">
    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80"
         alt="Resort Gallery"
         class="absolute inset-0 w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-charcoal-900/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold mb-2 block">Visual Experience</span>
        <h1 class="font-display text-4xl sm:text-5xl font-bold">Resort Gallery</h1>
        <p class="text-warm-200 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            A glimpse into life at Stayora Resort — where timeless architecture meets coastal beauty.
        </p>
    </div>
</section>

<section class="py-12 bg-white" x-data="{
    activeCategory: 'all',
    modalOpen: false,
    modalImg: '',
    modalTitle: ''
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Filter Tabs --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-charcoal-900 text-white' : 'bg-warm-100 text-charcoal-700 hover:bg-warm-200'"
                    class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-colors">
                All Photos
            </button>
            @foreach($categories as $category)
                <button @click="activeCategory = '{{ $category }}'"
                        :class="activeCategory === '{{ $category }}' ? 'bg-charcoal-900 text-white' : 'bg-warm-100 text-charcoal-700 hover:bg-warm-200'"
                        class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-colors">
                    {{ ucfirst($category) }}
                </button>
            @endforeach
        </div>

        {{-- Photos Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($images as $image)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $image->category }}'"
                     x-transition
                     @click="modalImg = '{{ $image->image_url }}'; modalTitle = '{{ $image->title }}'; modalOpen = true"
                     class="group relative h-72 rounded-xl overflow-hidden shadow-sm hover:shadow-xl cursor-pointer bg-charcoal-100">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/80 via-charcoal-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-5 text-white">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gold-400 tracking-wider block">{{ $image->category }}</span>
                            <h4 class="font-display text-base font-bold">{{ $image->title }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div x-show="modalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-charcoal-900/90 backdrop-blur-sm modal-overlay"
         @keydown.escape.window="modalOpen = false">
        <div @click.away="modalOpen = false" class="relative max-w-4xl w-full max-h-[90vh] bg-black rounded-2xl overflow-hidden shadow-2xl modal-content">
            <button @click="modalOpen = false" class="absolute top-4 right-4 z-10 text-white/80 hover:text-white bg-black/50 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="modalImg" :alt="modalTitle" class="w-full h-auto max-h-[80vh] object-contain mx-auto">
            <div class="p-4 bg-charcoal-900 text-white text-center">
                <p class="font-display text-lg font-bold" x-text="modalTitle"></p>
            </div>
        </div>
    </div>
</section>
@endsection
