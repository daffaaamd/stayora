@extends('layouts.app')

@section('title', 'Write a Review — ' . $booking->room->name)

@section('content')
<div class="bg-warm-50 py-10 min-h-screen" x-data="{
    rating: 5,
    roomRating: 5,
    serviceRating: 5,
    cleanlinessRating: 5
}">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Top Nav --}}
        <a href="{{ route('customer.bookings.show', $booking) }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-4 inline-block">
            ← Back to Booking
        </a>

        <div class="bg-white rounded-2xl p-6 sm:p-10 border border-charcoal-200 shadow-sm">
            {{-- Header --}}
            <div class="text-center max-w-lg mx-auto mb-8">
                <span class="text-xs uppercase tracking-wider text-gold-600 font-semibold">Guest Experience</span>
                <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900 mt-1">Rate Your Stay</h1>
                <p class="text-xs text-charcoal-500 mt-2">
                    How was your experience at <strong>{{ $booking->room->name }}</strong>? Your review helps us continue delivering exceptional hospitality.
                </p>
            </div>

            <form action="{{ route('customer.reviews.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="rating" :value="rating">
                <input type="hidden" name="room_rating" :value="roomRating">
                <input type="hidden" name="service_rating" :value="serviceRating">
                <input type="hidden" name="cleanliness_rating" :value="cleanlinessRating">

                {{-- Star Ratings Grid --}}
                <div class="p-6 bg-warm-50 rounded-xl border border-charcoal-100 space-y-5">
                    {{-- 1. Overall Rating --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-700 mb-2">Overall Resort Experience <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <template x-for="star in 5" :key="star">
                                <button type="button" @click="rating = star" class="text-2xl transition-transform hover:scale-110 focus:outline-none">
                                    <span :class="star <= rating ? 'text-amber-400' : 'text-charcoal-200'">★</span>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-charcoal-700 ml-2" x-text="rating + ' / 5 Stars'"></span>
                        </div>
                    </div>

                    {{-- 2. Room Rating --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-700 mb-2">Room Comfort & Aesthetics <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <template x-for="star in 5" :key="star">
                                <button type="button" @click="roomRating = star" class="text-xl transition-transform hover:scale-110 focus:outline-none">
                                    <span :class="star <= roomRating ? 'text-amber-400' : 'text-charcoal-200'">★</span>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-charcoal-700 ml-2" x-text="roomRating + ' / 5'"></span>
                        </div>
                    </div>

                    {{-- 3. Service Rating --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-700 mb-2">Staff & Concierge Hospitality <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <template x-for="star in 5" :key="star">
                                <button type="button" @click="serviceRating = star" class="text-xl transition-transform hover:scale-110 focus:outline-none">
                                    <span :class="star <= serviceRating ? 'text-amber-400' : 'text-charcoal-200'">★</span>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-charcoal-700 ml-2" x-text="serviceRating + ' / 5'"></span>
                        </div>
                    </div>

                    {{-- 4. Cleanliness Rating --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-700 mb-2">Cleanliness & Hygiene <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <template x-for="star in 5" :key="star">
                                <button type="button" @click="cleanlinessRating = star" class="text-xl transition-transform hover:scale-110 focus:outline-none">
                                    <span :class="star <= cleanlinessRating ? 'text-amber-400' : 'text-charcoal-200'">★</span>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-charcoal-700 ml-2" x-text="cleanlinessRating + ' / 5'"></span>
                        </div>
                    </div>
                </div>

                {{-- Written Comment --}}
                <div>
                    <label class="form-label">Written Feedback</label>
                    <textarea name="comment" rows="4" required
                              placeholder="Tell us what you loved about your stay, your room, dining, or amenities..."
                              class="form-textarea">{{ old('comment') }}</textarea>
                    @error('comment') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn-outline btn-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
