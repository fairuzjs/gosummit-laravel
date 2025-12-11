<?php

use App\Http\Controllers\BookingController; 
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\QuotaController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\TrailRouteController;
use App\Http\Controllers\MountainController as AdminMountainController; 
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Notification as CustomNotification;

// --- RUTE PUBLIK ---
Route::get('/', [PageController::class, 'index'])->name('home');

// Language Switching
Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// Google OAuth Routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Route Autocomplete (Ditaruh sebelum route parameter {mountain} agar tidak bentrok)
Route::get('/mountains/autocomplete', [AdminMountainController::class, 'autocomplete'])->name('mountains.autocomplete');

Route::get('/mountains', [PageController::class, 'list'])->name('mountains.list');
Route::get('/mountains/{mountain}', [PageController::class, 'show'])->name('mountains.show');

// News Page
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');


// --- RUTE YANG MEMBUTUHKAN LOGIN ---
Route::middleware('auth')->group(function () {

    Route::get('/bookings/{booking}/pay', [PaymentController::class, 'show'])->name('bookings.pay');

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'validator') {
            return redirect()->route('validator.bookings.index');
        }
        
        // 1. Booking Aktif (Paid & Checked In)
        $activeBooking = $user->bookings()
            ->whereIn('status', ['paid', 'checked_in']) 
            ->where('check_in_date', '>=', now()->startOfDay())
            ->orderBy('check_in_date', 'asc')
            ->first();

        // 2. Semua Booking (Riwayat)
        $allBookings = $user->bookings()->with('mountain')->latest()->limit(3)->get();
        
        // 3. Histori Pembayaran (Paid, Checked In, Completed)
        $paidQuery = $user->bookings()
            ->whereIn('status', ['paid', 'checked_in', 'completed']);
            
        $paidBookings = $paidQuery->with('mountain')->latest()->limit(3)->get();
        $totalPaidCount = $paidQuery->count();
        $paidCount = $paidQuery->clone()->count();
        
        // START FIX: Ambil notifikasi DENGAN filter status delete per user
        $deletedNotificationIds = DB::table('user_notification_statuses')
            ->where('user_id', $user->id)
            ->where('is_deleted', true)
            ->pluck('notification_id');
            
        // Ambil semua notifikasi terbaru yang ID-nya TIDAK ADA di daftar ID yang dihapus user
        $notifications = CustomNotification::latest()
            ->whereNotIn('id', $deletedNotificationIds)
            ->get();
        // END FIX
        
        return view('dashboard', compact('activeBooking', 'allBookings', 'paidBookings', 'notifications', 'totalPaidCount', 'paidCount'));
    })->middleware('verified')->name('dashboard');

    // Rute Booking User (List)
    Route::get('/bookings', function () {
        $bookings = auth()->user()->bookings()->with('mountain')->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    })->name('bookings.index');

    // Rute Pembayaran User (List) dengan Filter Tanggal
    Route::get('/payments', function (Request $request) {
        $query = auth()->user()->bookings()
            ->whereIn('status', ['paid', 'checked_in', 'completed'])
            ->with('mountain');
        
        // Filter tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('check_in_date', '>=', $request->start_date);
        }
        
        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('check_in_date', '<=', $request->end_date);
        }
        
        $payments = $query->latest('check_in_date')->paginate(10)->appends($request->only(['start_date', 'end_date']));
        
        return view('payments.index', compact('payments'));
    })->name('payments.index');
    Route::get('/bookings/{booking}/invoice', [PaymentController::class, 'downloadInvoice'])->name('bookings.invoice.download');
    Route::get('/bookings/{booking}/ticket', [PaymentController::class, 'downloadTicket'])->name('bookings.ticket.download');
    
    // --- RUTE MANAJEMEN NOTIFIKASI BARU (LOGIKA FIXED UNTUK USER-SPECIFIC DELETE) ---
    
    // FIX: Menghapus SATU notifikasi (menandai sebagai deleted untuk user ini)
    Route::delete('/notifications/{notification}', function ($notificationId) {
        $user = auth()->user();

        DB::table('user_notification_statuses')->updateOrInsert(
            ['user_id' => $user->id, 'notification_id' => $notificationId],
            ['is_deleted' => true, 'updated_at' => now(), 'created_at' => now()]
        );
        
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    })->name('notifications.delete');

    // FIX: Menghapus SEMUA notifikasi (menandai semua notifikasi aktif sebagai deleted untuk user ini)
    Route::delete('/notifications', function () {
        $user = auth()->user();
        $allNotificationIds = CustomNotification::pluck('id');

        $data = $allNotificationIds->map(function ($id) use ($user) {
            return [
                'user_id' => $user->id,
                'notification_id' => $id,
                'is_deleted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
        
        // Gunakan upsert untuk memasukkan status deleted untuk semua notifikasi yang ada
        DB::table('user_notification_statuses')->upsert(
            $data,
            ['user_id', 'notification_id'], // Unique key
            ['is_deleted', 'updated_at']    // Columns to update
        );

        return back()->with('success', 'Semua notifikasi berhasil dihapus untuk Anda!');
    })->name('notifications.deleteAll'); 
});


// --- RUTE PANEL ADMIN ---
Route::middleware(['auth:admin', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin Redirect
    Route::get('/dashboard', function() {
        return redirect()->route('admin.analytics.index');
    })->name('dashboard');

    // Mountains Admin
    Route::get('/mountains/autocomplete', [AdminMountainController::class, 'autocomplete'])->name('mountains.autocomplete');
    Route::resource('mountains', AdminMountainController::class)->except(['show']);

    // Manajemen Notifikasi (Ini masih mengelola notifikasi global di tabel Notifications)
    Route::resource('notifications', NotificationController::class)->only(['index', 'store', 'destroy']);

    // Manajemen Kuota
    Route::get('/mountains/{mountain}/quotas', [QuotaController::class, 'index'])->name('mountains.quotas.index');
    Route::post('/mountains/{mountain}/quotas', [QuotaController::class, 'store'])->name('mountains.quotas.store');

    // Manajemen Voucher
    Route::resource('vouchers', VoucherController::class)->except(['show']);
    Route::get('/vouchers/report', [VoucherController::class, 'report'])->name('vouchers.report');

    // Trail Routes
    Route::post('/mountains/{mountain}/trail-routes', [TrailRouteController::class, 'store'])->name('trail-routes.store');
    Route::patch('/mountains/{mountain}/trail-routes/{trail_route}', [TrailRouteController::class, 'toggleStatus'])->name('trail-routes.toggle');
    Route::delete('/mountains/{mountain}/trail-routes/{trail_route}', [TrailRouteController::class, 'destroy'])->name('trail-routes.destroy');

    // --- MANAJEMEN BOOKING ADMIN ---
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/check-in', [AdminBookingController::class, 'checkIn'])->name('bookings.checkIn');
    Route::patch('/bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
    
    // --- ANALYTICS DASHBOARD ---
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    
    // --- NEWS MANAGEMENT ---
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
    Route::post('/news/{news}/toggle-publish', [App\Http\Controllers\Admin\NewsController::class, 'togglePublish'])->name('news.toggle-publish');
});


// --- RUTE PANEL VALIDATOR ---
Route::middleware(['auth', 'can:validator'])->prefix('validator')->name('validator.')->group(function () {
    
    Route::get('/dashboard', function() {
        return redirect()->route('validator.bookings.index');
    })->name('dashboard');

    Route::get('/bookings', [App\Http\Controllers\Validator\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/check-in', [App\Http\Controllers\Validator\BookingController::class, 'checkIn'])->name('bookings.checkIn');
});


// --- RUTE WEBHOOK ---
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook'])->name('midtrans.webhook');

// --- RUTE AUTH ---
require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
