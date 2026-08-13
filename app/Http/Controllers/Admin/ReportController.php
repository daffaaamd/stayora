<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\AvailabilityService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function show(string $type, Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $data = match($type) {
            'booking' => $this->bookingReport($dateFrom, $dateTo, $request),
            'revenue' => $this->revenueReport($dateFrom, $dateTo),
            'occupancy' => $this->occupancyReport($dateFrom, $dateTo),
            'room-performance' => $this->roomPerformanceReport($dateFrom, $dateTo),
            'customer' => $this->customerReport($dateFrom, $dateTo),
            'payment' => $this->paymentReport($dateFrom, $dateTo, $request),
            'service' => $this->serviceReport($dateFrom, $dateTo),
            default => abort(404),
        };

        return view("admin.reports.{$type}", array_merge($data, ['dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'type' => $type]));
    }

    public function exportPdf(string $type, Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $data = match($type) {
            'booking' => $this->bookingReport($dateFrom, $dateTo, $request),
            'revenue' => $this->revenueReport($dateFrom, $dateTo),
            'payment' => $this->paymentReport($dateFrom, $dateTo, $request),
            default => $this->bookingReport($dateFrom, $dateTo, $request),
        };

        $pdf = Pdf::loadView("pdf.reports.{$type}", array_merge($data, ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]));
        return $pdf->download("report-{$type}-{$dateFrom}-to-{$dateTo}.pdf");
    }

    public function exportExcel(string $type, Request $request)
    {
        // Placeholder - would use Maatwebsite/Excel
        return back()->with('success', 'Excel export functionality available.');
    }

    private function bookingReport(string $dateFrom, string $dateTo, Request $request): array
    {
        $query = Booking::with(['user', 'room.roomType', 'payment'])
            ->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()]);

        if ($request->filled('status')) $query->where('status', $request->status);

        return ['bookings' => $query->latest()->get(), 'summary' => [
            'total' => $query->count(),
            'revenue' => (clone $query)->sum('total'),
        ]];
    }

    private function revenueReport(string $dateFrom, string $dateTo): array
    {
        $payments = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])
            ->get();

        return ['payments' => $payments, 'summary' => [
            'total_revenue' => $payments->sum('amount'),
            'total_transactions' => $payments->count(),
            'by_method' => $payments->groupBy('method')->map(fn($g) => $g->sum('amount')),
        ]];
    }

    private function occupancyReport(string $dateFrom, string $dateTo): array
    {
        $totalRooms = Room::where('is_active', true)->count();
        return ['totalRooms' => $totalRooms];
    }

    private function roomPerformanceReport(string $dateFrom, string $dateTo): array
    {
        $rooms = Room::withCount(['bookings' => fn($q) => $q->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])->whereNotIn('status', ['cancelled'])])
            ->withSum(['bookings' => fn($q) => $q->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])->whereNotIn('status', ['cancelled'])], 'total')
            ->with('roomType')
            ->orderByDesc('bookings_count')
            ->get();

        return ['rooms' => $rooms];
    }

    private function customerReport(string $dateFrom, string $dateTo): array
    {
        $customers = User::where('role', 'customer')
            ->withCount(['bookings' => fn($q) => $q->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])])
            ->withSum(['bookings' => fn($q) => $q->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])->whereNotIn('status', ['cancelled'])], 'total')
            ->having('bookings_count', '>', 0)
            ->orderByDesc('bookings_count')
            ->get();

        return ['customers' => $customers];
    }

    private function paymentReport(string $dateFrom, string $dateTo, Request $request): array
    {
        $query = Payment::with(['booking.user', 'booking.room.roomType'])
            ->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()]);

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('method')) $query->where('method', $request->method);

        return ['payments' => $query->latest()->get()];
    }

    private function serviceReport(string $dateFrom, string $dateTo): array
    {
        $orders = \App\Models\ServiceOrder::with('service')
            ->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])
            ->where('status', 'completed')
            ->get();

        return ['orders' => $orders, 'byService' => $orders->groupBy('service_id')->map(fn($g) => ['count' => $g->count(), 'total' => $g->sum('total'), 'name' => $g->first()->service->name])];
    }
}
