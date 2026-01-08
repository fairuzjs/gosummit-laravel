<?php

namespace App\Http\Controllers\Validator; // PASTIKAN NAMESPACE INI BENAR

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking yang siap untuk Check-In (status paid)
     * atau yang sudah Check-In dalam 24 jam terakhir.
     * Dibatasi maksimal 10 bookings untuk menghindari penumpukan.
     */
    public function index()
    {
        // Mendapatkan booking yang statusnya 'paid' (siap check-in) atau sudah 'checked_in'
        // Hanya tampilkan booking dalam 24 jam terakhir
        $bookings = Booking::with(['user', 'mountain', 'trailRoute'])
            ->whereIn('status', ['paid', 'checked_in'])
            
            // Filter: Hanya booking yang dibuat/diupdate dalam 24 jam terakhir
            ->where(function($query) {
                $query->where('created_at', '>=', Carbon::now()->subHours(24))
                      ->orWhere('updated_at', '>=', Carbon::now()->subHours(24));
            })
            
            // Urutkan berdasarkan yang terbaru
            ->latest('updated_at')
            
            // Batasi maksimal 10 bookings
            ->limit(10)
            ->get();

        return view('validator.bookings.index', compact('bookings'));
    }

    /**
     * Melakukan aksi check-in.
     */
    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'paid') {
            return back()->with('error', 'Booking sudah pernah di-check-in atau statusnya tidak valid.');
        }

        // Update status menjadi checked_in
        $booking->update([
            'status' => 'checked_in',
            // Jika Anda memiliki kolom 'actual_check_in_at' di tabel bookings, uncomment baris ini:
            // 'actual_check_in_at' => now(), 
        ]);

        return back()->with('success', "Check-in untuk booking {$booking->booking_code} berhasil!");
    }

    /**
     * Menampilkan halaman QR Code Scanner dengan recent scan history.
     */
    public function scanner()
    {
        // Ambil 5 booking terakhir yang di-check-in dalam 24 jam terakhir
        $recentScans = Booking::with(['user', 'mountain', 'trailRoute'])
            ->where('status', 'checked_in')
            ->where('updated_at', '>=', Carbon::now()->subHours(24))
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('validator.bookings.scanner', compact('recentScans'));
    }

    /**
     * Melakukan check-in via QR Code Scanner (AJAX).
     */
    public function scanCheckIn(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string'
        ]);

        // Cari booking berdasarkan booking code
        $booking = Booking::with(['user', 'mountain', 'trailRoute'])
            ->where('booking_code', $request->booking_code)
            ->first();

        // Validasi: Booking tidak ditemukan
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan! Kode: ' . $request->booking_code
            ], 404);
        }

        // Validasi: Booking bukan status 'paid'
        if ($booking->status !== 'paid') {
            $statusText = [
                'pending' => 'Belum dibayar',
                'checked_in' => 'Sudah check-in sebelumnya',
                'completed' => 'Sudah selesai',
                'failed' => 'Gagal/Dibatalkan'
            ][$booking->status] ?? 'Status tidak valid';

            return response()->json([
                'success' => false,
                'message' => "Booking {$booking->booking_code} tidak bisa di-check-in. Status: {$statusText}"
            ], 400);
        }

        // Validasi: Check-in date (opsional, bisa disesuaikan)
        $checkInDate = Carbon::parse($booking->check_in_date);
        $today = Carbon::today();
        $daysDifference = $today->diffInDays($checkInDate, false);

        // Jika check-in lebih dari 30 hari yang lalu atau lebih dari 7 hari ke depan
        if ($daysDifference < -30 || $daysDifference > 7) {
            return response()->json([
                'success' => false,
                'message' => "Tanggal check-in tidak sesuai. Booking untuk: " . $checkInDate->format('d M Y')
            ], 400);
        }

        // Update status menjadi checked_in
        $booking->update([
            'status' => 'checked_in',
            // 'actual_check_in_at' => now(), // Uncomment jika ada kolom ini
        ]);

        return response()->json([
            'success' => true,
            'message' => "Check-in berhasil untuk {$booking->booking_code}!",
            'booking' => [
                'booking_code' => $booking->booking_code,
                'mountain' => $booking->mountain->name,
                'trail' => $booking->trailRoute->name ?? 'Umum',
                'member_count' => $booking->member_count,
                'check_in_date' => $checkInDate->format('d M Y'),
                'customer_name' => $booking->user->name
            ]
        ]);
    }
}