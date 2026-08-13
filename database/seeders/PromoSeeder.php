<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            [
                'code' => 'WELCOME10',
                'name' => 'Welcome Member Discount 10%',
                'description' => 'Enjoy 10% off your direct reservation at Stayora Resort.',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_booking' => 1000000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(6),
                'usage_limit' => 500,
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER25',
                'name' => 'Summer Tropical Escape 25%',
                'description' => '25% discount for bookings over Rp 3.000.000.',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'min_booking' => 3000000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(4),
                'usage_limit' => 200,
                'is_active' => true,
            ],
            [
                'code' => 'LUXURYSTAY',
                'name' => 'Luxury Stay Rp 500.000 Voucher',
                'description' => 'Direct Rp 500.000 discount on any multi-night stay.',
                'discount_type' => 'fixed',
                'discount_value' => 500000,
                'min_booking' => 2500000,
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(5),
                'usage_limit' => 100,
                'is_active' => true,
            ],
            [
                'code' => 'STAYORA2026',
                'name' => 'Grand Year 2026 Promo',
                'description' => 'Special 15% discount for 2026 early-bird reservations.',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'min_booking' => 1500000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(10),
                'usage_limit' => 1000,
                'is_active' => true,
            ],
            [
                'code' => 'HONEYMOON',
                'name' => 'Honeymoon Couples Rp 750.000 Gift',
                'description' => 'Rp 750.000 fixed discount for romantic getaways.',
                'discount_type' => 'fixed',
                'discount_value' => 750000,
                'min_booking' => 4000000,
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(8),
                'usage_limit' => 50,
                'is_active' => true,
            ],
            [
                'code' => 'VILLASPECIAL',
                'name' => 'Presidential Villa Exclusive 20%',
                'description' => '20% off for Presidential Villa reservations.',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'min_booking' => 7000000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(6),
                'usage_limit' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'FLASH100K',
                'name' => 'Flash Sale Rp 100.000 Off',
                'description' => 'Instant Rp 100.000 savings on any room.',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'min_booking' => 500000,
                'start_date' => now()->subWeeks(2),
                'end_date' => now()->addMonths(2),
                'usage_limit' => 300,
                'is_active' => true,
            ],
            [
                'code' => 'WEEKENDDEAL',
                'name' => 'Weekend Retreat 12% Off',
                'description' => '12% discount for weekend getaways.',
                'discount_type' => 'percentage',
                'discount_value' => 12,
                'min_booking' => 2000000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(5),
                'usage_limit' => 150,
                'is_active' => true,
            ],
            [
                'code' => 'FAMILYFUN',
                'name' => 'Family Holiday Rp 350.000 Discount',
                'description' => 'Rp 350.000 off Family Suite bookings.',
                'discount_type' => 'fixed',
                'discount_value' => 350000,
                'min_booking' => 2800000,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(6),
                'usage_limit' => 80,
                'is_active' => true,
            ],
            [
                'code' => 'STAYORAVIP',
                'name' => 'VIP Club 30% Off',
                'description' => 'Exclusive 30% discount for premium members.',
                'discount_type' => 'percentage',
                'discount_value' => 30,
                'min_booking' => 5000000,
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(12),
                'usage_limit' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($promos as $p) {
            Promo::updateOrCreate(['code' => $p['code']], $p);
        }
    }
}
