<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Deluxe Room',
                'description' => 'Sophisticated 45m² room featuring a plush king-size bed, private terrace, and lush tropical garden vistas.',
                'base_price' => 1250000,
                'max_occupancy' => 2,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium Room',
                'description' => 'Elevated 55m² space offering panoramic views of the Indian Ocean, marble ensuite with deep soaking tub, and espresso bar.',
                'base_price' => 1850000,
                'max_occupancy' => 2,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Family Suite',
                'description' => 'Generous 85m² two-bedroom suite with spacious living lounge, dining area, and kid-friendly entertainment amenities.',
                'base_price' => 2850000,
                'max_occupancy' => 4,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 3,
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Refined 110m² oceanfront suite with private terrace sunbeds, whirlpool Jacuzzi, butler service, and club lounge access.',
                'base_price' => 3950000,
                'max_occupancy' => 3,
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 4,
            ],
            [
                'name' => 'Presidential Villa',
                'description' => 'The ultimate 250m² private beachfront sanctuary with dedicated infinity plunge pool, private chef kitchen, and master pavilion.',
                'base_price' => 7500000,
                'max_occupancy' => 6,
                'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 5,
            ],
        ];

        foreach ($types as $t) {
            $t['slug'] = Str::slug($t['name']);
            RoomType::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
