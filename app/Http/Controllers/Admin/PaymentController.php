<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request) {
        $query = Payment::with(['booking.user', 'booking.room.roomType']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('method')) $query->where('method', $request->method);
        if ($request->filled('date_from')) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('created_at', '<=', $request->date_to);
        $payments = $query->latest()->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }
}
