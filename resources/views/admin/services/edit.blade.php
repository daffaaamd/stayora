@extends('layouts.admin')

@section('page_title', 'Edit Service — ' . $service->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.services.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Services</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Edit {{ $service->name }}</h2>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="form-label">Service Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="form-input">
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Category <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="{{ old('category', $service->category) }}" required class="form-input">
                @error('category') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Price (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price', $service->price) }}" required min="0" step="10000" class="form-input">
                @error('price') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-textarea">{{ old('description', $service->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        @if($service->image)
            <div class="h-24 rounded-lg overflow-hidden border border-charcoal-200 w-36">
                <img src="{{ $service->image_url }}" alt="" class="w-full h-full object-cover">
            </div>
        @endif

        <div>
            <label class="form-label">Change Photo</label>
            <input type="file" name="image" accept="image/*" class="form-input">
        </div>

        <div>
            <label class="flex items-center gap-2 text-xs font-semibold text-charcoal-800 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                       class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                <span>Active Service</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.services.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Update Service</button>
        </div>
    </form>
</div>
@endsection
