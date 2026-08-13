@extends('layouts.admin')

@section('page_title', 'Payment Gateway Report')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Payment Channel Settlement Statement</h2>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Booking</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td class="font-mono text-xs font-bold">{{ $p->transaction_id }}</td>
                            <td class="text-xs">{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td><span class="badge bg-warm-100 text-charcoal-800 text-[10px]">{{ ucfirst(str_replace('_', ' ', $p->method)) }}</span></td>
                            <td class="font-mono text-xs">{{ $p->booking->booking_number }}</td>
                            <td class="text-xs font-bold">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $p->status_badge_class }} text-[10px]">{{ ucfirst($p->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-xs text-charcoal-400">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
