@extends('layouts.admin')

@section('page_title', 'Room Types')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Room Categories & Types</h2>
            <p class="text-xs text-charcoal-500">Configure room classes, base pricing tiers, and descriptions.</p>
        </div>
        <a href="{{ route('admin.room-types.create') }}" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add Room Type</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roomTypes as $type)
            <div class="bg-white rounded-xl overflow-hidden border border-charcoal-100 shadow-sm flex flex-col justify-between">
                <div class="h-48 overflow-hidden relative bg-charcoal-100">
                    <img src="{{ $type->image_url }}" alt="{{ $type->name }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="badge {{ $type->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-display text-xl font-bold text-charcoal-900 mb-2">{{ $type->name }}</h3>
                        <p class="text-xs text-charcoal-600 mb-4 line-clamp-3 leading-relaxed">{{ $type->description }}</p>

                        <div class="grid grid-cols-2 gap-2 py-3 border-y border-charcoal-100 text-xs text-charcoal-600 mb-4">
                            <div>
                                <span class="text-charcoal-400 block text-[10px] uppercase">Base Price</span>
                                <span class="font-bold text-charcoal-900">Rp {{ number_format($type->base_price, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-charcoal-400 block text-[10px] uppercase">Rooms Count</span>
                                <span class="font-bold text-charcoal-900">{{ $type->rooms_count }} Units</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('admin.room-types.edit', $type) }}" class="btn-outline btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
