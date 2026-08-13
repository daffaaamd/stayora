@extends('layouts.admin')

@section('page_title', 'Services & Ancillary Revenue Report')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="text-xs text-charcoal-500 hover:text-charcoal-900 mb-1 inline-block">← Back to Reports</a>
        <h2 class="font-display text-2xl font-bold text-charcoal-900">Hotel Services & Ancillary Revenue</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($byService as $svc)
            <div class="bg-white rounded-xl p-5 border border-charcoal-100 shadow-sm flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-charcoal-900 text-sm">{{ $svc['name'] }}</h4>
                    <span class="text-xs text-charcoal-500">{{ $svc['count'] }} orders fulfilled</span>
                </div>
                <div class="text-right">
                    <span class="font-bold text-gold-800 text-base">Rp {{ number_format($svc['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
