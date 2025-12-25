<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========================================
        // 1. BUAT USERS (Admin, Validator, Customer)
        // ========================================
        
        echo "🔹 Membuat Users...\n";
        
        // Admin
        $admin = \App\Models\User::create([
            'name' => 'Admin System',
            'email' => 'admin@tiketgunung.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        // Validator
        $validator = \App\Models\User::create([
            'name' => 'Validator Pendakian',
            'email' => 'validator@tiketgunung.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'validator',
            'email_verified_at' => now(),
        ]);
        
        // 20 Customers
        $customers = [];
        for ($i = 1; $i <= 20; $i++) {
            $customers[] = \App\Models\User::create([
                'name' => "Customer $i",
                'email' => "customer$i@example.com",
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);
        }
        
        echo "✅ Users berhasil dibuat: 1 Admin, 1 Validator, 20 Customers\n\n";
        
        // ========================================
        // 2. BUAT 15 MOUNTAINS
        // ========================================
        
        echo "🔹 Membuat Mountains...\n";
        
        $mountainsData = [
            ['name' => 'Gunung Semeru', 'location' => 'Jawa Timur', 'ticket_price' => 50000, 'height' => 3676, 'description' => 'Gunung tertinggi di Pulau Jawa dengan pemandangan Mahameru yang megah'],
            ['name' => 'Gunung Rinjani', 'location' => 'Lombok, NTB', 'ticket_price' => 75000, 'height' => 3726, 'description' => 'Gunung dengan danau Segara Anak yang memukau'],
            ['name' => 'Gunung Bromo', 'location' => 'Jawa Timur', 'ticket_price' => 35000, 'height' => 2329, 'description' => 'Gunung berapi aktif dengan sunrise terbaik di Indonesia'],
            ['name' => 'Gunung Merapi', 'location' => 'Yogyakarta', 'ticket_price' => 45000, 'height' => 2930, 'description' => 'Gunung berapi paling aktif di Indonesia'],
            ['name' => 'Gunung Kerinci', 'location' => 'Jambi', 'ticket_price' => 60000, 'height' => 3805, 'description' => 'Gunung tertinggi di Sumatera'],
            ['name' => 'Gunung Gede', 'location' => 'Jawa Barat', 'ticket_price' => 40000, 'height' => 2958, 'description' => 'Gunung dengan jalur pendakian yang menantang'],
            ['name' => 'Gunung Lawu', 'location' => 'Jawa Tengah', 'ticket_price' => 35000, 'height' => 3265, 'description' => 'Gunung dengan situs bersejarah Candi Cetho'],
            ['name' => 'Gunung Merbabu', 'location' => 'Jawa Tengah', 'ticket_price' => 40000, 'height' => 3145, 'description' => 'Gunung dengan padang savana yang luas'],
            ['name' => 'Gunung Sumbing', 'location' => 'Jawa Tengah', 'ticket_price' => 38000, 'height' => 3371, 'description' => 'Gunung kembar Gunung Sindoro'],
            ['name' => 'Gunung Sindoro', 'location' => 'Jawa Tengah', 'ticket_price' => 38000, 'height' => 3153, 'description' => 'Gunung dengan jalur terjal dan menantang'],
            ['name' => 'Gunung Papandayan', 'location' => 'Jawa Barat', 'ticket_price' => 30000, 'height' => 2665, 'description' => 'Gunung dengan kawah aktif yang indah'],
            ['name' => 'Gunung Prau', 'location' => 'Jawa Tengah', 'ticket_price' => 25000, 'height' => 2565, 'description' => 'Gunung dengan bukit teletubbies yang terkenal'],
            ['name' => 'Gunung Ciremai', 'location' => 'Jawa Barat', 'ticket_price' => 35000, 'height' => 3078, 'description' => 'Gunung tertinggi di Jawa Barat'],
            ['name' => 'Gunung Slamet', 'location' => 'Jawa Tengah', 'ticket_price' => 40000, 'height' => 3428, 'description' => 'Gunung dengan jalur pendakian panjang'],
            ['name' => 'Gunung Arjuno', 'location' => 'Jawa Timur', 'ticket_price' => 35000, 'height' => 3339, 'description' => 'Gunung dengan pemandangan Welirang yang indah'],
        ];
        
        $mountains = [];
        foreach ($mountainsData as $data) {
            $data['daily_quota'] = rand(80, 150);
            $data['status'] = 'open';
            $mountains[] = \App\Models\Mountain::create($data);
        }
        
        echo "✅ 15 Mountains berhasil dibuat\n\n";
        
        // ========================================
        // 3. BUAT TRAIL ROUTES (2-3 per gunung)
        // ========================================
        
        echo "🔹 Membuat Trail Routes...\n";
        
        $routeNames = [
            'Jalur Utara',
            'Jalur Selatan', 
            'Jalur Timur',
            'Jalur Barat',
            'Via Cemoro Lawang',
            'Via Ranupane',
        ];
        
        $trailCount = 0;
        foreach ($mountains as $mountain) {
            $numRoutes = rand(2, 3);
            for ($i = 0; $i < $numRoutes; $i++) {
                $routeName = $routeNames[$i % count($routeNames)];
                \App\Models\TrailRoute::create([
                    'mountain_id' => $mountain->id,
                    'name' => $routeName,
                    'description' => "Jalur pendakian $routeName untuk {$mountain->name}",
                    'status' => 'open',
                ]);
                $trailCount++;
            }
        }
        
        echo "✅ $trailCount Trail Routes berhasil dibuat\n\n";
        
        // ========================================
        // 4. BUAT QUOTAS (15 hari ke depan untuk setiap gunung)
        // ========================================
        
        echo "🔹 Membuat Quotas...\n";
        
        $quotaCount = 0;
        foreach ($mountains as $mountain) {
            for ($day = 0; $day < 15; $day++) {
                $date = now()->addDays($day)->format('Y-m-d');
                \App\Models\Quota::create([
                    'mountain_id' => $mountain->id,
                    'date' => $date,
                    'total_quota' => $mountain->daily_quota,
                    'remaining_quota' => rand(50, $mountain->daily_quota),
                ]);
                $quotaCount++;
            }
        }
        
        echo "✅ $quotaCount Quotas berhasil dibuat (15 hari x 15 gunung)\n\n";
        
        // ========================================
        // 5. BUAT 15 VOUCHERS
        // ========================================
        
        echo "🔹 Membuat Vouchers...\n";
        
        $vouchersData = [
            ['code' => 'DISKON10', 'name' => 'Diskon 10%', 'type' => 'percentage', 'value' => 10, 'usage_limit' => 100],
            ['code' => 'DISKON20', 'name' => 'Diskon 20%', 'type' => 'percentage', 'value' => 20, 'usage_limit' => 50],
            ['code' => 'HEMAT15K', 'name' => 'Hemat 15 Ribu', 'type' => 'fixed', 'value' => 15000, 'usage_limit' => 75],
            ['code' => 'HEMAT25K', 'name' => 'Hemat 25 Ribu', 'type' => 'fixed', 'value' => 25000, 'usage_limit' => 30],
            ['code' => 'NEWUSER', 'name' => 'Diskon User Baru', 'type' => 'percentage', 'value' => 15, 'usage_limit' => 200],
            ['code' => 'WEEKEND', 'name' => 'Promo Weekend', 'type' => 'percentage', 'value' => 12, 'usage_limit' => 80],
            ['code' => 'SPECIAL50', 'name' => 'Special 50K', 'type' => 'fixed', 'value' => 50000, 'usage_limit' => 10],
            ['code' => 'RAMADAN', 'name' => 'Promo Ramadan', 'type' => 'percentage', 'value' => 25, 'usage_limit' => 60],
            ['code' => 'MERDEKA', 'name' => 'Promo Kemerdekaan', 'type' => 'percentage', 'value' => 17, 'usage_limit' => 100],
            ['code' => 'TAHUNBARU', 'name' => 'Tahun Baru', 'type' => 'percentage', 'value' => 30, 'usage_limit' => 40],
            ['code' => 'FLASH10K', 'name' => 'Flash Sale 10K', 'type' => 'fixed', 'value' => 10000, 'usage_limit' => 150],
            ['code' => 'MEMBER5', 'name' => 'Member Diskon 5%', 'type' => 'percentage', 'value' => 5, 'usage_limit' => 0],
            ['code' => 'HEMAT5K', 'name' => 'Hemat 5 Ribu', 'type' => 'fixed', 'value' => 5000, 'usage_limit' => 200],
            ['code' => 'PROMO30', 'name' => 'Promo 30%', 'type' => 'percentage', 'value' => 30, 'usage_limit' => 20],
            ['code' => 'GRATIS', 'name' => 'Gratis Ongkir', 'type' => 'fixed', 'value' => 20000, 'usage_limit' => 50],
        ];
        
        $vouchers = [];
        foreach ($vouchersData as $data) {
            $data['valid_from'] = now()->subDays(rand(1, 10));
            $data['valid_until'] = now()->addDays(rand(30, 90));
            $data['used_count'] = 0;
            $data['user_usage_limit'] = rand(1, 3);
            $data['created_by'] = $admin->id;
            $vouchers[] = \App\Models\Voucher::create($data);
        }
        
        echo "✅ 15 Vouchers berhasil dibuat\n\n";
        
        // ========================================
        // 6. BUAT 20 BOOKINGS dengan berbagai status
        // ========================================
        
        echo "🔹 Membuat Bookings...\n";
        
        $statuses = ['pending', 'paid', 'checked_in', 'completed', 'failed'];
        $bookings = [];
        
        for ($i = 1; $i <= 20; $i++) {
            $customer = $customers[array_rand($customers)];
            $mountain = $mountains[array_rand($mountains)];
            $trailRoute = \App\Models\TrailRoute::where('mountain_id', $mountain->id)->inRandomOrder()->first();
            $checkInDate = now()->addDays(rand(1, 30))->format('Y-m-d');
            $memberCount = rand(1, 5);
            $totalPrice = $mountain->ticket_price * $memberCount;
            
            // Random status
            $status = $statuses[array_rand($statuses)];
            
            $booking = \App\Models\Booking::create([
                'user_id' => $customer->id,
                'mountain_id' => $mountain->id,
                'trail_route_id' => $trailRoute->id,
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkInDate,
                'member_count' => $memberCount,
                'total_price' => $totalPrice,
                'status' => $status,
                'booking_code' => 'BKN-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                'midtrans_order_id' => $status !== 'pending' ? 'MT-' . time() . '-' . $i : null,
            ]);
            
            $bookings[] = $booking;
            
            // Buat booking members
            for ($m = 1; $m <= $memberCount; $m++) {
                \App\Models\BookingMember::create([
                    'booking_id' => $booking->id,
                    'full_name' => $m === 1 ? $customer->name : "Anggota $m - Booking $i",
                    'identity_number' => '3201' . rand(100000000000, 999999999999),
                ]);
            }
        }
        
        echo "✅ 20 Bookings berhasil dibuat dengan berbagai status\n";
        echo "✅ Booking Members berhasil dibuat\n\n";
        
        // ========================================
        // 7. BUAT VOUCHER USAGES (untuk booking yang paid)
        // ========================================
        
        echo "🔹 Membuat Voucher Usages...\n";
        
        $usageCount = 0;
        foreach ($bookings as $booking) {
            if (in_array($booking->status, ['paid', 'checked_in', 'completed']) && rand(0, 1)) {
                $voucher = $vouchers[array_rand($vouchers)];
                $discountAmount = $voucher->calculateDiscount($booking->total_price);
                
                \App\Models\VoucherUsage::create([
                    'user_id' => $booking->user_id,
                    'voucher_id' => $voucher->id,
                    'booking_id' => $booking->id,
                    'discount_amount' => $discountAmount,
                ]);
                
                $voucher->increment('used_count');
                $usageCount++;
            }
        }
        
        echo "✅ $usageCount Voucher Usages berhasil dibuat\n\n";
        
        // ========================================
        // 8. BUAT NOTIFICATIONS
        // ========================================
        
        echo "🔹 Membuat Notifications...\n";
        
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Notification::create([
                'title' => "Notifikasi $i",
                'message' => "Ini adalah notifikasi dummy nomor $i untuk testing",
                'type' => ['info', 'warning', 'success'][rand(0, 2)],
            ]);
        }
        
        echo "✅ 5 Notifications berhasil dibuat\n\n";
        
        // ========================================
        // SELESAI
        // ========================================
        
        echo "🎉 SEEDING SELESAI!\n";
        echo "=====================================\n";
        echo "📊 RINGKASAN:\n";
        echo "- Users: " . \App\Models\User::count() . " (1 Admin, 1 Validator, 20 Customers)\n";
        echo "- Mountains: " . \App\Models\Mountain::count() . "\n";
        echo "- Trail Routes: " . \App\Models\TrailRoute::count() . "\n";
        echo "- Quotas: " . \App\Models\Quota::count() . "\n";
        echo "- Bookings: " . \App\Models\Booking::count() . "\n";
        echo "- Booking Members: " . \App\Models\BookingMember::count() . "\n";
        echo "- Vouchers: " . \App\Models\Voucher::count() . "\n";
        echo "- Voucher Usages: " . \App\Models\VoucherUsage::count() . "\n";
        echo "- Notifications: " . \App\Models\Notification::count() . "\n";
        echo "=====================================\n";
        echo "✅ Database siap digunakan!\n";
        echo "📧 Login Admin: admin@tiketgunung.com / password\n";
        echo "📧 Login Validator: validator@tiketgunung.com / password\n";
        echo "📧 Login Customer: customer1@example.com / password (sampai customer20)\n";
    }
}
