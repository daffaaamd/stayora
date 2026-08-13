@extends('layouts.admin')

@section('page_title', 'Create Room Type')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.room-types.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Room Types</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Add New Room Category</h2>
    </div>

    <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="form-label">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="E.g. Presidential Ocean Villa" class="form-input">
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Base Price / Night (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="base_price" value="{{ old('base_price') }}" required min="0" step="50000" class="form-input">
                @error('base_price') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Max Default Occupancy <span class="text-red-500">*</span></label>
                <input type="number" name="max_occupancy" value="{{ old('max_occupancy', 2) }}" required min="1" class="form-input">
                @error('max_occupancy') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-textarea" placeholder="Overview of category features and amenities...">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Category Banner Image</label>
            <input type="file" name="image" accept="image/*" class="form-input">
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.room-types.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Save Room Type</button>
        </div>
    </form>
</div>
@endsection
