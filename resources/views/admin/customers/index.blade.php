@extends('layouts.admin')

@section('page_title', 'Customer Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Registered Guest Directory</h2>
            <p class="text-xs text-charcoal-500">Customer profiles, lifetime revenue, and stay histories.</p>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name or email..." class="form-input text-xs max-w-md">
            <button type="submit" class="btn-secondary btn-sm">Search</button>
            <a href="{{ route('admin.customers.index') }}" class="btn-outline btn-sm">Reset</a>
        </form>
    </div>

    {{-- Customers Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Bookings</th>
                        <th>Lifetime Spending</th>
                        <th>Registered Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $customer->avatar_url }}" alt="" class="w-9 h-9 rounded-full object-cover shrink-0">
                                    <div>
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="font-bold text-charcoal-900 text-xs hover:text-gold-700">
                                            {{ $customer->name }}
                                        </a>
                                        <span class="text-[11px] text-charcoal-400 block">{{ $customer->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs text-charcoal-600">{{ $customer->phone ?? '—' }}</td>
                            <td class="text-xs font-semibold text-charcoal-900">{{ $customer->bookings_count }} Stays</td>
                            <td class="text-xs font-bold text-gold-800">
                                Rp {{ number_format($customer->bookings_sum_total ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-xs text-charcoal-500">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn-outline btn-sm py-1 px-2.5 text-xs">
                                    CRM Profile →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-xs text-charcoal-400">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
