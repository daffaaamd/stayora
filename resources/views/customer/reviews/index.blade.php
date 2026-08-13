@extends('layouts.app')

@section('title', 'My Reviews — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">My Reviews</h1>
            <p class="text-xs text-charcoal-500 mt-1">Feedback and ratings you've submitted for your stays at Stayora Resort.</p>
        </div>

        @if($reviews->isNotEmpty())
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-xl p-6 border border-charcoal-200 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-charcoal-100 pb-3">
                            <div>
                                <span class="badge bg-gold-100 text-gold-800 font-semibold">{{ $review->room->roomType->name }}</span>
                                <h3 class="font-display text-lg font-bold text-charcoal-900 mt-1">{{ $review->room->name }}</h3>
                                <p class="text-xs text-charcoal-400">Stayed on booking #{{ $review->booking->booking_number }} · {{ $review->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'fill-charcoal-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                                <span class="text-xs font-bold text-charcoal-900 ml-2">{{ $review->rating }}.0</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3 p-3 bg-warm-50 rounded-lg text-xs text-charcoal-600">
                            <div>
                                <span class="text-charcoal-400 block text-[10px] uppercase">Room Comfort</span>
                                <span class="font-bold text-charcoal-900">{{ $review->room_rating ?? $review->rating }}/5</span>
                            </div>
                            <div>
                                <span class="text-charcoal-400 block text-[10px] uppercase">Service</span>
                                <span class="font-bold text-charcoal-900">{{ $review->service_rating ?? $review->rating }}/5</span>
                            </div>
                            <div>
                                <span class="text-charcoal-400 block text-[10px] uppercase">Cleanliness</span>
                                <span class="font-bold text-charcoal-900">{{ $review->cleanliness_rating ?? $review->rating }}/5</span>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-charcoal-700 leading-relaxed italic">"{{ $review->comment }}"</p>
                    </div>
                @endforeach

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl p-12 text-center border border-charcoal-200 max-w-md mx-auto">
                <p class="text-xs text-charcoal-400">You haven't submitted any reviews yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
