@extends('layouts.admin')

@section('page_title', 'Edit Facility — ' . $facility->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.facilities.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Facilities</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Edit {{ $facility->name }}</h2>
    </div>

    <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="form-label">Facility Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $facility->name) }}" required class="form-input">
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-textarea">{{ old('description', $facility->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        @if($facility->image)
            <div class="h-32 rounded-lg overflow-hidden border border-charcoal-200 w-48">
                <img src="{{ $facility->image_url }}" alt="" class="w-full h-full object-cover">
            </div>
        @endif

        <div>
            <label class="form-label">Change Photo</label>
            <input type="file" name="image" accept="image/*" class="form-input">
        </div>

        <div>
            <label class="flex items-center gap-2 text-xs font-semibold text-charcoal-800 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $facility->is_active) ? 'checked' : '' }}
                       class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                <span>Active Facility</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.facilities.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Update Facility</button>
        </div>
    </form>
</div>
@endsection
