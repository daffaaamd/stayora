@extends('layouts.admin')

@section('page_title', 'Promotions & Promo Codes')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Promo Codes & Discounts</h2>
            <p class="text-xs text-charcoal-500">Create and manage marketing coupon codes with validity windows and usage limits.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Create Promo</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Discount</th>
                        <th>Validity Period</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $promo)
                        <tr>
                            <td>
                                <span class="font-mono text-xs font-bold text-gold-800 bg-gold-50 px-2 py-1 rounded">
                                    {{ $promo->code }}
                                </span>
                            </td>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $promo->name }}</div>
                                <span class="text-[11px] text-charcoal-500">{{ $promo->description }}</span>
                            </td>
                            <td class="text-xs font-bold text-charcoal-900">
                                @if($promo->discount_type === 'percentage')
                                    {{ $promo->discount_value }}% OFF
                                @else
                                    Rp {{ number_format($promo->discount_value, 0, ',', '.') }} Fixed
                                @endif
                            </td>
                            <td class="text-xs text-charcoal-600">
                                {{ $promo->start_date->format('d M Y') }} — {{ $promo->end_date->format('d M Y') }}
                            </td>
                            <td class="text-xs">{{ $promo->times_used }} / {{ $promo->usage_limit ?? '∞' }}</td>
                            <td>
                                <span class="badge {{ $promo->is_active ? 'badge-success' : 'badge-danger' }} text-[10px]">
                                    {{ $promo->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="text-xs text-charcoal-600 hover:text-charcoal-900 font-medium">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-charcoal-400">No promo codes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $promos->links() }}
        </div>
    </div>
</div>
@endsection
