<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Revenue Report ({{ $dateFrom }} to {{ $dateTo }})</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #111; line-height: 1.4; padding: 15px; }
        .header { border-bottom: 2px solid #B8860B; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 18px; font-weight: bold; color: #B8860B; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #F5F5F5; border: 1px solid #DDD; padding: 6px 4px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { border: 1px solid #EEE; padding: 5px 4px; font-size: 10px; }
        .text-right { text-align: right; }
        .kpi { display: inline-block; padding: 8px 15px; background: #FAF8F5; border: 1px solid #EBD7B3; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Stayora Resort — Financial Revenue Statement</div>
        <div style="color: #666; font-size: 10px;">Reporting Window: {{ $dateFrom }} to {{ $dateTo }} · Generated on {{ now()->format('d M Y, H:i') }}</div>
    </div>

    <div style="margin-bottom: 15px;">
        <div class="kpi"><strong>Total Settled:</strong> Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
        <div class="kpi"><strong>Paid Transactions:</strong> {{ $summary['total_transactions'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Transaction Ref</th>
                <th>Paid Timestamp</th>
                <th>Method</th>
                <th>Booking #</th>
                <th class="text-right">Amount (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td style="font-family: monospace;">{{ $p->transaction_id }}</td>
                    <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : $p->created_at->format('d/m/Y') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $p->method)) }}</td>
                    <td style="font-family: monospace;">{{ $p->booking->booking_number }}</td>
                    <td class="text-right">{{ number_format($p->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
