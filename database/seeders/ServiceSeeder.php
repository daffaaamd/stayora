<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Floating Champagne Breakfast', 'category' => 'Dining', 'price' => 450000, 'description' => 'Signature breakfast basket served in your private plunge pool with French champagne.'],
            ['name' => 'International Buffet Breakfast', 'category' => 'Dining', 'price' => 250000, 'description' => 'Daily lavish breakfast buffet at Svara Coastal Restaurant (per person).'],
            ['name' => 'Private Beachfront Candlelight Dinner', 'category' => 'Dining', 'price' => 1500000, 'description' => 'Romantic 5-course customized degustation menu with dedicated chef and violin serenade.'],
            ['name' => 'Traditional Balinese Healing Massage (90m)', 'category' => 'Spa', 'price' => 550000, 'description' => 'Deep tissue therapy using organic essential oils of frangipani and lemongrass.'],
            ['name' => 'Tropical Hot Stone Therapy (90m)', 'category' => 'Spa', 'price' => 650000, 'description' => 'Warm volcanic river stones paired with acupressure for total muscle tension release.'],
            ['name' => 'Couples Holistic Spa Ritual (120m)', 'category' => 'Spa', 'price' => 1200000, 'description' => 'Side-by-side scrub, floral bath, aromatherapy massage, and herbal tea.'],
            ['name' => 'Airport Chauffeur Transfer (One-way)', 'category' => 'Transport', 'price' => 350000, 'description' => 'Private luxury SUV transfer to/from Ngurah Rai International Airport (DPS).'],
            ['name' => 'Full-Day Private Chauffeur & Tour Guide', 'category' => 'Transport', 'price' => 950000, 'description' => '10-hour customized island tour with luxury Toyota Alphard and English-speaking guide.'],
            ['name' => 'Sunset Catamaran Sailing Cruise', 'category' => 'Excursion', 'price' => 850000, 'description' => '2-hour coastal cruise with canapés, live acoustic music, and free-flow wine.'],
            ['name' => 'Snorkeling & Coral Reef Safari', 'category' => 'Excursion', 'price' => 500000, 'description' => 'Guided boat expedition to Nusa Dua outer reef with all gear provided.'],
            ['name' => 'Express Laundry & Dry Cleaning (per bag)', 'category' => 'Housekeeping', 'price' => 150000, 'description' => 'Same-day washing, pressing, and delicate garment care.'],
            ['name' => 'Extra Rollaway Luxury Bed', 'category' => 'Room', 'price' => 400000, 'description' => 'Comfortable additional single bed with premium linens (per night).'],
            ['name' => 'Celebration Cake & Champagne Setup', 'category' => 'Celebration', 'price' => 600000, 'description' => 'Artisanal chocolate truffle cake and Veuve Clicquot champagne on arrival.'],
            ['name' => 'Flower Petal Bath & Bed Decoration', 'category' => 'Celebration', 'price' => 350000, 'description' => 'Romantic floral typography and fragrant bathtub petal arrangement.'],
            ['name' => 'Private Surfing Lesson (2 Hours)', 'category' => 'Recreation', 'price' => 450000, 'description' => 'Certified instructor lesson on Nusa Dua beach break with board included.'],
            ['name' => 'Afternoon High Tea at The Lounge', 'category' => 'Dining', 'price' => 220000, 'description' => 'Artisanal scones, macaroons, savory tartlets, and single-origin teas.'],
            ['name' => 'In-Room Mixology Cocktail Masterclass', 'category' => 'Dining', 'price' => 550000, 'description' => 'Learn craft cocktail secrets with private resort mixologist in your suite.'],
            ['name' => 'Late Check-out Privilege (Until 16:00)', 'category' => 'Room', 'price' => 500000, 'description' => 'Extended room occupancy past standard 12:00 check-out (subject to availability).'],
            ['name' => 'Private Sound Healing & Meditation (60m)', 'category' => 'Wellness', 'price' => 400000, 'description' => 'Tibetan singing bowls and breathing workshop in the oceanfront pavilion.'],
            ['name' => 'Gourmet In-Room Dining Midnight Platter', 'category' => 'Dining', 'price' => 300000, 'description' => 'Artisanal cheese, cured meats, dried figs, and warm sourdough delivered 24/7.'],
        ];

        foreach ($services as $s) {
            $s['slug'] = Str::slug($s['name']);
            $s['is_active'] = true;
            $s['image'] = 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80';
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
