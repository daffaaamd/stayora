<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request) {
        $query = Review::with(['user', 'room.roomType', 'booking']);
        if ($request->filled('rating')) $query->where('rating', $request->rating);
        if ($request->filled('visible')) $query->where('is_visible', $request->visible);
        $reviews = $query->latest()->paginate(15)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleVisibility(Review $review) {
        $review->update(['is_visible' => !$review->is_visible, 'is_moderated' => true]);
        return back()->with('success', 'Review visibility toggled.');
    }

    public function destroy(Review $review) {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
