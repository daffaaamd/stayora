<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $gallery = [
            // ─── 1. RESORT & ARCHITECTURE (6 Photos) ───────────────────────────────────
            [
                'title' => 'Main Resort Sanctuary & Tropical Grounds',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Aerial Coastal Panorama of Stayora Resort',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Illuminated Evening Waterways & Walkways',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Sunset Coastal Catamaran Cruise Experience',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Traditional Balinese Water Temple Pavilion',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Lush Botanical Terraces & Koi Lotus Pond',
                'category' => 'resort',
                'image_path' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 2. LOBBY & ARRIVAL (6 Photos) ────────────────────────────────────────
            [
                'title' => 'Grand Open-Air Lobby & Welcome Pavilion',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Concierge Reception & Guest Arrival Lounge',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Carved Teakwood Architecture & Water Fountain Hall',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'VIP Members Club & Heritage Library Lounge',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Evening Lobby Ambience with Ambient Chandelier',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Open Veranda Seating with Ocean Breeze',
                'category' => 'lobby',
                'image_path' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 3. POOLS & LAGOONS (6 Photos) ────────────────────────────────────────
            [
                'title' => 'Ocean Horizon Infinity Pool at Dusk',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Lagoon Pool with Submerged Sun Loungers',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Poolside Cabanas & Sunset Cocktail Service',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Tropical Palm-Fringed Relaxation Oasis Pool',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Private Villa Plunge Pool Overlooking Surf',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Two-Tiered Garden Cascade Waterfall Pool',
                'category' => 'pool',
                'image_path' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 4. DINING & CULINARY (6 Photos) ──────────────────────────────────────
            [
                'title' => 'Svara Coastal Fine Dining Restaurant',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Romantic Beachfront Candlelight Dinner',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Signature Floating Breakfast in Villa Pool',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1533777857889-4be7c70e33f7?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Ocean Sunset Cocktail Bar & Cellar Lounge',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Gourmet Balinese Seafood Platter',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Artisanal Patisserie & Afternoon High Tea',
                'category' => 'dining',
                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 5. SPA & WELLNESS (6 Photos) ─────────────────────────────────────────
            [
                'title' => 'Ananda Holistic Bamboo Spa Pavilion',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Traditional Balinese Herbal Body Massage',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Sunrise Oceanfront Yoga & Meditation Deck',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Botanical Flower Bath & Hydrotherapy Pool',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Equinox Technogym Cardio & Fitness Suite',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Organic Essential Oils & Aromatherapy Bar',
                'category' => 'spa',
                'image_path' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 6. ROOMS & LUXURY SUITES (6 Photos) ──────────────────────────────────
            [
                'title' => 'Presidential Beachfront Villa Master Pavilion',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Executive Oceanfront Penthouse Master Bedroom',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Marble Ensuite Soaking Tub with Garden Vista',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Royal Jacuzzi Penthouse Private Sun Terrace',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Family Grand Suite Two-Bedroom Living Lounge',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Deluxe Garden Haven Private Veranda Sunbeds',
                'category' => 'rooms',
                'image_path' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
            ],

            // ─── 7. BEACH & SHORELINE (6 Photos) ──────────────────────────────────────
            [
                'title' => 'Private White-Sand Beach & Shaded Cabanas',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Pristine Turquoise Water & Sun Loungers',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Golden Hour Sunset Over Nusa Dua Beach',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Beachfront Daybeds & Oceanfront Breeze',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Coastal Stand-Up Paddleboard Watersports',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title' => 'Secluded Coral Cove & Tropical Reef Exploration',
                'category' => 'beach',
                'image_path' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        GalleryImage::truncate();

        foreach ($gallery as $i => $item) {
            $item['sort_order'] = $i + 1;
            $item['is_active'] = true;
            GalleryImage::create($item);
        }
    }
}
