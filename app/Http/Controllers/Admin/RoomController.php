<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['roomType', 'images']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('room_type')) {
            $query->where('room_type_id', $request->room_type);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('room_number', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        $rooms = $query->orderBy('room_number')->paginate(15)->withQueryString();
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::all();
        return view('admin.rooms.create', compact('roomTypes', 'amenities'));
    }

    public function store(Request $request, AuditService $auditService)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'name' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'size_sqm' => 'nullable|numeric|min:0',
            'view_type' => 'nullable|string|max:100',
            'bed_type' => 'nullable|string|max:100',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['room_number']);

        $room = Room::create($validated);

        // Attach amenities
        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('rooms', 'public');
                $room->images()->create([
                    'image_path' => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        $auditService->log('created', $room, null, $room->toArray());

        return redirect()->route('admin.rooms.index')
            ->with('success', "Room {$room->room_number} created successfully.");
    }

    public function show(Room $room)
    {
        $room->load(['roomType', 'images', 'amenities', 'bookings' => fn($q) => $q->latest()->take(10), 'reviews']);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $room->load(['amenities', 'images']);
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes', 'amenities'));
    }

    public function update(Request $request, Room $room, AuditService $auditService)
    {
        $oldData = $room->toArray();

        $validated = $request->validate([
            'room_number' => "required|string|max:10|unique:rooms,room_number,{$room->id}",
            'room_type_id' => 'required|exists:room_types,id',
            'name' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'size_sqm' => 'nullable|numeric|min:0',
            'view_type' => 'nullable|string|max:100',
            'bed_type' => 'nullable|string|max:100',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['room_number']);
        $validated['is_active'] = $request->boolean('is_active');

        $room->update($validated);

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        if ($request->hasFile('images')) {
            $lastSort = $room->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('rooms', 'public');
                $room->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $lastSort + $i + 1,
                ]);
            }
        }

        $auditService->log('updated', $room, $oldData, $room->fresh()->toArray());

        return redirect()->route('admin.rooms.index')
            ->with('success', "Room {$room->room_number} updated.");
    }

    public function destroy(Room $room, AuditService $auditService)
    {
        $auditService->log('deleted', $room, $room->toArray(), null);
        $room->update(['is_active' => false]);

        return redirect()->route('admin.rooms.index')
            ->with('success', "Room {$room->room_number} deactivated.");
    }

    public function updateStatus(Request $request, Room $room, AuditService $auditService)
    {
        $request->validate(['status' => 'required|in:available,reserved,occupied,cleaning,maintenance,out_of_service']);
        $oldStatus = $room->status;
        $room->update(['status' => $request->status]);
        $auditService->log('status_updated', $room, ['status' => $oldStatus], ['status' => $request->status]);

        return back()->with('success', "Room status updated to {$request->status}.");
    }
}
