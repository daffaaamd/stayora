@extends('layouts.admin')

@section('page_title', 'Management Overview')

@section('content')
<div class="space-y-8" x-data="adminDashboard({
    monthlyRevenue: {{ json_encode($monthlyRevenue) }},
    monthlyBookings: {{ json_encode($monthlyBookings) }},
    revenueByRoomType: {{ json_encode($revenueByRoomType) }}
})">
    {{-- KPI Cards Row 1: Rooms & Operations --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Occupancy Today --}}
        <div class="kpi-card border-l-4 border-l-gold-500">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Occupancy Rate</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-display text-3xl font-bold text-charcoal-900">{{ $occupancy['rate'] }}%</span>
                <span class="text-xs font-medium text-emerald-600">Today</span>
            </div>
            <p class="text-xs text-charcoal-500 mt-2">{{ $occupancy['occupied'] }} of {{ $occupancy['total_active'] }} rooms occupied</p>
        </div>

        {{-- Available Rooms --}}
        <div class="kpi-card border-l-4 border-l-emerald-500">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Available Rooms</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-display text-3xl font-bold text-charcoal-900">{{ $occupancy['available'] }}</span>
                <span class="text-xs text-charcoal-500">Total: {{ $occupancy['total_rooms'] }}</span>
            </div>
            <p class="text-xs text-charcoal-500 mt-2">{{ $occupancy['cleaning'] + $occupancy['maintenance'] }} in cleaning/maintenance</p>
        </div>

        {{-- Today's Check-ins --}}
        <div class="kpi-card border-l-4 border-l-sky-500">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Today's Check-ins</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-display text-3xl font-bold text-charcoal-900">{{ $bookingStats['today_checkins'] }}</span>
                <a href="{{ route('admin.checkin.index') }}" class="text-xs text-sky-600 hover:underline">Front Desk →</a>
            </div>
            <p class="text-xs text-charcoal-500 mt-2">Expected arrivals</p>
        </div>

        {{-- Today's Check-outs --}}
        <div class="kpi-card border-l-4 border-l-amber-500">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Today's Check-outs</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-display text-3xl font-bold text-charcoal-900">{{ $bookingStats['today_checkouts'] }}</span>
                <a href="{{ route('admin.checkout.index') }}" class="text-xs text-amber-600 hover:underline">Folio Settle →</a>
            </div>
            <p class="text-xs text-charcoal-500 mt-2">Scheduled departures</p>
        </div>
    </div>

    {{-- KPI Cards Row 2: Financials & Bookings --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Monthly Revenue</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-2">Rp {{ number_format($revenue['monthly'], 0, ',', '.') }}</p>
            <span class="text-xs text-charcoal-500 mt-1 block">{{ now()->format('F Y') }}</span>
        </div>

        <div class="kpi-card">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Yearly Revenue</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-2">Rp {{ number_format($revenue['yearly'], 0, ',', '.') }}</p>
            <span class="text-xs text-charcoal-500 mt-1 block">YTD {{ now()->year }}</span>
        </div>

        <div class="kpi-card">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Total Active Bookings</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-2">{{ $bookingStats['confirmed'] + $bookingStats['checked_in'] }}</p>
            <span class="text-xs text-charcoal-500 mt-1 block">{{ $bookingStats['checked_in'] }} currently in-house</span>
        </div>

        <div class="kpi-card">
            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal-400 block">Pending Payments</span>
            <p class="font-display text-2xl font-bold text-charcoal-900 mt-2">{{ $bookingStats['pending_payment'] }}</p>
            <a href="{{ route('admin.bookings.index', ['status' => 'pending_payment']) }}" class="text-xs text-gold-600 hover:underline mt-1 block">Review bookings →</a>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Revenue & Booking Trends (2 cols) --}}
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-display text-lg font-bold text-charcoal-900">Monthly Revenue & Booking Trends</h3>
                    <p class="text-xs text-charcoal-500">Gross revenue and confirmed reservations for {{ now()->year }}</p>
                </div>
            </div>
            <div class="h-72">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Revenue by Room Type (1 col) --}}
        <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4">
            <div>
                <h3 class="font-display text-lg font-bold text-charcoal-900">Revenue by Room Type</h3>
                <p class="text-xs text-charcoal-500">Distribution across accommodation categories</p>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="roomTypeChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Performance & Recent Bookings Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Top Performing Rooms (1 col) --}}
        <div class="bg-white rounded-xl p-6 border border-charcoal-100 shadow-sm space-y-4">
            <h3 class="font-display text-lg font-bold text-charcoal-900">Top Performing Rooms</h3>
            <div class="space-y-3">
                @foreach($topRooms as $top)
                    <div class="flex items-center justify-between p-3 bg-warm-50 rounded-lg text-xs">
                        <div>
                            <p class="font-bold text-charcoal-900">{{ $top->name }}</p>
                            <span class="text-charcoal-500">Room {{ $top->room_number }} · {{ $top->roomType->name }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-gold-800">{{ $top->bookings_count }} stays</span>
                            <span class="block text-[10px] text-charcoal-400">Rp {{ number_format($top->price_per_night, 0, ',', '.') }}/nt</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Bookings Table (2 cols) --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-charcoal-100 flex items-center justify-between">
                    <h3 class="font-display text-lg font-bold text-charcoal-900">Recent Reservations</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs text-gold-700 hover:text-gold-800 font-semibold">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Booking Ref</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Check-in</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                                <tr>
                                    <td class="font-mono text-xs font-semibold text-charcoal-900">{{ $booking->booking_number }}</td>
                                    <td>
                                        <div class="font-medium text-charcoal-900 text-xs">{{ $booking->guest_name }}</div>
                                        <span class="text-[10px] text-charcoal-400">{{ $booking->guest_phone ?? $booking->guest_email }}</span>
                                    </td>
                                    <td>
                                        <span class="text-xs text-charcoal-900">Room {{ $booking->room->room_number }}</span>
                                    </td>
                                    <td class="text-xs">{{ $booking->check_in->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-xs text-gold-600 hover:text-gold-800 font-medium">Manage →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
function adminDashboard(config) {
    return {
        init() {
            // 1. Revenue & Bookings Line/Bar Chart
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            // Extract numeric values from array of objects or primitives
            const revenueData = Array.isArray(config.monthlyRevenue)
                ? config.monthlyRevenue.map(item => typeof item === 'object' && item !== null ? Math.round((item.amount || 0) / 1000000) : Math.round((item || 0) / 1000000))
                : Object.values(config.monthlyRevenue || {}).map(v => Math.round((v || 0) / 1000000));

            const bookingData = Array.isArray(config.monthlyBookings)
                ? config.monthlyBookings.map(item => typeof item === 'object' && item !== null ? (item.count || 0) : (item || 0))
                : Object.values(config.monthlyBookings || {});

            const ctxRev = document.getElementById('revenueChart');
            if (ctxRev) {
                new Chart(ctxRev, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Revenue (Rp in Millions)',
                                data: revenueData,
                                backgroundColor: 'rgba(197, 168, 128, 0.85)',
                                hoverBackgroundColor: 'rgba(184, 134, 11, 1)',
                                borderColor: '#C5A880',
                                borderWidth: 1,
                                borderRadius: 4,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Bookings Count',
                                data: bookingData,
                                type: 'line',
                                borderColor: '#1A1A1A',
                                backgroundColor: '#1A1A1A',
                                pointBackgroundColor: '#C5A880',
                                pointBorderColor: '#1A1A1A',
                                pointRadius: 4,
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.dataset.yAxisID === 'y') {
                                            return 'Revenue: Rp ' + context.raw + ' Million';
                                        }
                                        return 'Bookings: ' + context.raw + ' Reservations';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                title: { display: true, text: 'Revenue (Million Rp)', font: { size: 10, weight: 'bold' } }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                grid: { drawOnChartArea: false },
                                title: { display: true, text: 'Bookings Count', font: { size: 10, weight: 'bold' } }
                            }
                        }
                    }
                });
            }

            // 2. Revenue by Room Type Doughnut Chart
            const ctxType = document.getElementById('roomTypeChart');
            if (ctxType) {
                let types = [];
                let typeValues = [];

                if (Array.isArray(config.revenueByRoomType)) {
                    types = config.revenueByRoomType.map(r => r.name || 'Category');
                    typeValues = config.revenueByRoomType.map(r => parseFloat(r.total || 0));
                } else if (typeof config.revenueByRoomType === 'object' && config.revenueByRoomType !== null) {
                    types = Object.keys(config.revenueByRoomType);
                    typeValues = Object.values(config.revenueByRoomType).map(v => parseFloat(v || 0));
                }

                if (!types.length) {
                    types = ['Deluxe Suite', 'Executive Ocean', 'Family Grand', 'Presidential Villa'];
                    typeValues = [35, 25, 20, 20];
                }

                new Chart(ctxType, {
                    type: 'doughnut',
                    data: {
                        labels: types,
                        datasets: [{
                            data: typeValues,
                            backgroundColor: [
                                '#C5A880',
                                '#1A1A1A',
                                '#8C7355',
                                '#3D3D3D',
                                '#E5D5BA',
                                '#5A5A5A'
                            ],
                            borderWidth: 2,
                            borderColor: '#FFFFFF'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 12,
                                    font: { size: 11 }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const val = context.raw;
                                        return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    };
}
</script>
@endpush
@endsection
