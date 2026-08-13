@extends('layouts.admin')

@section('page_title', 'Occupancy Report')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Resort Occupancy Report</h2>
        <p class="text-xs text-charcoal-500">Total active room capacity: {{ $totalRooms }} rooms</p>
    </div>

    <div class="bg-white rounded-xl p-8 border border-charcoal-100 shadow-sm text-center">
        <p class="text-xs font-bold uppercase tracking-wider text-charcoal-400">Total Room Inventory Capacity</p>
        <p class="font-display text-5xl font-bold text-gold-700 mt-2">{{ $totalRooms }} Rooms</p>
        <p class="text-xs text-charcoal-500 mt-2">All rooms currently maintained in the central Stayora Resort inventory.</p>
    </div>
</div>
@endsection
