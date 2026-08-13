<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Ocean Horizon Infinity Pool',
                'description' => 'A multi-tiered 50-meter infinity pool that seemingly merges with the Indian Ocean, complete with submerged sunbeds and poolside cocktail bar.',
                'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'pool',
                'sort_order' => 1,
            ],
            [
                'name' => 'Svara Coastal Restaurant & Lounge',
                'description' => 'Signature oceanfront dining serving fresh sea catch, premium Wagyu steaks, and authentic Balinese spices curated by Master Chef Dewa.',
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'utensils',
                'sort_order' => 2,
            ],
            [
                'name' => 'Ananda Holistic Wellness Spa',
                'description' => 'Ancient Balinese healing rituals, herbal hydrotherapy pools, and organic botanical body wraps in private bamboo spa pavilions.',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'spa',
                'sort_order' => 3,
            ],
            [
                'name' => 'Equinox Fitness & Yoga Pavilion',
                'description' => 'State-of-the-art Technogym cardio machines, free weights, and daily sunrise yoga classes overlooking the ocean surf.',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'dumbbell',
                'sort_order' => 4,
            ],
            [
                'name' => 'Private White-Sand Beach & Cabanas',
                'description' => '300 meters of secluded beachfront with cushioned private daybeds, stand-up paddleboards, and personalized beach butler service.',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'umbrella-beach',
                'sort_order' => 5,
            ],
            [
                'name' => 'Lotus Kids & Teen Activity Sanctuary',
                'description' => 'Supervised cultural crafts, Balinese dance workshops, beach games, and indoor game lounge for younger guests.',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'gamepad',
                'sort_order' => 6,
            ],
        ];

        foreach ($facilities as $f) {
            $f['slug'] = Str::slug($f['name']);
            Facility::updateOrCreate(['slug' => $f['slug']], $f);
        }
    }
}
