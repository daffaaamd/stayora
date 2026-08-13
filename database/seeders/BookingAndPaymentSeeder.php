<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Notification;
use App\Models\AuditLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingAndPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $rooms = Room::all();
        $services = Service::all();
        $admin = User::where('role', 'admin')->first();

        if ($customers->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        $paymentMethods = ['bank_transfer', 'credit_card', 'e_wallet', 'cash'];
        $reviewComments = [
            'Absolutely breathtaking resort! The ocean view from our balcony was stunning and the staff made our anniversary truly unforgettable.',
            'Five star service all the way. The infinity pool at sunset is mesmerizing, and the breakfast buffet had amazing variety.',
            'Exceptional stay! The room was spotless, the bed was so comfortable, and the spa treatment was the best I have ever had.',
            'The presidential villa exceeded every expectation. Private pool, direct beach access, and our butler Ni Wayan was incredible.',
            'A true tropical oasis. Peaceful, beautifully designed, and authentic Balinese hospitality at its finest.',
            'Great experience for our family holiday. The kids loved the pool and activity center, and the food was delicious.',
            'Stunning architecture and world class service. Will definitely be returning next year!',
            'Everything was seamless from check-in to check-out. Highly recommend the floating breakfast and sunset cruise.',
            'Paradise on earth! Clean marble bathrooms, luxurious linens, and very attentive front desk team.',
            'Romantic, secluded, yet close to Nusa Dua attractions. Perfect honeymoon destination.',
            'The culinary offerings at Svara restaurant were exquisite. Fresh seafood and great wine selection.',
            'Spacious suites, quiet beach, and top-tier spa facilities. Worth every penny.',
        ];

        $bookingCount = 1;
        $paymentCount = 1;

        // 1. Generate 70 COMPLETED Past Bookings (spread across last 6 months)
        for ($i = 0; $i < 70; $i++) {
            $customer = $customers->random();
            $room = $rooms->random();
            $daysAgo = rand(10, 180);
            $nights = rand(2, 5);

            $checkIn = Carbon::now()->subDays($daysAgo);
            $checkOut = (clone $checkIn)->addDays($nights);

            $bookingNumber = sprintf('STY-%04d-%05d', $checkIn->year, $bookingCount++);
            $subtotal = $room->price_per_night * $nights;
            $discount = rand(0, 1) ? round($subtotal * 0.10) : 0;
            $taxable = $subtotal - $discount;
            $tax = round($taxable * 0.10);
            $serviceCharge = round($taxable * 0.05);
            $total = $taxable + $tax + $serviceCharge;

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => $customer->id,
                'room_id' => $room->id,
                'guest_name' => $customer->name,
                'guest_email' => $customer->email,
                'guest_phone' => $customer->phone ?? '+62 812-0000-' . rand(1000, 9999),
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min($room->max_occupancy, 4)),
                'nights' => $nights,
                'room_price' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'service_charge' => $serviceCharge,
                'total' => $total,
                'promo_code' => $discount > 0 ? 'WELCOME10' : null,
                'status' => 'completed',
                'special_request' => rand(0, 1) ? 'Ocean view preference and quiet room.' : null,
                'created_at' => (clone $checkIn)->subDays(rand(3, 14)),
                'updated_at' => $checkOut,
            ]);

            // Add Paid Payment Record
            $method = $paymentMethods[array_rand($paymentMethods)];
            $payNum = sprintf('PAY-%04d-%05d', $checkIn->year, $paymentCount++);
            Payment::create([
                'booking_id' => $booking->id,
                'payment_number' => $payNum,
                'transaction_ref' => 'TXN-' . strtoupper(bin2hex(random_bytes(6))),
                'amount' => $total,
                'method' => $method,
                'status' => 'paid',
                'paid_at' => $booking->created_at->addMinutes(rand(10, 120)),
                'created_at' => $booking->created_at,
                'updated_at' => $booking->created_at->addMinutes(rand(10, 120)),
            ]);

            // Add 1-2 Service Orders for 40% of bookings
            if (rand(1, 10) <= 4 && $services->isNotEmpty()) {
                $service = $services->random();
                $qty = rand(1, 2);
                ServiceOrder::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'quantity' => $qty,
                    'price' => $service->price,
                    'total' => $service->price * $qty,
                    'status' => 'completed',
                    'notes' => 'Room ' . $room->room_number . ' delivery',
                    'created_at' => $checkIn->addDay(),
                ]);
            }

            // Create Review for ~40% of completed bookings
            if ($i < 30) {
                $rating = rand(4, 5);
                Review::create([
                    'booking_id' => $booking->id,
                    'user_id' => $customer->id,
                    'room_id' => $room->id,
                    'rating' => $rating,
                    'room_rating' => rand(4, 5),
                    'service_rating' => rand(4, 5),
                    'cleanliness_rating' => 5,
                    'comment' => $reviewComments[$i % count($reviewComments)],
                    'is_visible' => true,
                    'is_moderated' => true,
                    'created_at' => (clone $checkOut)->addDays(rand(1, 3)),
                ]);
            }
        }

        // 2. Generate 6 CURRENT ACTIVE IN-HOUSE Stays (Checked In)
        $activeRooms = $rooms->slice(0, 6);
        foreach ($activeRooms as $room) {
            $customer = $customers->random();
            $checkIn = Carbon::now()->subDays(rand(1, 2));
            $checkOut = Carbon::now()->addDays(rand(1, 3));
            $nights = $checkIn->diffInDays($checkOut);

            $bookingNumber = sprintf('STY-%04d-%05d', $checkIn->year, $bookingCount++);
            $subtotal = $room->price_per_night * $nights;
            $tax = round($subtotal * 0.10);
            $serviceCharge = round($subtotal * 0.05);
            $total = $subtotal + $tax + $serviceCharge;

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => $customer->id,
                'room_id' => $room->id,
                'guest_name' => $customer->name,
                'guest_email' => $customer->email,
                'guest_phone' => $customer->phone ?? '+62 812-5555-' . rand(1000, 9999),
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, $room->max_occupancy),
                'nights' => $nights,
                'room_price' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'service_charge' => $serviceCharge,
                'total' => $total,
                'status' => 'checked_in',
                'created_at' => (clone $checkIn)->subDays(rand(2, 7)),
            ]);

            // Update room status to occupied
            $room->update(['status' => 'occupied']);

            // Payment
            $payNum = sprintf('PAY-%04d-%05d', $checkIn->year, $paymentCount++);
            Payment::create([
                'booking_id' => $booking->id,
                'payment_number' => $payNum,
                'transaction_ref' => 'TXN-' . strtoupper(bin2hex(random_bytes(6))),
                'amount' => $total,
                'method' => 'credit_card',
                'status' => 'paid',
                'paid_at' => $booking->created_at->addMinutes(30),
            ]);

            // Add an active service order
            if ($services->isNotEmpty()) {
                $service = $services->where('category', 'Spa')->first() ?? $services->first();
                ServiceOrder::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'quantity' => 2,
                    'price' => $service->price,
                    'total' => $service->price * 2,
                    'status' => 'completed',
                    'notes' => 'In-room spa service for 2 guests',
                ]);
            }
        }

        // 3. Generate 15 CONFIRMED UPCOMING Bookings (Checking in over next 1-14 days)
        $upcomingRooms = $rooms->slice(6, 15);
        foreach ($upcomingRooms as $room) {
            $customer = $customers->random();
            $checkIn = Carbon::now()->addDays(rand(1, 14));
            $nights = rand(2, 4);
            $checkOut = (clone $checkIn)->addDays($nights);

            $bookingNumber = sprintf('STY-%04d-%05d', $checkIn->year, $bookingCount++);
            $subtotal = $room->price_per_night * $nights;
            $tax = round($subtotal * 0.10);
            $serviceCharge = round($subtotal * 0.05);
            $total = $subtotal + $tax + $serviceCharge;

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => $customer->id,
                'room_id' => $room->id,
                'guest_name' => $customer->name,
                'guest_email' => $customer->email,
                'guest_phone' => $customer->phone ?? '+62 812-7777-' . rand(1000, 9999),
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, $room->max_occupancy),
                'nights' => $nights,
                'room_price' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'service_charge' => $serviceCharge,
                'total' => $total,
                'status' => 'confirmed',
                'created_at' => Carbon::now()->subDays(rand(1, 5)),
            ]);

            $payNum = sprintf('PAY-%04d-%05d', $checkIn->year, $paymentCount++);
            Payment::create([
                'booking_id' => $booking->id,
                'payment_number' => $payNum,
                'transaction_ref' => 'TXN-' . strtoupper(bin2hex(random_bytes(6))),
                'amount' => $total,
                'method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => 'paid',
                'paid_at' => $booking->created_at->addMinutes(15),
            ]);
        }

        // 4. Generate 5 PENDING PAYMENT Bookings (for simulation testing)
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            $room = $rooms->random();
            $checkIn = Carbon::now()->addDays(rand(5, 20));
            $nights = rand(2, 3);
            $checkOut = (clone $checkIn)->addDays($nights);

            $bookingNumber = sprintf('STY-%04d-%05d', $checkIn->year, $bookingCount++);
            $subtotal = $room->price_per_night * $nights;
            $tax = round($subtotal * 0.10);
            $serviceCharge = round($subtotal * 0.05);
            $total = $subtotal + $tax + $serviceCharge;

            Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => $customer->id,
                'room_id' => $room->id,
                'guest_name' => $customer->name,
                'guest_email' => $customer->email,
                'guest_phone' => $customer->phone ?? '+62 812-9999-' . rand(1000, 9999),
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => 2,
                'nights' => $nights,
                'room_price' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'service_charge' => $serviceCharge,
                'total' => $total,
                'status' => 'pending_payment',
                'created_at' => Carbon::now()->subHours(rand(1, 12)),
            ]);
        }

        // 5. Generate 5 CANCELLED Bookings
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            $room = $rooms->random();
            $checkIn = Carbon::now()->addDays(rand(10, 30));
            $nights = rand(2, 3);
            $checkOut = (clone $checkIn)->addDays($nights);

            $bookingNumber = sprintf('STY-%04d-%05d', $checkIn->year, $bookingCount++);
            $subtotal = $room->price_per_night * $nights;
            $tax = round($subtotal * 0.10);
            $serviceCharge = round($subtotal * 0.05);
            $total = $subtotal + $tax + $serviceCharge;

            Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => $customer->id,
                'room_id' => $room->id,
                'guest_name' => $customer->name,
                'guest_email' => $customer->email,
                'guest_phone' => $customer->phone ?? '+62 812-4444-' . rand(1000, 9999),
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => 2,
                'nights' => $nights,
                'room_price' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'service_charge' => $serviceCharge,
                'total' => $total,
                'status' => 'cancelled',
                'cancellation_reason' => 'Guest flight schedule changed',
                'created_at' => Carbon::now()->subDays(rand(5, 20)),
            ]);
        }

        // 6. Generate VIP Customer specific bookings (guest@stayora.test)
        $vipGuest = User::where('email', 'guest@stayora.test')->first();
        if ($vipGuest) {
            // An upcoming stay for guest@stayora.test
            $vipRoom = Room::where('room_number', 'V-01')->first() ?? $rooms->first();
            $vipCheckIn = Carbon::now()->addDays(3);
            $vipCheckOut = Carbon::now()->addDays(6);
            $vipNights = 3;
            $vipSubtotal = $vipRoom->price_per_night * $vipNights;
            $vipTax = round($vipSubtotal * 0.10);
            $vipService = round($vipSubtotal * 0.05);
            $vipTotal = $vipSubtotal + $vipTax + $vipService;

            $vipBooking = Booking::create([
                'booking_number' => sprintf('STY-%04d-%05d', $vipCheckIn->year, $bookingCount++),
                'user_id' => $vipGuest->id,
                'room_id' => $vipRoom->id,
                'guest_name' => $vipGuest->name,
                'guest_email' => $vipGuest->email,
                'guest_phone' => $vipGuest->phone,
                'check_in' => $vipCheckIn->format('Y-m-d'),
                'check_out' => $vipCheckOut->format('Y-m-d'),
                'guests' => 2,
                'nights' => $vipNights,
                'room_price' => $vipRoom->price_per_night,
                'subtotal' => $vipSubtotal,
                'discount' => 0,
                'tax' => $vipTax,
                'service_charge' => $vipService,
                'total' => $vipTotal,
                'status' => 'confirmed',
                'special_request' => 'Private airport pickup at DPS Airport Terminal and chilled champagne in villa.',
                'created_at' => Carbon::now()->subDay(),
            ]);

            $payNum = sprintf('PAY-%04d-%05d', $vipCheckIn->year, $paymentCount++);
            Payment::create([
                'booking_id' => $vipBooking->id,
                'payment_number' => $payNum,
                'transaction_ref' => 'TXN-' . strtoupper(bin2hex(random_bytes(6))),
                'amount' => $vipTotal,
                'method' => 'credit_card',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDay()->addMinutes(10),
            ]);

            // Sample notifications for VIP guest
            Notification::create([
                'user_id' => $vipGuest->id,
                'title' => 'Reservation Confirmed',
                'message' => "Your reservation for {$vipRoom->name} (#{$vipBooking->booking_number}) is confirmed for {$vipCheckIn->format('d M Y')}.",
                'type' => 'booking_confirmed',
                'data' => ['booking_id' => $vipBooking->id],
            ]);

            Notification::create([
                'user_id' => $vipGuest->id,
                'title' => 'Payment Successful',
                'message' => 'Payment of Rp ' . number_format($vipTotal, 0, ',', '.') . ' has been processed successfully.',
                'type' => 'payment_success',
                'data' => ['booking_id' => $vipBooking->id],
            ]);
        }

        // 7. Generate Sample Audit Logs
        if ($admin) {
            AuditLog::create([
                'user_id' => $admin->id,
                'action' => 'created',
                'model_type' => 'App\Models\Room',
                'model_id' => 1,
                'new_values' => ['room_number' => '101', 'price_per_night' => 1250000],
                'ip_address' => '127.0.0.1',
            ]);
            AuditLog::create([
                'user_id' => $admin->id,
                'action' => 'status_updated',
                'model_type' => 'App\Models\Room',
                'model_id' => 2,
                'old_values' => ['status' => 'available'],
                'new_values' => ['status' => 'occupied'],
                'ip_address' => '127.0.0.1',
            ]);
        }
    }
}
