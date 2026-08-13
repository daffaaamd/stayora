@extends('layouts.admin')

@section('page_title', 'Finance — Payments & Transactions')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-bold text-charcoal-900">Payment Transactions Ledger</h2>
            <p class="text-xs text-charcoal-500">Comprehensive log of all guest reservation transactions, payment methods, and timestamps.</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.payments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Status</label>
                <select name="status" class="form-select text-xs">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Payment Method</label>
                <select name="method" class="form-select text-xs">
                    <option value="">All Methods</option>
                    <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="credit_card" {{ request('method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="e_wallet" {{ request('method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet / QRIS</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Pay at Hotel</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">From Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input text-xs">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-secondary btn-sm flex-1 justify-center">Filter</button>
                <a href="{{ route('admin.payments.index') }}" class="btn-outline btn-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Transaction Ref</th>
                        <th>Booking Ref</th>
                        <th>Customer</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Paid Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="font-mono text-xs font-bold text-charcoal-900">{{ $payment->transaction_id }}</td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="font-mono text-xs text-gold-700 hover:underline">
                                    {{ $payment->booking->booking_number }}
                                </a>
                            </td>
                            <td>
                                <div class="font-semibold text-charcoal-900 text-xs">{{ $payment->booking->guest_name }}</div>
                                <span class="text-[10px] text-charcoal-400">{{ $payment->booking->room->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warm-100 text-charcoal-800 text-[10px]">
                                    {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                </span>
                            </td>
                            <td class="font-bold text-charcoal-900 text-xs">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $payment->status_badge_class }} text-[10px]">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="text-xs text-charcoal-500">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-charcoal-400">No payment transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
