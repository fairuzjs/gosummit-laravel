<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user as author
        $author = User::where('role', 'admin')->first();
        
        if (!$author) {
            $this->command->error('No admin user found. Please create an admin user first.');
            return;
        }

        $newsData = [
            // INFORMASI (5 berita)
            [
                'title' => 'Gunung Semeru Dibuka Kembali untuk Pendaki',
                'category' => 'info',
                'excerpt' => 'Setelah ditutup selama 6 bulan, Gunung Semeru kembali dibuka untuk aktivitas pendakian dengan protokol keselamatan yang ketat.',
                'content' => '<h2>Pembukaan Kembali Gunung Semeru</h2><p>Taman Nasional Bromo Tengger Semeru (TNBTS) resmi membuka kembali jalur pendakian Gunung Semeru untuk umum mulai tanggal 1 Desember 2024. Pembukaan ini dilakukan setelah evaluasi menyeluruh terhadap kondisi gunung dan jalur pendakian.</p><h3>Protokol Keselamatan</h3><ul><li>Wajib menggunakan helm safety</li><li>Maksimal 500 pendaki per hari</li><li>Pendakian hanya sampai Mahameru</li><li>Wajib lapor ke pos ranger</li></ul><p>Para pendaki diharapkan untuk selalu mematuhi protokol keselamatan dan mengikuti arahan dari petugas TNBTS.</p>',
            ],
            [
                'title' => 'Jalur Pendakian Gunung Rinjani Diperbaiki',
                'category' => 'info',
                'excerpt' => 'Pemerintah mengalokasikan dana untuk perbaikan jalur pendakian Gunung Rinjani yang rusak akibat gempa bumi.',
                'content' => '<h2>Perbaikan Infrastruktur Jalur Pendakian</h2><p>Balai Taman Nasional Gunung Rinjani melakukan perbaikan jalur pendakian yang rusak akibat gempa bumi tahun lalu. Perbaikan meliputi jalur Sembalun dan Senaru.</p><p>Diperkirakan perbaikan akan selesai dalam 3 bulan ke depan. Selama masa perbaikan, jalur tetap dapat digunakan dengan pengawasan ekstra dari petugas.</p>',
            ],
            [
                'title' => 'Kuota Pendakian Gunung Gede Pangrango Ditambah',
                'category' => 'info',
                'excerpt' => 'Taman Nasional Gunung Gede Pangrango menambah kuota pendakian menjadi 800 orang per hari untuk mengakomodasi tingginya minat pendaki.',
                'content' => '<h2>Penambahan Kuota Pendakian</h2><p>Melihat tingginya minat masyarakat untuk mendaki Gunung Gede Pangrango, pihak pengelola memutuskan untuk menambah kuota pendakian dari 600 menjadi 800 orang per hari.</p><p>Penambahan kuota ini juga diikuti dengan penambahan petugas ranger dan fasilitas pendukung di jalur pendakian.</p>',
            ],
            [
                'title' => 'Sistem Booking Online Gunung Merapi Diluncurkan',
                'category' => 'info',
                'excerpt' => 'Pendakian Gunung Merapi kini dapat dipesan secara online melalui platform resmi untuk memudahkan pendaki.',
                'content' => '<h2>Digitalisasi Sistem Booking</h2><p>Balai Taman Nasional Gunung Merapi meluncurkan sistem booking online untuk memudahkan pendaki dalam melakukan reservasi. Sistem ini terintegrasi dengan pembayaran digital dan e-ticket.</p><p>Pendaki tidak perlu lagi datang langsung ke basecamp untuk melakukan pendaftaran.</p>',
            ],
            [
                'title' => 'Penemuan Jalur Baru di Gunung Lawu',
                'category' => 'info',
                'excerpt' => 'Tim ekspedisi menemukan jalur pendakian baru di Gunung Lawu yang lebih aman dan memiliki pemandangan yang indah.',
                'content' => '<h2>Jalur Pendakian Baru</h2><p>Tim ekspedisi dari komunitas pecinta alam menemukan jalur pendakian baru di sisi timur Gunung Lawu. Jalur ini dinilai lebih aman dan memiliki pemandangan yang lebih indah dibanding jalur existing.</p><p>Jalur baru ini akan segera diresmikan setelah dilakukan pemetaan dan pembangunan infrastruktur pendukung.</p>',
            ],

            // TIPS & TRIK (5 berita)
            [
                'title' => '10 Tips Mendaki Gunung untuk Pemula',
                'category' => 'tips',
                'excerpt' => 'Panduan lengkap untuk pemula yang ingin memulai hobi mendaki gunung dengan aman dan menyenangkan.',
                'content' => '<h2>Tips Mendaki untuk Pemula</h2><h3>1. Persiapan Fisik</h3><p>Latihan fisik minimal 2 minggu sebelum pendakian. Fokus pada cardio dan kekuatan kaki.</p><h3>2. Perlengkapan Wajib</h3><ul><li>Carrier 40-50L</li><li>Sleeping bag</li><li>Matras</li><li>Jaket windproof</li><li>Headlamp</li></ul><h3>3. Makanan dan Minuman</h3><p>Bawa makanan tinggi kalori dan air minimal 2 liter per hari.</p>',
            ],
            [
                'title' => 'Cara Memilih Sepatu Gunung yang Tepat',
                'category' => 'tips',
                'excerpt' => 'Sepatu adalah investasi penting dalam mendaki. Pelajari cara memilih sepatu gunung yang sesuai dengan kebutuhan Anda.',
                'content' => '<h2>Memilih Sepatu Gunung</h2><p>Sepatu gunung yang tepat akan membuat perjalanan Anda lebih nyaman dan aman. Berikut tips memilihnya:</p><h3>Jenis Sepatu</h3><ul><li>Low-cut: untuk hiking ringan</li><li>Mid-cut: untuk trekking menengah</li><li>High-cut: untuk pendakian berat</li></ul><h3>Material</h3><p>Pilih material yang waterproof dan breathable seperti Gore-Tex.</p>',
            ],
            [
                'title' => 'Teknik Packing Carrier yang Efisien',
                'category' => 'tips',
                'excerpt' => 'Belajar teknik packing carrier yang benar untuk mengurangi beban dan meningkatkan kenyamanan saat mendaki.',
                'content' => '<h2>Teknik Packing Carrier</h2><p>Packing yang benar akan membuat carrier terasa lebih ringan dan seimbang.</p><h3>Prinsip Dasar</h3><ul><li>Barang berat di tengah dekat punggung</li><li>Barang ringan di atas dan bawah</li><li>Barang sering dipakai di kompartemen luar</li></ul><p>Gunakan stuff sack untuk mengorganisir barang berdasarkan kategori.</p>',
            ],
            [
                'title' => 'Mengatasi Altitude Sickness saat Mendaki',
                'category' => 'tips',
                'excerpt' => 'Altitude sickness adalah masalah umum saat mendaki gunung tinggi. Ketahui cara mencegah dan mengatasinya.',
                'content' => '<h2>Altitude Sickness</h2><p>Altitude sickness terjadi karena tubuh belum beradaptasi dengan ketinggian. Gejalanya meliputi pusing, mual, dan sesak napas.</p><h3>Pencegahan</h3><ul><li>Aklimatisasi bertahap</li><li>Minum air yang cukup</li><li>Hindari alkohol</li><li>Istirahat yang cukup</li></ul><h3>Penanganan</h3><p>Jika gejala muncul, segera turun ke ketinggian yang lebih rendah dan istirahat.</p>',
            ],
            [
                'title' => 'Fotografi Landscape di Gunung: Tips dan Trik',
                'category' => 'tips',
                'excerpt' => 'Dapatkan foto landscape gunung yang menakjubkan dengan tips fotografi dari fotografer profesional.',
                'content' => '<h2>Fotografi Landscape Gunung</h2><h3>Golden Hour</h3><p>Waktu terbaik untuk foto landscape adalah saat sunrise dan sunset. Cahaya yang lembut menghasilkan warna yang dramatis.</p><h3>Komposisi</h3><ul><li>Rule of thirds</li><li>Leading lines</li><li>Foreground interest</li></ul><h3>Equipment</h3><p>Bawa tripod untuk long exposure dan wide-angle lens untuk menangkap pemandangan luas.</p>',
            ],

            // PERATURAN (5 berita)
            [
                'title' => 'Peraturan Baru: Wajib Helm Safety di Gunung Semeru',
                'category' => 'regulation',
                'excerpt' => 'Mulai 1 Januari 2025, semua pendaki Gunung Semeru wajib menggunakan helm safety selama pendakian.',
                'content' => '<h2>Peraturan Helm Safety</h2><p>Taman Nasional Bromo Tengger Semeru mewajibkan penggunaan helm safety untuk semua pendaki mulai 1 Januari 2025. Peraturan ini dibuat untuk meningkatkan keselamatan pendaki.</p><h3>Sanksi</h3><p>Pendaki yang tidak menggunakan helm akan dikenakan sanksi berupa:</p><ul><li>Teguran tertulis</li><li>Denda Rp 500.000</li><li>Tidak diizinkan melanjutkan pendakian</li></ul>',
            ],
            [
                'title' => 'Larangan Pendakian di Musim Hujan untuk Beberapa Gunung',
                'category' => 'regulation',
                'excerpt' => 'Pemerintah melarang pendakian di beberapa gunung selama musim hujan untuk keselamatan pendaki.',
                'content' => '<h2>Larangan Pendakian Musim Hujan</h2><p>Kementerian Lingkungan Hidup dan Kehutanan melarang pendakian di beberapa gunung selama musim hujan (November - Maret).</p><h3>Gunung yang Ditutup</h3><ul><li>Gunung Semeru</li><li>Gunung Raung</li><li>Gunung Kerinci</li></ul><p>Penutupan ini dilakukan untuk menghindari risiko longsor dan cuaca ekstrem.</p>',
            ],
            [
                'title' => 'Aturan Baru Pengelolaan Sampah di Gunung',
                'category' => 'regulation',
                'excerpt' => 'Pendaki wajib membawa turun semua sampah yang dibawa. Pelanggaran akan dikenakan denda hingga Rp 5 juta.',
                'content' => '<h2>Carry In Carry Out</h2><p>Semua taman nasional menerapkan sistem "Carry In Carry Out" - semua sampah yang dibawa naik harus dibawa turun.</p><h3>Jenis Sampah</h3><ul><li>Sampah organik</li><li>Sampah anorganik</li><li>Sampah B3</li></ul><h3>Sanksi</h3><p>Pelanggaran akan dikenakan denda Rp 1 juta - Rp 5 juta tergantung jenis dan jumlah sampah.</p>',
            ],
            [
                'title' => 'Pembatasan Jumlah Pendaki di Puncak Gunung',
                'category' => 'regulation',
                'excerpt' => 'Untuk menjaga kelestarian alam, beberapa gunung membatasi jumlah pendaki yang boleh berada di puncak secara bersamaan.',
                'content' => '<h2>Pembatasan Kapasitas Puncak</h2><p>Beberapa gunung populer menerapkan pembatasan jumlah pendaki di puncak untuk mengurangi dampak lingkungan.</p><h3>Sistem Antrian</h3><p>Pendaki harus mengikuti sistem antrian dan dibatasi waktu di puncak maksimal 30 menit.</p><p>Hal ini diterapkan di Gunung Prau, Gunung Merbabu, dan Gunung Sindoro.</p>',
            ],
            [
                'title' => 'Wajib Surat Keterangan Sehat untuk Pendakian',
                'category' => 'regulation',
                'excerpt' => 'Pendaki wajib membawa surat keterangan sehat dari dokter untuk mendaki gunung dengan ketinggian di atas 3000 mdpl.',
                'content' => '<h2>Surat Keterangan Sehat</h2><p>Untuk meningkatkan keselamatan, pendaki gunung dengan ketinggian di atas 3000 mdpl wajib membawa surat keterangan sehat.</p><h3>Pemeriksaan Kesehatan</h3><p>Surat keterangan harus mencakup:</p><ul><li>Tekanan darah</li><li>Kondisi jantung</li><li>Kondisi paru-paru</li><li>Riwayat penyakit</li></ul><p>Surat berlaku maksimal 1 bulan sejak diterbitkan.</p>',
            ],

            // EVENT (5 berita)
            [
                'title' => 'Festival Pendakian Gunung Indonesia 2025',
                'category' => 'event',
                'excerpt' => 'Event tahunan terbesar pecinta alam Indonesia akan diselenggarakan di Gunung Merbabu pada Februari 2025.',
                'content' => '<h2>Festival Pendakian 2025</h2><p>Festival Pendakian Gunung Indonesia 2025 akan diselenggarakan di Gunung Merbabu pada 15-17 Februari 2025. Event ini diikuti oleh ribuan pendaki dari seluruh Indonesia.</p><h3>Kegiatan</h3><ul><li>Pendakian massal</li><li>Workshop survival</li><li>Pameran alat outdoor</li><li>Konser musik</li></ul><h3>Pendaftaran</h3><p>Pendaftaran dibuka mulai 1 Januari 2025 melalui website resmi.</p>',
            ],
            [
                'title' => 'Trail Running Competition Gunung Bromo',
                'category' => 'event',
                'excerpt' => 'Kompetisi lari gunung pertama di Gunung Bromo dengan rute menantang sepanjang 21 km.',
                'content' => '<h2>Bromo Trail Running 2025</h2><p>Kompetisi trail running pertama di kawasan Gunung Bromo akan diselenggarakan pada 20 Maret 2025. Rute sepanjang 21 km melewati savana dan lautan pasir.</p><h3>Kategori</h3><ul><li>21K Elite</li><li>21K Fun Run</li><li>10K Beginner</li></ul><h3>Hadiah</h3><p>Total hadiah Rp 100 juta untuk semua kategori.</p>',
            ],
            [
                'title' => 'Clean Up Mountain Day 2025',
                'category' => 'event',
                'excerpt' => 'Aksi bersih-bersih gunung serentak di 50 gunung di Indonesia untuk menjaga kelestarian alam.',
                'content' => '<h2>Clean Up Mountain Day</h2><p>Gerakan nasional membersihkan gunung dari sampah akan dilaksanakan serentak di 50 gunung pada 5 April 2025.</p><h3>Cara Berpartisipasi</h3><p>Daftar melalui komunitas pecinta alam di daerah masing-masing. Semua peserta akan mendapat sertifikat dan merchandise.</p><h3>Target</h3><p>Mengumpulkan minimal 10 ton sampah dari seluruh gunung.</p>',
            ],
            [
                'title' => 'Workshop Survival dan Navigasi Gunung',
                'category' => 'event',
                'excerpt' => 'Pelatihan survival dan navigasi gunung untuk pendaki pemula dan menengah akan diadakan di Gunung Gede.',
                'content' => '<h2>Workshop Survival</h2><p>Pelatihan intensif 3 hari 2 malam di Gunung Gede Pangrango pada 10-12 Mei 2025.</p><h3>Materi</h3><ul><li>Navigasi dengan kompas dan GPS</li><li>Teknik survival</li><li>Pertolongan pertama</li><li>Membuat shelter darurat</li></ul><h3>Instruktur</h3><p>Dipandu oleh instruktur bersertifikat dari FASI dan SAR.</p>',
            ],
            [
                'title' => 'Sunrise Yoga di Puncak Gunung Prau',
                'category' => 'event',
                'excerpt' => 'Event yoga massal di puncak Gunung Prau sambil menikmati sunrise yang spektakuler.',
                'content' => '<h2>Sunrise Yoga Event</h2><p>Event yoga massal pertama di puncak Gunung Prau akan diselenggarakan pada 25 Juni 2025. Peserta akan melakukan yoga sambil menikmati sunrise.</p><h3>Rundown</h3><ul><li>03:00 - Start pendakian</li><li>05:30 - Yoga session</li><li>07:00 - Breakfast</li><li>09:00 - Turun gunung</li></ul><h3>Fasilitas</h3><p>Yoga mat, breakfast, guide, dan sertifikat.</p>',
            ],
        ];

        foreach ($newsData as $index => $data) {
            News::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'category' => $data['category'],
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'author_id' => $author->id,
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
                'views' => rand(50, 500),
            ]);
        }

        $this->command->info('Successfully created 20 news articles (5 per category)');
    }
}
