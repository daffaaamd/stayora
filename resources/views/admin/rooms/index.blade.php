@extends('layouts.admin')

@section('page_title', 'Rooms Management')

@section('content')
<div class="space-y-6">
    {{-- Top Action & Filter Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">All Resort Rooms</h2>
            <p class="text-xs text-charcoal-500">Manage room inventory, housekeeping statuses, and pricing.</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add New Room</span>
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search room # or name..."
                       class="form-input text-xs">
            </div>
            <div>
                <select name="room_type" class="form-select text-xs">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ request('room_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-select text-xs">
                    <option value="">All Housekeeping Statuses</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="cleaning" {{ request('status') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="out_of_service" {{ request('status') == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-secondary btn-sm flex-1 justify-center">Filter</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-outline btn-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Floor & Specs</th>
                        <th>Rate / Night</th>
                        <th>Status</th>
                        <th>Quick Status Update</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $room->primary_image_url }}" alt="" class="w-12 h-12 rounded-lg object-cover bg-charcoal-100 shrink-0">
                                    <div>
                                        <a href="{{ route('admin.rooms.show', $room) }}" class="font-bold text-charcoal-900 text-sm hover:text-gold-600 transition-colors">
                                            {{ $room->name }}
                                        </a>
                                        <span class="font-mono text-xs text-charcoal-400 block">Room #{{ $room->room_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-warm-100 text-charcoal-800 font-semibold">{{ $room->roomType->name }}</span>
                            </td>
                            <td class="text-xs text-charcoal-600">
                                <div>Floor {{ $room->floor }} · {{ $room->max_occupancy }} Guests</div>
                                <span class="text-charcoal-400 text-[11px]">{{ $room->bed_type ?? 'King Bed' }} · {{ $room->size_sqm }} m²</span>
                            </td>
                            <td class="font-semibold text-charcoal-900 text-xs">
                                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $room->status_badge_class }}">
                                    {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.rooms.update-status', $room) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded border-charcoal-200 py-1 pl-2 pr-6">
                                        <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="cleaning" {{ $room->status === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                        <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="reserved" {{ $room->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="out_of_service" {{ $room->status === 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="text-xs text-charcoal-600 hover:text-charcoal-900 font-medium">Edit</a>
                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Deactivate this room?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Deactivate</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-charcoal-400 text-xs">No rooms found matching filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $rooms->links() }}
        </div>
    </div>
</div>
@endsection
