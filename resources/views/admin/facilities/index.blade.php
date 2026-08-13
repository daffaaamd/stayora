@extends('layouts.admin')

@section('page_title', 'Facilities Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Resort Facilities & Amenities</h2>
            <p class="text-xs text-charcoal-500">Manage leisure spots, pools, dining venues, and guest features.</p>
        </div>
        <a href="{{ route('admin.facilities.create') }}" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add Facility</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($facilities as $facility)
            <div class="bg-white rounded-xl overflow-hidden border border-charcoal-100 shadow-sm flex flex-col justify-between">
                <div class="h-44 overflow-hidden relative bg-charcoal-100">
                    <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="badge {{ $facility->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $facility->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">{{ $facility->name }}</h3>
                        <p class="text-xs text-charcoal-600 line-clamp-3 leading-relaxed">{{ $facility->description }}</p>
                    </div>
                    <div class="pt-4 flex items-center justify-end gap-2 border-t border-charcoal-100 mt-4">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn-outline btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
