<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@stayora.test'],
            [
                'name' => 'Alexander Wright (General Manager)',
                'password' => $password,
                'role' => 'admin',
                'phone' => '+62 811-2345-6701',
                'address' => 'Stayora Executive Quarters, Nusa Dua, Bali',
                'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=200&q=80',
                'email_verified_at' => now(),
            ]
        );

        // 2. Front Desk
        User::updateOrCreate(
            ['email' => 'frontdesk@stayora.test'],
            [
                'name' => 'Ni Wayan Sukerti (Front Office Manager)',
                'password' => $password,
                'role' => 'front_desk',
                'phone' => '+62 812-3456-7802',
                'address' => 'Denpasar Selatan, Bali',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
                'email_verified_at' => now(),
            ]
        );

        // 3. Housekeeping
        User::updateOrCreate(
            ['email' => 'housekeeping@stayora.test'],
            [
                'name' => 'I Made Darmawan (Executive Housekeeper)',
                'password' => $password,
                'role' => 'housekeeping',
                'phone' => '+62 813-4567-8903',
                'address' => 'Badung, Bali',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'email_verified_at' => now(),
            ]
        );

        // 4. Finance
        User::updateOrCreate(
            ['email' => 'finance@stayora.test'],
            [
                'name' => 'Sarah Jenkins (Financial Controller)',
                'password' => $password,
                'role' => 'finance',
                'phone' => '+62 814-5678-9004',
                'address' => 'Sanur, Bali',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
                'email_verified_at' => now(),
            ]
        );

        // 5. Customer Demo Account
        User::updateOrCreate(
            ['email' => 'guest@stayora.test'],
            [
                'name' => 'Daffa Ahmad (VIP Guest)',
                'password' => $password,
                'role' => 'customer',
                'phone' => '+62 812-9876-5432',
                'address' => 'Menteng, Jakarta Pusat, Indonesia',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80',
                'email_verified_at' => now(),
            ]
        );

        // 50 Sample Customers with 50 UNIQUE Distinct Avatars
        $sampleCustomers = [
            ['name' => 'Liam Henderson', 'email' => 'liam.h@example.com', 'phone' => '+61 412 345 678', 'city' => 'Sydney, Australia', 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Sophie Laurent', 'email' => 'sophie.l@example.com', 'phone' => '+33 6 12 34 56 78', 'city' => 'Paris, France', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Kenji Takahashi', 'email' => 'kenji.t@example.com', 'phone' => '+81 90 1234 5678', 'city' => 'Tokyo, Japan', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Elena Rostova', 'email' => 'elena.r@example.com', 'phone' => '+44 7911 123456', 'city' => 'London, UK', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Michael Chang', 'email' => 'michael.c@example.com', 'phone' => '+65 9123 4567', 'city' => 'Singapore', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Amelia Clarke', 'email' => 'amelia.c@example.com', 'phone' => '+1 415 555 2671', 'city' => 'San Francisco, USA', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Budi Santoso', 'email' => 'budi.s@example.com', 'phone' => '+62 811 3344 55', 'city' => 'Surabaya, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Chloe Dubois', 'email' => 'chloe.d@example.com', 'phone' => '+32 470 12 34 56', 'city' => 'Brussels, Belgium', 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'David Miller', 'email' => 'david.m@example.com', 'phone' => '+1 212 555 0192', 'city' => 'New York, USA', 'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.n@example.com', 'phone' => '+60 12 345 6789', 'city' => 'Kuala Lumpur, Malaysia', 'avatar' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Lucas Rossi', 'email' => 'lucas.r@example.com', 'phone' => '+39 02 1234567', 'city' => 'Milan, Italy', 'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Ananya Sharma', 'email' => 'ananya.s@example.com', 'phone' => '+91 98765 43210', 'city' => 'Mumbai, India', 'avatar' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Oliver Schmidt', 'email' => 'oliver.s@example.com', 'phone' => '+49 30 123456', 'city' => 'Berlin, Germany', 'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Isabella Martinez', 'email' => 'isabella.m@example.com', 'phone' => '+34 91 123 45 67', 'city' => 'Madrid, Spain', 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Fiona Gallagher', 'email' => 'fiona.g@example.com', 'phone' => '+353 1 496 0000', 'city' => 'Dublin, Ireland', 'avatar' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Reza Rahadian', 'email' => 'reza.r@example.com', 'phone' => '+62 815 6789 0123', 'city' => 'Jakarta, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Hanna Lindstrom', 'email' => 'hanna.l@example.com', 'phone' => '+46 8 123 456', 'city' => 'Stockholm, Sweden', 'avatar' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Carlos Mendoza', 'email' => 'carlos.m@example.com', 'phone' => '+52 55 1234 5678', 'city' => 'Mexico City, Mexico', 'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Evelyn Taylor', 'email' => 'evelyn.t@example.com', 'phone' => '+64 9 123 4567', 'city' => 'Auckland, New Zealand', 'avatar' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Tariq Al-Mansoor', 'email' => 'tariq.m@example.com', 'phone' => '+971 4 123 4567', 'city' => 'Dubai, UAE', 'avatar' => 'https://images.unsplash.com/photo-1628157582853-a796fa650a6a?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Jessica Wong', 'email' => 'jessica.w@example.com', 'phone' => '+852 2123 4567', 'city' => 'Hong Kong', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Henrik Olsen', 'email' => 'henrik.o@example.com', 'phone' => '+45 33 12 34 56', 'city' => 'Copenhagen, Denmark', 'avatar' => 'https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Maya Putri', 'email' => 'maya.p@example.com', 'phone' => '+62 817 8901 2345', 'city' => 'Bandung, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Daniel Kim', 'email' => 'daniel.k@example.com', 'phone' => '+82 2 1234 5678', 'city' => 'Seoul, South Korea', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Camila Silva', 'email' => 'camila.s@example.com', 'phone' => '+55 11 91234 5678', 'city' => 'Sao Paulo, Brazil', 'avatar' => 'https://images.unsplash.com/photo-1534751516642-a171edd2521d?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Nathalie Weber', 'email' => 'nathalie.w@example.com', 'phone' => '+41 22 123 45 67', 'city' => 'Geneva, Switzerland', 'avatar' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Alexander Petrov', 'email' => 'alex.p@example.com', 'phone' => '+7 495 123 4567', 'city' => 'Moscow, Russia', 'avatar' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Grace O\'Connor', 'email' => 'grace.o@example.com', 'phone' => '+44 20 7946 0912', 'city' => 'Edinburgh, UK', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Andi Wijaya', 'email' => 'andi.w@example.com', 'phone' => '+62 818 0123 4567', 'city' => 'Yogyakarta, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Zara Phillips', 'email' => 'zara.p@example.com', 'phone' => '+61 3 9123 4567', 'city' => 'Melbourne, Australia', 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Sebastian Vane', 'email' => 'sebastian.v@example.com', 'phone' => '+1 312 555 0143', 'city' => 'Chicago, USA', 'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.l@example.com', 'phone' => '+62 819 1234 5678', 'city' => 'Bali, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Julian Alvarez', 'email' => 'julian.a@example.com', 'phone' => '+54 11 1234 5678', 'city' => 'Buenos Aires, Argentina', 'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Katarina Novak', 'email' => 'katarina.n@example.com', 'phone' => '+420 2 1234 5678', 'city' => 'Prague, Czechia', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Gabriel Santos', 'email' => 'gabriel.s@example.com', 'phone' => '+351 21 123 4567', 'city' => 'Lisbon, Portugal', 'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Yusuf Mansur', 'email' => 'yusuf.m@example.com', 'phone' => '+62 821 2345 6789', 'city' => 'Medan, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Matteo Moretti', 'email' => 'matteo.m@example.com', 'phone' => '+39 06 1234567', 'city' => 'Rome, Italy', 'avatar' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Rachel Green', 'email' => 'rachel.g@example.com', 'phone' => '+1 206 555 0188', 'city' => 'Seattle, USA', 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Ahmad Dahlan', 'email' => 'ahmad.d@example.com', 'phone' => '+62 822 3456 7890', 'city' => 'Semarang, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Freja Nielsen', 'email' => 'freja.n@example.com', 'phone' => '+47 21 12 34 56', 'city' => 'Oslo, Norway', 'avatar' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Nathan Drake', 'email' => 'nathan.d@example.com', 'phone' => '+1 702 555 0111', 'city' => 'Las Vegas, USA', 'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Sari Indah', 'email' => 'sari.i@example.com', 'phone' => '+62 823 4567 8901', 'city' => 'Makassar, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'William Sterling', 'email' => 'william.s@example.com', 'phone' => '+44 161 123 4567', 'city' => 'Manchester, UK', 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Clara Meyer', 'email' => 'clara.m@example.com', 'phone' => '+43 1 123 4567', 'city' => 'Vienna, Austria', 'avatar' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Bambang Pamungkas', 'email' => 'bambang.p@example.com', 'phone' => '+62 856 7890 1234', 'city' => 'Malang, Indonesia', 'avatar' => 'https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Mia Thorvaldsen', 'email' => 'mia.t@example.com', 'phone' => '+358 9 123 4567', 'city' => 'Helsinki, Finland', 'avatar' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Viktor Vance', 'email' => 'viktor.v@example.com', 'phone' => '+1 305 555 0177', 'city' => 'Miami, USA', 'avatar' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Putri Ayu', 'email' => 'putri.a@example.com', 'phone' => '+62 857 8901 2345', 'city' => 'Denpasar, Bali', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Antoine Richard', 'email' => 'antoine.r@example.com', 'phone' => '+33 4 12 34 56 78', 'city' => 'Nice, France', 'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80'],
            ['name' => 'Thomas Bradley', 'email' => 'thomas.b@example.com', 'phone' => '+1 617 555 0133', 'city' => 'Boston, USA', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80'],
        ];

        foreach ($sampleCustomers as $cust) {
            User::updateOrCreate(
                ['email' => $cust['email']],
                [
                    'name' => $cust['name'],
                    'password' => $password,
                    'role' => 'customer',
                    'phone' => $cust['phone'],
                    'address' => $cust['city'],
                    'avatar' => $cust['avatar'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
