<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Facility;
use App\Models\GalleryImage;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::where('is_active', true)->orderBy('sort_order')->get();

        $featuredRooms = Room::with(['roomType', 'images', 'reviews'])
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $facilities = Facility::active()->get();

        $galleryImages = GalleryImage::active()->take(8)->get();

        $reviews = Review::with(['user', 'room.roomType'])
            ->visible()
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        return view('customer.home', compact(
            'roomTypes', 'featuredRooms', 'facilities', 'galleryImages', 'reviews'
        ));
    }
}
