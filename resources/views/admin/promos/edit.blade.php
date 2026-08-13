@extends('layouts.admin')

@section('page_title', 'Edit Promo — ' . $promo->code)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.promos.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Promos</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Edit {{ $promo->code }}</h2>
    </div>

    <form action="{{ route('admin.promos.update', $promo) }}" method="POST" class="bg-white rounded-xl p-6 sm:p-8 border border-charcoal-100 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Promo Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $promo->code) }}" required class="form-input uppercase font-mono">
            </div>
            <div>
                <label class="form-label">Campaign Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $promo->name) }}" required class="form-input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Discount Type</label>
                <select name="discount_type" required class="form-select text-xs">
                    <option value="percentage" {{ $promo->discount_type === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ $promo->discount_type === 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                </select>
            </div>
            <div>
                <label class="form-label">Discount Value</label>
                <input type="number" name="discount_value" value="{{ old('discount_value', $promo->discount_value) }}" required min="1" class="form-input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}" required class="form-input text-xs">
            </div>
            <div>
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}" required class="form-input text-xs">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Minimum Booking (Rp)</label>
                <input type="number" name="min_booking" value="{{ old('min_booking', $promo->min_booking) }}" min="0" class="form-input">
            </div>
            <div>
                <label class="form-label">Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit', $promo->usage_limit) }}" min="1" class="form-input">
            </div>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="2" class="form-textarea">{{ old('description', $promo->description) }}</textarea>
        </div>

        <div>
            <label class="flex items-center gap-2 text-xs font-semibold text-charcoal-800 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}
                       class="rounded border-charcoal-300 text-gold-600 focus:ring-gold-500">
                <span>Active Promotion</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-charcoal-100">
            <a href="{{ route('admin.promos.index') }}" class="btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn-primary">Update Promo</button>
        </div>
    </form>
</div>
@endsection
