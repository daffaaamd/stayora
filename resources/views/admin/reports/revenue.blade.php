@extends('layouts.admin')

@section('page_title', 'Revenue Report (' . $dateFrom . ' to ' . $dateTo . ')')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">Financial Revenue Statement</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reports.export-pdf', ['type' => 'revenue', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
               class="btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export PDF</span>
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.reports.show', 'revenue') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold text-charcoal-500 mb-1">From Date</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-charcoal-500 mb-1">To Date</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-input text-xs">
            </div>
            <div>
                <button type="submit" class="btn-secondary btn-sm w-full justify-center">Generate Statement</button>
            </div>
        </form>
    </div>

    {{-- Summary KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="kpi-card border-l-4 border-l-emerald-500">
            <span class="text-xs text-charcoal-500 font-semibold block">Total Settled Revenue</span>
            <p class="font-display text-2xl font-bold text-emerald-800 mt-1">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="kpi-card border-l-4 border-l-gold-500">
            <span class="text-xs text-charcoal-500 font-semibold block">Total Paid Transactions</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">{{ $summary['total_transactions'] }}</p>
        </div>
        <div class="kpi-card">
            <span class="text-xs text-charcoal-500 font-semibold block">Avg Revenue per Transaction</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">
                Rp {{ number_format($summary['total_transactions'] > 0 ? $summary['total_revenue'] / $summary['total_transactions'] : 0, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Revenue Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Settled Date</th>
                        <th>Payment Method</th>
                        <th>Booking Ref</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td class="font-mono text-xs font-bold text-charcoal-900">{{ $p->transaction_id }}</td>
                            <td class="text-xs">{{ $p->paid_at ? $p->paid_at->format('d M Y, H:i') : $p->created_at->format('d M Y') }}</td>
                            <td><span class="badge bg-warm-100 text-charcoal-800 text-[10px]">{{ ucfirst(str_replace('_', ' ', $p->method)) }}</span></td>
                            <td class="font-mono text-xs">{{ $p->booking->booking_number }}</td>
                            <td class="text-xs font-bold text-charcoal-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-xs text-charcoal-400">No settled transactions in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
