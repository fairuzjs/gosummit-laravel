<?php

return [
    // Admin Dashboard
    'dashboard' => [
        'title' => 'Dasbor Admin',
        'welcome' => 'Selamat datang, Admin',
        'overview' => 'Ringkasan',
        'statistics' => 'Statistik',
    ],

    // Mountains Management
    'mountains' => [
        'title' => 'Manajemen Gunung',
        'add_mountain' => 'Tambah Gunung',
        'edit_mountain' => 'Edit Gunung',
        'mountain_name' => 'Nama Gunung',
        'location' => 'Lokasi',
        'height' => 'Ketinggian (MDPL)',
        'difficulty' => 'Tingkat Kesulitan',
        'description' => 'Deskripsi',
        'image' => 'Gambar',
        'price' => 'Harga Dasar',
        'status' => 'Status',
        'actions' => 'Aksi',
        'delete_confirm' => 'Apakah Anda yakin ingin menghapus gunung ini?',
    ],

    // Bookings Management
    'bookings' => [
        'title' => 'Manajemen Pemesanan',
        'booking_code' => 'Kode Booking',
        'customer' => 'Pelanggan',
        'mountain' => 'Gunung',
        'check_in_date' => 'Tanggal Check-in',
        'hikers' => 'Pendaki',
        'total' => 'Total',
        'status' => 'Status',
        'actions' => 'Aksi',
        'check_in' => 'Check In',
        'complete' => 'Selesai',
        'view_details' => 'Lihat Detail',
        'filter_status' => 'Filter berdasarkan Status',
        'filter_date' => 'Filter berdasarkan Tanggal',
        'export' => 'Ekspor',
    ],

    // Quotas Management
    'quotas' => [
        'title' => 'Manajemen Kuota',
        'date' => 'Tanggal',
        'quota' => 'Kuota',
        'booked' => 'Terpesan',
        'available' => 'Tersedia',
        'add_quota' => 'Tambah Kuota',
        'edit_quota' => 'Edit Kuota',
        'bulk_add' => 'Tambah Kuota Massal',
        'start_date' => 'Tanggal Mulai',
        'end_date' => 'Tanggal Akhir',
        'daily_quota' => 'Kuota Harian',
    ],

    // Vouchers Management
    'vouchers' => [
        'title' => 'Manajemen Voucher',
        'add_voucher' => 'Tambah Voucher',
        'edit_voucher' => 'Edit Voucher',
        'code' => 'Kode Voucher',
        'type' => 'Tipe',
        'value' => 'Nilai',
        'min_transaction' => 'Min. Transaksi',
        'max_discount' => 'Maks. Diskon',
        'usage_limit' => 'Batas Penggunaan',
        'used' => 'Digunakan',
        'valid_from' => 'Berlaku Dari',
        'valid_until' => 'Berlaku Hingga',
        'status' => 'Status',
        'percentage' => 'Persentase',
        'fixed' => 'Jumlah Tetap',
        'voucher_report' => 'Laporan Voucher',
    ],

    // Trail Routes Management
    'trail_routes' => [
        'title' => 'Jalur Pendakian',
        'add_route' => 'Tambah Jalur',
        'route_name' => 'Nama Jalur',
        'distance' => 'Jarak (km)',
        'estimated_time' => 'Estimasi Waktu (jam)',
        'difficulty' => 'Tingkat Kesulitan',
        'description' => 'Deskripsi',
        'status' => 'Status',
        'toggle_status' => 'Ubah Status',
    ],

    // Notifications Management
    'notifications' => [
        'title' => 'Manajemen Notifikasi',
        'add_notification' => 'Tambah Notifikasi',
        'notification_title' => 'Judul',
        'message' => 'Pesan',
        'type' => 'Tipe',
        'info' => 'Info',
        'warning' => 'Peringatan',
        'success' => 'Sukses',
        'danger' => 'Bahaya',
        'publish' => 'Publikasikan',
        'delete' => 'Hapus',
    ],

    // Analytics
    'analytics' => [
        'title' => 'Dasbor Analitik',
        'revenue' => 'Pendapatan',
        'total_bookings' => 'Total Pemesanan',
        'active_users' => 'Pengguna Aktif',
        'popular_mountains' => 'Gunung Populer',
        'revenue_chart' => 'Grafik Pendapatan',
        'bookings_chart' => 'Grafik Pemesanan',
        'this_month' => 'Bulan Ini',
        'last_month' => 'Bulan Lalu',
        'growth' => 'Pertumbuhan',
    ],

    // Validator
    'validator' => [
        'title' => 'Dasbor Validator',
        'scan_ticket' => 'Pindai Tiket',
        'manual_check_in' => 'Check-in Manual',
        'booking_code' => 'Kode Booking',
        'verify' => 'Verifikasi',
        'check_in_success' => 'Check-in berhasil',
        'invalid_booking' => 'Kode booking tidak valid',
        'already_checked_in' => 'Sudah check-in',
    ],
];
