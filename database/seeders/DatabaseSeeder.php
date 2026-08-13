<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AmenitySeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            FacilitySeeder::class,
            ServiceSeeder::class,
            PromoSeeder::class,
            GallerySeeder::class,
            BookingAndPaymentSeeder::class,
        ]);
    }
}
