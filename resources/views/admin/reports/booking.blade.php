@extends('layouts.admin')

@section('page_title', 'Booking Report (' . $dateFrom . ' to ' . $dateTo . ')')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
            <h2 class="font-display text-2xl font-bold text-charcoal-900">Reservation & Bookings Report</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reports.export-pdf', ['type' => 'booking', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
               class="btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export PDF</span>
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.reports.show', 'booking') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold text-charcoal-500 mb-1">From Date</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-charcoal-500 mb-1">To Date</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-charcoal-500 mb-1">Status</label>
                <select name="status" class="form-select text-xs">
                    <option value="">All Statuses</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn-secondary btn-sm w-full justify-center">Generate</button>
            </div>
        </form>
    </div>

    {{-- Summary KPIs --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="kpi-card">
            <span class="text-xs text-charcoal-500 font-semibold block">Total Bookings in Period</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-1">{{ $summary['total'] }}</p>
        </div>
        <div class="kpi-card">
            <span class="text-xs text-charcoal-500 font-semibold block">Total Gross Booking Revenue</span>
            <p class="font-display text-2xl font-bold text-gold-800 mt-1">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Created Date</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Stay Dates</th>
                        <th>Nights</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr>
                            <td class="font-mono text-xs font-bold">{{ $b->booking_number }}</td>
                            <td class="text-xs text-charcoal-500">{{ $b->created_at->format('d/m/Y') }}</td>
                            <td class="text-xs font-medium text-charcoal-900">{{ $b->guest_name }}</td>
                            <td class="text-xs">{{ $b->room->name }}</td>
                            <td class="text-xs">{{ $b->check_in->format('d M') }} — {{ $b->check_out->format('d M Y') }}</td>
                            <td class="text-xs text-center">{{ $b->nights }}</td>
                            <td class="text-xs font-bold text-charcoal-900">Rp {{ number_format($b->total, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $b->status_badge_class }} text-[10px]">{{ ucfirst($b->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-charcoal-400">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
