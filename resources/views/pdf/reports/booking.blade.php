<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Booking Report ({{ $dateFrom }} to {{ $dateTo }})</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #111; line-height: 1.4; padding: 15px; }
        .header { border-bottom: 2px solid #B8860B; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 18px; font-weight: bold; color: #B8860B; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #F5F5F5; border: 1px solid #DDD; padding: 6px 4px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { border: 1px solid #EEE; padding: 5px 4px; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .kpi { display: inline-block; padding: 8px 15px; background: #FAF8F5; border: 1px solid #EBD7B3; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Stayora Resort — Booking Report</div>
        <div style="color: #666; font-size: 10px;">Reporting Window: {{ $dateFrom }} to {{ $dateTo }} · Generated on {{ now()->format('d M Y, H:i') }}</div>
    </div>

    <div style="margin-bottom: 15px;">
        <div class="kpi"><strong>Total Reservations:</strong> {{ $summary['total'] }}</div>
        <div class="kpi"><strong>Gross Revenue:</strong> Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Booking #</th>
                <th>Guest</th>
                <th>Room</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th class="text-center">Nights</th>
                <th class="text-right">Total (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
                <tr>
                    <td style="font-family: monospace;">{{ $b->booking_number }}</td>
                    <td>{{ $b->guest_name }}</td>
                    <td>{{ $b->room->name }}</td>
                    <td>{{ $b->check_in->format('d/m/Y') }}</td>
                    <td>{{ $b->check_out->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $b->nights }}</td>
                    <td class="text-right">{{ number_format($b->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($b->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
