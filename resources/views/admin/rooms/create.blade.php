@extends('layouts.admin')

@section('page_title', 'Create New Room')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.rooms.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Rooms</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">Add Room to Inventory</h2>
        </div>
    </div>

    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Room Number <span class="text-red-500">*</span></label>
                <input type="text" name="room_number" value="{{ old('room_number') }}" required placeholder="E.g. 101, 201, V-01" class="form-input">
                @error('room_number') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Room Type <span class="text-red-500">*</span></label>
                <select name="room_type_id" required class="form-select">
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }} (Base: Rp {{ number_format($type->base_price, 0, ',', '.') }})</option>
                    @endforeach
                </select>
                @error('room_type_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Display Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="E.g. Deluxe Ocean View Suite 101" class="form-input">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Price per Night (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" required min="0" step="50000" placeholder="E.g. 1500000" class="form-input">
                @error('price_per_night') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Floor Number <span class="text-red-500">*</span></label>
                <input type="number" name="floor" value="{{ old('floor', 1) }}" required min="1" class="form-input">
                @error('floor') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Max Occupancy (Guests) <span class="text-red-500">*</span></label>
                <input type="number" name="max_occupancy" value="{{ old('max_occupancy', 2) }}" required min="1" max="20" class="form-input">
                @error('max_occupancy') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Bed Type</label>
                <input type="text" name="bed_type" value="{{ old('bed_type', '1 King Bed') }}" placeholder="E.g. 1 King Bed, 2 Twin Beds" class="form-input">
                @error('bed_type') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Room Size (m²)</label>
                <input type="number" name="size_sqm" value="{{ old('size_sqm', 45) }}" step="0.1" class="form-input">
                @error('size_sqm') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="form-label">Scenic View</label>
                <input type="text" name="view_type" value="{{ old('view_type', 'Ocean & Tropical Garden View') }}" placeholder="E.g. Direct Ocean View, Garden View, Pool Access" class="form-input">
                @error('view_type') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="form-label">Room Description</label>
                <textarea name="description" rows="4" class="form-textarea" placeholder="Detailed description of room decor, view, atmosphere...">{{ old('description') }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Amenities Checkboxes --}}
        <div>
            <label class="form-label mb-2">Room Amenities</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-warm-50 rounded-xl border border-charcoal-100">
                @foreach($amenities as $amenity)
                    <label class="flex items-center gap-2 text-xs text-charcoal-700 cursor-pointer">
                        <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                               class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                        <span>{{ $amenity->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Photos Upload --}}
        <div>
            <label class="form-label">Room Photos</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-input">
            <p class="text-[11px] text-charcoal-400 mt-1">Upload multiple photos (JPG, PNG, WebP up to 2MB each). First image will be used as primary thumbnail.</p>
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.rooms.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Save & Publish Room</button>
        </div>
    </form>
</div>
@endsection
