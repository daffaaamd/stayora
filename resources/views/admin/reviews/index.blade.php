@extends('layouts.admin')

@section('page_title', 'Reviews & Feedback Moderation')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="font-display text-xl font-bold text-charcoal-900">Guest Reviews Moderation</h2>
        <p class="text-xs text-charcoal-500">Moderate guest feedback, publish reviews to public landing page, or remove spam.</p>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Overall Rating</th>
                        <th>Scores (R / S / C)</th>
                        <th>Comment</th>
                        <th>Visibility</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $review->user->name }}</div>
                                <span class="text-[10px] text-charcoal-400">{{ $review->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="text-xs">
                                <span class="font-medium text-charcoal-900">{{ $review->room->name }}</span>
                            </td>
                            <td>
                                <div class="flex items-center text-amber-400 text-xs font-bold">
                                    ★ {{ $review->rating }}.0
                                </div>
                            </td>
                            <td class="text-xs text-charcoal-500">
                                {{ $review->room_rating }}/5 · {{ $review->service_rating }}/5 · {{ $review->cleanliness_rating }}/5
                            </td>
                            <td class="text-xs text-charcoal-700 max-w-xs truncate italic">
                                "{{ $review->comment }}"
                            </td>
                            <td>
                                <span class="badge {{ $review->is_visible ? 'badge-success' : 'badge-secondary' }} text-[10px]">
                                    {{ $review->is_visible ? 'Visible on Site' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-xs {{ $review->is_visible ? 'text-amber-700 hover:text-amber-900' : 'text-emerald-700 hover:text-emerald-900' }} font-medium">
                                            {{ $review->is_visible ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-charcoal-400">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
