<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Booking Voucher — {{ $booking->booking_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1A1A1A;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.5;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #B8860B;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1A1A1A;
            letter-spacing: -0.5px;
        }
        .logo span {
            color: #B8860B;
            font-size: 16px;
        }
        .voucher-title {
            text-align: right;
        }
        .voucher-title h2 {
            margin: 0;
            font-size: 18px;
            color: #B8860B;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .voucher-title p {
            margin: 2px 0 0;
            font-family: monospace;
            font-size: 12px;
            color: #666;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1A1A1A;
            border-bottom: 1px solid #E5E5E5;
            padding-bottom: 4px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .label {
            color: #777;
            font-size: 11px;
            text-transform: uppercase;
            width: 30%;
        }
        .val {
            font-weight: 600;
            color: #111;
        }
        .box {
            background-color: #FBF7EF;
            border: 1px solid #EBD7B3;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 15px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #F5F5F5;
            border-bottom: 1px solid #CCC;
            padding: 8px;
            font-size: 11px;
            text-align: left;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #EEE;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            font-size: 13px;
            background-color: #FAF8F5;
        }
        .total-amount {
            color: #B8860B;
            font-size: 15px;
        }
        .terms {
            font-size: 10px;
            color: #666;
            margin-top: 25px;
            border-top: 1px solid #E5E5E5;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #D1FAE5;
            color: #065F46;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td>
                <div class="logo">Stayora <span>Resort</span></div>
                <div style="font-size: 10px; color: #666; margin-top: 3px;">
                    Jl. Pantai Indah No. 88, Nusa Dua, Bali, Indonesia 80363<br>
                    Tel: +62 361 770 888 · Email: reservations@stayora.test
                </div>
            </td>
            <td class="voucher-title">
                <h2>Booking Voucher</h2>
                <p>CONFIRMATION #{{ $booking->booking_number }}</p>
                <div style="margin-top: 6px;">
                    <span class="badge">CONFIRMED RESERVATION</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Highlight Box --}}
    <div class="box">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <div style="font-size: 10px; color: #7B5A08; text-transform: uppercase; font-weight: bold;">Check-In Date</div>
                    <div style="font-size: 14px; font-weight: bold; color: #3E2D04; margin-top: 2px;">
                        {{ $booking->check_in->format('l, d F Y') }}
                    </div>
                    <div style="font-size: 11px; color: #7B5A08;">From 14:00 WITA</div>
                </td>
                <td style="width: 50%;">
                    <div style="font-size: 10px; color: #7B5A08; text-transform: uppercase; font-weight: bold;">Check-Out Date</div>
                    <div style="font-size: 14px; font-weight: bold; color: #3E2D04; margin-top: 2px;">
                        {{ $booking->check_out->format('l, d F Y') }}
                    </div>
                    <div style="font-size: 11px; color: #7B5A08;">Until 12:00 WITA</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Guest & Room Details --}}
    <table style="width: 100%;" class="info-table">
        <tr>
            <td style="width: 50%; padding-right: 15px;">
                <div class="section-title">Guest Information</div>
                <table style="width: 100%;">
                    <tr>
                        <td class="label">Lead Guest:</td>
                        <td class="val">{{ $booking->guest_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td>
                        <td class="val">{{ $booking->guest_email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Phone:</td>
                        <td class="val">{{ $booking->guest_phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total Guests:</td>
                        <td class="val">{{ $booking->guests }} Person(s)</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 15px;">
                <div class="section-title">Accommodation Details</div>
                <table style="width: 100%;">
                    <tr>
                        <td class="label">Room:</td>
                        <td class="val">{{ $booking->room->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Room Number:</td>
                        <td class="val">Room {{ $booking->room->room_number }} (Floor {{ $booking->room->floor }})</td>
                    </tr>
                    <tr>
                        <td class="label">Room Category:</td>
                        <td class="val">{{ $booking->room->roomType->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Duration:</td>
                        <td class="val">{{ $booking->nights }} Night(s)</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Payment Breakdown --}}
    <div class="section-title">Payment & Financial Summary</div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Nights</th>
                <th class="text-right">Rate / Night</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->room->name }} (Room #{{ $booking->room->room_number }})</td>
                <td class="text-center">{{ $booking->nights }}</td>
                <td class="text-right">Rp {{ number_format($booking->room->price_per_night, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</td>
            </tr>
            @if($booking->discount > 0)
                <tr style="color: #065F46;">
                    <td colspan="3">Promo Discount (Code: {{ $booking->promo_code }})</td>
                    <td class="text-right">- Rp {{ number_format($booking->discount, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="3" style="color: #666;">Government Tax (10%)</td>
                <td class="text-right">Rp {{ number_format($booking->tax, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="color: #666;">Service Charge (5%)</td>
                <td class="text-right">Rp {{ number_format($booking->service_charge, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Grand Total Paid</td>
                <td class="text-right total-amount">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if($booking->payment)
        <table style="width: 100%; font-size: 11px; margin-top: -10px; margin-bottom: 15px;">
            <tr>
                <td style="color: #666;">
                    Paid via <strong>{{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</strong> ·
                    Transaction ID: <span style="font-family: monospace;">{{ $booking->payment->transaction_id }}</span> ·
                    Paid at: {{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d/m/Y H:i') : $booking->created_at->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    @endif

    {{-- Terms & Policies --}}
    <div class="terms">
        <div style="font-weight: bold; margin-bottom: 4px; color: #111;">Terms & Conditions of Stay:</div>
        1. A valid government-issued photo ID or passport is required upon registration at Front Desk.<br>
        2. Check-in is available from 14:00 WITA. Check-out is strictly until 12:00 WITA unless prior late check-out arrangements are approved.<br>
        3. Stayora Resort is a 100% smoke-free indoor sanctuary. Smoking is permitted exclusively in designated open-air gardens.<br>
        4. Incidental deposit may be requested upon check-in via credit card pre-authorization or cash.
    </div>
</body>
</html>
