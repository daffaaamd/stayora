@extends('layouts.admin')

@section('page_title', 'Edit Room — ' . $room->room_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.rooms.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Rooms</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">Edit Room {{ $room->room_number }}</h2>
        </div>
    </div>

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Room Number <span class="text-red-500">*</span></label>
                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required class="form-input">
                @error('room_number') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Room Type <span class="text-red-500">*</span></label>
                <select name="room_type_id" required class="form-select">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('room_type_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Display Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $room->name) }}" required class="form-input">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Price per Night (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" required min="0" step="50000" class="form-input">
                @error('price_per_night') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Floor Number <span class="text-red-500">*</span></label>
                <input type="number" name="floor" value="{{ old('floor', $room->floor) }}" required min="1" class="form-input">
                @error('floor') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Max Occupancy <span class="text-red-500">*</span></label>
                <input type="number" name="max_occupancy" value="{{ old('max_occupancy', $room->max_occupancy) }}" required min="1" class="form-input">
                @error('max_occupancy') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Bed Type</label>
                <input type="text" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Room Size (m²)</label>
                <input type="number" name="size_sqm" value="{{ old('size_sqm', $room->size_sqm) }}" step="0.1" class="form-input">
            </div>

            <div class="sm:col-span-2">
                <label class="form-label">Scenic View</label>
                <input type="text" name="view_type" value="{{ old('view_type', $room->view_type) }}" class="form-input">
            </div>

            <div class="sm:col-span-2">
                <label class="form-label">Room Description</label>
                <textarea name="description" rows="4" class="form-textarea">{{ old('description', $room->description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-charcoal-800 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }}
                           class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                    <span>Active in inventory (available for guest booking search)</span>
                </label>
            </div>
        </div>

        {{-- Amenities --}}
        <div>
            <label class="form-label mb-2">Room Amenities</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-warm-50 rounded-xl border border-charcoal-100">
                @php $selectedAmenities = $room->amenities->pluck('id')->toArray(); @endphp
                @foreach($amenities as $amenity)
                    <label class="flex items-center gap-2 text-xs text-charcoal-700 cursor-pointer">
                        <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                               {{ in_array($amenity->id, $selectedAmenities) ? 'checked' : '' }}
                               class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                        <span>{{ $amenity->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Existing Images --}}
        @if($room->images->isNotEmpty())
            <div>
                <label class="form-label mb-2">Current Room Images</label>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($room->images as $img)
                        <div class="h-24 rounded-lg overflow-hidden border border-charcoal-200 relative">
                            <img src="{{ $img->image_url }}" alt="" class="w-full h-full object-cover">
                            @if($img->is_primary)
                                <span class="absolute top-1 left-1 badge badge-primary text-[9px]">Primary</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Add More Photos --}}
        <div>
            <label class="form-label">Upload Additional Photos</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-input">
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.rooms.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Update Room</button>
        </div>
    </form>
</div>
@endsection
