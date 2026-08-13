@extends('layouts.admin')

@section('page_title', 'Customer CRM Report')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Customer Lifetime Value (LTV) Report</h2>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Bookings in Period</th>
                        <th>Total Spend in Period</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td class="font-semibold text-charcoal-900 text-xs">{{ $c->name }}</td>
                            <td class="text-xs text-charcoal-500">{{ $c->email }}</td>
                            <td class="text-xs font-bold">{{ $c->bookings_count }} Stays</td>
                            <td class="text-xs font-bold text-gold-800">
                                Rp {{ number_format($c->bookings_sum_total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-xs text-charcoal-400">No customer records in this date range.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
