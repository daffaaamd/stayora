@extends('layouts.admin')

@section('page_title', 'Services Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Hotel & Room Services</h2>
            <p class="text-xs text-charcoal-500">Manage dining, spa, tours, and in-room add-ons available for guest billing.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add Service</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Price (Rp)</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $service->image_url }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-charcoal-100 shrink-0">
                                    <div>
                                        <h4 class="font-bold text-charcoal-900 text-xs">{{ $service->name }}</h4>
                                        <p class="text-[11px] text-charcoal-500 line-clamp-1">{{ $service->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-warm-100 text-charcoal-800 text-[10px]">{{ $service->category ?? 'General' }}</span></td>
                            <td class="font-bold text-charcoal-900 text-xs">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $service->is_active ? 'badge-success' : 'badge-danger' }} text-[10px]">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn-outline btn-sm py-1 px-2.5 text-xs">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-xs text-charcoal-400">No services configured.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
