@extends('layouts.admin')

@section('page_title', 'Operational & Financial Reports')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Reports & Business Intelligence</h2>
        <p class="text-xs text-charcoal-500">Generate, analyze, and export comprehensive operational and financial statements.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- 1. Booking Report --}}
        <a href="{{ route('admin.reports.show', 'booking') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-gold-50 text-gold-700 flex items-center justify-center mb-4 group-hover:bg-gold-500 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Booking Report</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Detailed statement of all room bookings, statuses, and stay volumes by date range.</p>
            <span class="text-xs font-semibold text-gold-700 mt-4 block">Generate Report →</span>
        </a>

        {{-- 2. Revenue Report --}}
        <a href="{{ route('admin.reports.show', 'revenue') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Revenue Report</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Financial revenue ledger filtered by payment channel, tax, service, and net revenue.</p>
            <span class="text-xs font-semibold text-emerald-700 mt-4 block">Generate Report →</span>
        </a>

        {{-- 3. Room Performance --}}
        <a href="{{ route('admin.reports.show', 'room-performance') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Room Performance</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Utilization rankings, ADR (Average Daily Rate), and gross yield per room.</p>
            <span class="text-xs font-semibold text-sky-700 mt-4 block">Generate Report →</span>
        </a>

        {{-- 4. Customer CRM Report --}}
        <a href="{{ route('admin.reports.show', 'customer') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Customer CRM Report</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Top guests, repeat booking frequency, and lifetime customer value (LTV).</p>
            <span class="text-xs font-semibold text-amber-700 mt-4 block">Generate Report →</span>
        </a>

        {{-- 5. Service & Orders Report --}}
        <a href="{{ route('admin.reports.show', 'service') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Services & Extras</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Breakdown of dining, spa, airport transfer, and ancillary revenue streams.</p>
            <span class="text-xs font-semibold text-indigo-700 mt-4 block">Generate Report →</span>
        </a>

        {{-- 6. Payment Channel Report --}}
        <a href="{{ route('admin.reports.show', 'payment') }}" class="bg-white p-6 rounded-xl border border-charcoal-100 shadow-sm hover:shadow-md hover:border-gold-300 transition-all group">
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 002.25 19.5z"/></svg>
            </div>
            <h3 class="font-display text-lg font-bold text-charcoal-900 mb-1">Payment Channel Report</h3>
            <p class="text-xs text-charcoal-500 leading-relaxed">Payment gateway volume, success rate, and method distribution.</p>
            <span class="text-xs font-semibold text-teal-700 mt-4 block">Generate Report →</span>
        </a>
    </div>
</div>
@endsection
