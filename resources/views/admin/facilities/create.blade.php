@extends('layouts.admin')

@section('page_title', 'Create Facility')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.facilities.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Facilities</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Add New Facility</h2>
    </div>

    <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf
        <div>
            <label class="form-label">Facility Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-textarea">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Facility Photo</label>
            <input type="file" name="image" accept="image/*" class="form-input">
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.facilities.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Save Facility</button>
        </div>
    </form>
</div>
@endsection
