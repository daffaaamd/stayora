<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\FacilityController;
use App\Http\Controllers\Customer\GalleryController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\Admin\CheckOutController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AuditLogController;

// ─── Public Routes ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{slug}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/rooms/check-availability', [RoomController::class, 'checkAvailability'])->name('rooms.check-availability');
Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// ─── Dashboard Redirect ─────────────────────────────────────
Route::get('/dashboard', function () {
    if (auth()->user()->isStaff() || auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware('auth')->name('dashboard');

// ─── Customer Routes (Auth Required) ────────────────────────
Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('customer.bookings');
    Route::get('/bookings/create/{room}', [BookingController::class, 'create'])->name('customer.bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('customer.bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('customer.bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('customer.bookings.cancel');
    Route::get('/bookings/{booking}/pdf', [BookingController::class, 'downloadPdf'])->name('customer.bookings.pdf');
    Route::post('/bookings/validate-promo', [BookingController::class, 'validatePromo'])->name('customer.bookings.validate-promo');

    // Payment
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('customer.payment.show');
    Route::post('/payment/{booking}', [PaymentController::class, 'process'])->name('customer.payment.process');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('customer.reviews');
    Route::get('/reviews/create/{booking}', [ReviewController::class, 'create'])->name('customer.reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('customer.reviews.store');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('customer.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('customer.profile.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('customer.notifications');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('customer.notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('customer.notifications.read-all');
});

// ─── Admin Routes ────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,front_desk,housekeeping,finance'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::put('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update-status');

    // Check-in / Check-out
    Route::get('/check-in', [CheckInController::class, 'index'])->name('admin.checkin.index');
    Route::post('/check-in/{booking}', [CheckInController::class, 'process'])->name('admin.checkin.process');
    Route::get('/check-out', [CheckOutController::class, 'index'])->name('admin.checkout.index');
    Route::get('/check-out/{booking}', [CheckOutController::class, 'show'])->name('admin.checkout.show');
    Route::post('/check-out/{booking}', [CheckOutController::class, 'process'])->name('admin.checkout.process');

    // Rooms
    Route::resource('rooms', AdminRoomController::class)->names('admin.rooms');
    Route::put('/rooms/{room}/status', [AdminRoomController::class, 'updateStatus'])->name('admin.rooms.update-status');

    // Room Types
    Route::resource('room-types', AdminRoomTypeController::class)->names('admin.room-types');

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{user}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');

    // Facilities
    Route::resource('facilities', AdminFacilityController::class)->names('admin.facilities');

    // Services
    Route::resource('services', AdminServiceController::class)->names('admin.services');

    // Service Orders (for checked-in bookings)
    Route::post('/bookings/{booking}/service-orders', [AdminBookingController::class, 'addServiceOrder'])->name('admin.bookings.add-service');

    // Promos
    Route::resource('promos', AdminPromoController::class)->names('admin.promos');

    // Reviews
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::put('/reviews/{review}/toggle', [AdminReviewController::class, 'toggleVisibility'])->name('admin.reviews.toggle');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/{type}', [ReportController::class, 'show'])->name('admin.reports.show');
    Route::get('/reports/{type}/export/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export-pdf');
    Route::get('/reports/{type}/export/excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export-excel');

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index');
});

require __DIR__.'/auth.php';
