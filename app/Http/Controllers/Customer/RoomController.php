<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index(Request $request)
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        $query = Room::with(['roomType', 'images', 'amenities', 'reviews'])
            ->where('is_active', true);

        // Search by availability
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $guests = $request->input('guests');
        $roomTypeId = $request->input('room_type');
        $hasSearch = $checkIn && $checkOut;

        if ($hasSearch) {
            $query = $this->availabilityService->getAvailableRooms($checkIn, $checkOut, $guests, $roomTypeId);
        } else {
            if ($roomTypeId) {
                $query->where('room_type_id', $roomTypeId);
            }
            if ($guests) {
                $query->where('max_occupancy', '>=', $guests);
            }
        }

        // Filters
        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->input('max_price'));
        }
        if ($request->filled('bed_type')) {
            $query->where('bed_type', $request->input('bed_type'));
        }

        // Sorting
        $sort = $request->input('sort', 'price_asc');
        switch ($sort) {
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'rating':
                $query->withAvg(['reviews' => fn($q) => $q->where('is_visible', true)], 'rating')
                      ->orderByDesc('reviews_avg_rating');
                break;
            case 'popular':
                $query->withCount('bookings')->orderByDesc('bookings_count');
                break;
            default:
                $query->orderBy('price_per_night', 'asc');
        }

        $rooms = $query->paginate(12)->withQueryString();

        return view('customer.rooms.index', compact('rooms', 'roomTypes', 'checkIn', 'checkOut', 'guests', 'sort', 'hasSearch'));
    }

    public function show(string $slug)
    {
        $room = Room::with(['roomType', 'images', 'amenities', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedRooms = Room::with(['roomType', 'images'])
            ->where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('customer.rooms.show', compact('room', 'relatedRooms'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $available = $this->availabilityService->isRoomAvailable(
            $request->input('room_id'),
            $request->input('check_in'),
            $request->input('check_out')
        );

        $room = Room::find($request->input('room_id'));
        $checkIn = \Carbon\Carbon::parse($request->input('check_in'));
        $checkOut = \Carbon\Carbon::parse($request->input('check_out'));
        $nights = $checkIn->diffInDays($checkOut);
        $total = $room->price_per_night * $nights;

        return response()->json([
            'available' => $available,
            'nights' => $nights,
            'price_per_night' => $room->price_per_night,
            'total' => $total,
        ]);
    }
}
