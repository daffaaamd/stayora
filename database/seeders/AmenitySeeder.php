<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'High-Speed Wi-Fi', 'icon' => 'wifi', 'category' => 'Technology'],
            ['name' => 'King Koil Grand Pillow-Top Bed', 'icon' => 'bed', 'category' => 'Comfort'],
            ['name' => 'Private Oceanfront Balcony', 'icon' => 'sun', 'category' => 'Outdoor'],
            ['name' => 'Freestanding Marble Bathtub', 'icon' => 'bath', 'category' => 'Bathroom'],
            ['name' => '65" Smart 4K OLED TV', 'icon' => 'tv', 'category' => 'Entertainment'],
            ['name' => 'Nespresso Coffee & Artisanal Tea', 'icon' => 'coffee', 'category' => 'Refreshment'],
            ['name' => 'Curated Gourmet Mini Bar', 'icon' => 'glass', 'category' => 'Refreshment'],
            ['name' => 'Biometric In-Room Safe', 'icon' => 'lock', 'category' => 'Security'],
            ['name' => 'Bulgari Luxury Toiletries', 'icon' => 'sparkles', 'category' => 'Bathroom'],
            ['name' => 'Climate Control Dual A/C', 'icon' => 'snowflake', 'category' => 'Comfort'],
            ['name' => '24/7 Dedicated Butler Service', 'icon' => 'bell', 'category' => 'Service'],
            ['name' => 'Plunge Pool / Jacuzzi Access', 'icon' => 'water', 'category' => 'Outdoor'],
        ];

        foreach ($amenities as $a) {
            Amenity::updateOrCreate(['name' => $a['name']], $a);
        }
    }
}
