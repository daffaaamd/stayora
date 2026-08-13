@extends('layouts.admin')

@section('page_title', 'Create Hotel Service')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.services.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Services</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Add New Service</h2>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="form-label">Service Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="E.g. Traditional Balinese Massage (90m)" class="form-input">
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Category <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="{{ old('category', 'Spa & Wellness') }}" required placeholder="E.g. Dining, Spa, Transport, Laundry" class="form-input">
                @error('category') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Price (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" required min="0" step="10000" class="form-input">
                @error('price') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-textarea" placeholder="Service description...">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Photo</label>
            <input type="file" name="image" accept="image/*" class="form-input">
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.services.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Save Service</button>
        </div>
    </form>
</div>
@endsection
