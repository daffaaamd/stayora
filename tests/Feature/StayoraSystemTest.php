<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class StayoraSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /** 1. Landing Page */
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Stayora Resort');
        $response->assertSee('A stay worth remembering.');
    }

    /** 2. Room Listing & Availability Search */
    public function test_room_listing_and_availability_search(): void
    {
        $response = $this->get(route('rooms.index', [
            'check_in' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'check_out' => Carbon::now()->addDays(8)->format('Y-m-d'),
            'guests' => 2,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rooms', false);
        $response->assertSee('Suites', false);
    }

    /** 3. Room Details Page */
    public function test_room_detail_page_renders_with_amenities(): void
    {
        $room = Room::first();
        $this->assertNotNull($room);

        $response = $this->get(route('rooms.show', $room->slug));
        $response->assertStatus(200);
        $response->assertSee($room->name);
        $response->assertSee('Nightly Rate');
    }

    /** 4. Authentication and Demo Accounts */
    public function test_admin_and_customer_can_authenticate(): void
    {
        $admin = User::where('email', 'admin@stayora.test')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Management Overview');

        $guest = User::where('email', 'guest@stayora.test')->first();
        $this->assertNotNull($guest);

        $response = $this->actingAs($guest)->get(route('customer.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Guest Dashboard');
    }

    /** 5. Complete Booking Workflow */
    public function test_customer_booking_creation_and_payment_flow(): void
    {
        $customer = User::where('email', 'guest@stayora.test')->first();
        $room = Room::where('status', 'available')->first();
        $this->assertNotNull($room);

        $checkIn = Carbon::now()->addDays(30)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(33)->format('Y-m-d');

        // Submit Booking
        $response = $this->actingAs($customer)->post(route('customer.bookings.store'), [
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => 2,
            'guest_name' => 'Daffa Ahmad',
            'guest_email' => 'guest@stayora.test',
            'guest_phone' => '+62 812-3456-7890',
            'special_request' => 'Ocean view high floor please.',
            'promo_code' => 'WELCOME10',
        ]);

        $booking = Booking::where('guest_email', 'guest@stayora.test')
            ->whereDate('check_in', $checkIn)
            ->latest('id')
            ->first();

        $this->assertNotNull($booking);
        $this->assertEquals('pending_payment', $booking->status);
        $this->assertEquals(3, $booking->nights);
        $this->assertGreaterThan(0, $booking->discount);

        // Process Mock Payment
        $payResponse = $this->actingAs($customer)->post(route('customer.payment.process', $booking), [
            'payment_method' => 'credit_card',
        ]);

        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);
        $this->assertNotNull($booking->payment);
        $this->assertEquals('paid', $booking->payment->status);
    }

    /** 6. Front Desk Check-in & Check-out Operations */
    public function test_checkin_and_checkout_lifecycle(): void
    {
        $admin = User::where('email', 'admin@stayora.test')->first();
        $customer = User::where('role', 'customer')->first();
        $room = Room::where('status', 'available')->first();

        // Create confirmed booking
        $booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $customer->id,
            'room_id' => $room->id,
            'guest_name' => $customer->name,
            'guest_email' => $customer->email,
            'check_in' => Carbon::now()->format('Y-m-d'),
            'check_out' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'guests' => 2,
            'nights' => 2,
            'room_price' => $room->price_per_night,
            'subtotal' => $room->price_per_night * 2,
            'discount' => 0,
            'tax' => ($room->price_per_night * 2) * 0.10,
            'service_charge' => ($room->price_per_night * 2) * 0.05,
            'total' => ($room->price_per_night * 2) * 1.15,
            'status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'payment_number' => Payment::generatePaymentNumber(),
            'transaction_ref' => 'TXN-TEST',
            'amount' => $booking->total,
            'method' => 'bank_transfer',
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Process Check-in
        $this->actingAs($admin)->post(route('admin.checkin.process', $booking));

        $booking->refresh();
        $room->refresh();

        $this->assertEquals('checked_in', $booking->status);
        $this->assertEquals('occupied', $room->status);

        // Process Check-out
        $this->actingAs($admin)->post(route('admin.checkout.process', $booking));

        $booking->refresh();
        $room->refresh();

        $this->assertEquals('completed', $booking->status);
        $this->assertEquals('cleaning', $room->status);
    }

    /** 7. PDF Voucher Download */
    public function test_pdf_voucher_download(): void
    {
        $guest = User::where('email', 'guest@stayora.test')->first();
        $booking = Booking::where('user_id', $guest->id)->first();
        $this->assertNotNull($booking);

        $response = $this->actingAs($guest)->get(route('customer.bookings.pdf', $booking));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
