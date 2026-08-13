<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $deluxe = RoomType::where('slug', 'deluxe-room')->first();
        $premium = RoomType::where('slug', 'premium-room')->first();
        $family = RoomType::where('slug', 'family-suite')->first();
        $executive = RoomType::where('slug', 'executive-suite')->first();
        $villa = RoomType::where('slug', 'presidential-villa')->first();

        $allAmenities = Amenity::all();

        // 30 distinct room setups with individual, unique photo sets
        $roomsData = [
            // ─── 10 Deluxe Rooms (101 - 110) ──────────────────────────────────────────
            [
                'number' => '101', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Garden Haven 101',
                'price' => 1250000, 'size' => 45, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Tropical Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '102', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Twin Garden 102',
                'price' => 1250000, 'size' => 45, 'occ' => 2, 'bed' => '2 Twin Beds', 'view' => 'Tropical Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '103', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Pool Access 103',
                'price' => 1400000, 'size' => 48, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Lagoon Pool Access',
                'images' => [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '104', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Pool Access 104',
                'price' => 1400000, 'size' => 48, 'occ' => 2, 'bed' => '2 Twin Beds', 'view' => 'Lagoon Pool Access',
                'images' => [
                    'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '105', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Terrace Suite 105',
                'price' => 1350000, 'size' => 46, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Private Garden Terrace',
                'images' => [
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '106', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Sanctuary 106',
                'price' => 1250000, 'size' => 45, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Zen Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '107', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Twin Oasis 107',
                'price' => 1250000, 'size' => 45, 'occ' => 2, 'bed' => '2 Twin Beds', 'view' => 'Tropical Courtyard View',
                'images' => [
                    'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '108', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Courtyard 108',
                'price' => 1250000, 'size' => 45, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Lotus Pond View',
                'images' => [
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '109', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Harmony 109',
                'price' => 1300000, 'size' => 47, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Garden & Fountain View',
                'images' => [
                    'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '110', 'type' => $deluxe, 'floor' => 1, 'name' => 'Deluxe Corner Haven 110',
                'price' => 1350000, 'size' => 50, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Dual Aspect Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                ]
            ],

            // ─── 8 Premium Rooms (201 - 208) ──────────────────────────────────────────
            [
                'number' => '201', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Ocean Horizon 201',
                'price' => 1850000, 'size' => 55, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Panoramic Ocean View',
                'images' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '202', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Ocean Horizon 202',
                'price' => 1850000, 'size' => 55, 'occ' => 2, 'bed' => '2 Twin Beds', 'view' => 'Panoramic Ocean View',
                'images' => [
                    'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '203', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Azure Balcony 203',
                'price' => 1950000, 'size' => 58, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Direct Oceanfront View',
                'images' => [
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '204', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Azure Balcony 204',
                'price' => 1950000, 'size' => 58, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Direct Oceanfront View',
                'images' => [
                    'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '205', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Coastal Vista 205',
                'price' => 1850000, 'size' => 55, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Ocean & Beach View',
                'images' => [
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '206', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Coastal Vista 206',
                'price' => 1850000, 'size' => 55, 'occ' => 2, 'bed' => '2 Twin Beds', 'view' => 'Ocean & Beach View',
                'images' => [
                    'https://images.unsplash.com/photo-1587985064135-0366536eab42?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '207', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Sunset Alcove 207',
                'price' => 2050000, 'size' => 60, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Indian Ocean Sunset View',
                'images' => [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '208', 'type' => $premium, 'floor' => 2, 'name' => 'Premium Sunset Alcove 208',
                'price' => 2050000, 'size' => 60, 'occ' => 2, 'bed' => '1 King Bed', 'view' => 'Indian Ocean Sunset View',
                'images' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1587985064135-0366536eab42?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                ]
            ],

            // ─── 6 Family Suites (301 - 306) ──────────────────────────────────────────
            [
                'number' => '301', 'type' => $family, 'floor' => 3, 'name' => 'Family Grand Suite 301',
                'price' => 2850000, 'size' => 85, 'occ' => 4, 'bed' => '1 King + 2 Twin Beds', 'view' => 'Ocean & Resort Panorama',
                'images' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '302', 'type' => $family, 'floor' => 3, 'name' => 'Family Grand Suite 302',
                'price' => 2850000, 'size' => 85, 'occ' => 4, 'bed' => '1 King + 2 Twin Beds', 'view' => 'Ocean & Resort Panorama',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '303', 'type' => $family, 'floor' => 3, 'name' => 'Family Two-Bedroom Pavilion 303',
                'price' => 3100000, 'size' => 95, 'occ' => 4, 'bed' => '2 King Beds', 'view' => 'Coastline & Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '304', 'type' => $family, 'floor' => 3, 'name' => 'Family Two-Bedroom Pavilion 304',
                'price' => 3100000, 'size' => 95, 'occ' => 4, 'bed' => '2 King Beds', 'view' => 'Coastline & Garden View',
                'images' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '305', 'type' => $family, 'floor' => 3, 'name' => 'Family Coastal Residence 305',
                'price' => 3300000, 'size' => 100, 'occ' => 5, 'bed' => '2 King + 1 Sofa Bed', 'view' => 'Direct Ocean Panorama',
                'images' => [
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '306', 'type' => $family, 'floor' => 3, 'name' => 'Family Coastal Residence 306',
                'price' => 3300000, 'size' => 100, 'occ' => 5, 'bed' => '2 King + 1 Sofa Bed', 'view' => 'Direct Ocean Panorama',
                'images' => [
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],

            // ─── 4 Executive Suites (401 - 404) ──────────────────────────────────────────
            [
                'number' => '401', 'type' => $executive, 'floor' => 4, 'name' => 'Executive Oceanfront Penthouse 401',
                'price' => 3950000, 'size' => 110, 'occ' => 3, 'bed' => '1 King Bed + Lounge', 'view' => 'Top Floor 180° Ocean View',
                'images' => [
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '402', 'type' => $executive, 'floor' => 4, 'name' => 'Executive Oceanfront Penthouse 402',
                'price' => 3950000, 'size' => 110, 'occ' => 3, 'bed' => '1 King Bed + Lounge', 'view' => 'Top Floor 180° Ocean View',
                'images' => [
                    'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '403', 'type' => $executive, 'floor' => 4, 'name' => 'Executive Royal Jacuzzi Suite 403',
                'price' => 4450000, 'size' => 125, 'occ' => 3, 'bed' => '1 Emperor Bed', 'view' => 'Ocean View with Private Jacuzzi',
                'images' => [
                    'https://images.unsplash.com/photo-1591825729269-caeb344f6df2?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => '404', 'type' => $executive, 'floor' => 4, 'name' => 'Executive Royal Jacuzzi Suite 404',
                'price' => 4450000, 'size' => 125, 'occ' => 3, 'bed' => '1 Emperor Bed', 'view' => 'Ocean View with Private Jacuzzi',
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1591825729269-caeb344f6df2?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
                ]
            ],

            // ─── 2 Presidential Villas (V-01, V-02) ───────────────────────────────────
            [
                'number' => 'V-01', 'type' => $villa, 'floor' => 1, 'name' => 'Presidential Beachfront Villa Ayodya',
                'price' => 7500000, 'size' => 250, 'occ' => 6, 'bed' => '3 King Bedrooms', 'view' => 'Direct Private Beach Frontage',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
            [
                'number' => 'V-02', 'type' => $villa, 'floor' => 1, 'name' => 'Presidential Royal Villa Nusantara',
                'price' => 8500000, 'size' => 280, 'occ' => 6, 'bed' => '3 King Bedrooms + Pavilion', 'view' => 'Direct Private Beach Frontage',
                'images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                ]
            ],
        ];

        foreach ($roomsData as $r) {
            $room = Room::updateOrCreate(
                ['room_number' => $r['number']],
                [
                    'room_type_id' => $r['type']->id,
                    'name' => $r['name'],
                    'slug' => Str::slug($r['name'] . '-' . $r['number']),
                    'floor' => $r['floor'],
                    'size_sqm' => $r['size'],
                    'view_type' => $r['view'],
                    'bed_type' => $r['bed'],
                    'max_occupancy' => $r['occ'],
                    'price_per_night' => $r['price'],
                    'description' => "Experience the epitome of Balinese coastal luxury in {$r['name']}. Meticulously appointed with hand-carved teakwood, {$r['bed']}, marble ensuite with deep soaking tub, private terrace with {$r['view']}, and dedicated personalized hospitality.",
                    'status' => 'available',
                    'is_active' => true,
                ]
            );

            // Attach 7 to 10 amenities per room
            $amenityIds = $allAmenities->random(min($allAmenities->count(), rand(7, 10)))->pluck('id');
            $room->amenities()->sync($amenityIds);

            // Attach 4 unique photos per room
            $room->images()->delete();
            foreach ($r['images'] as $idx => $imgUrl) {
                $room->images()->create([
                    'image_path' => $imgUrl,
                    'is_primary' => $idx === 0,
                    'sort_order' => $idx,
                ]);
            }
        }
    }
}
