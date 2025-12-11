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
     * atau yang sudah Check-In, mulai dari 7 hari yang lalu hingga masa mendatang.
     */
    public function index()
    {
        // Mendapatkan booking yang statusnya 'paid' (siap check-in) atau sudah 'checked_in'
        $bookings = Booking::with(['user', 'mountain', 'trailRoute'])
            ->whereIn('status', ['paid', 'checked_in'])
            
            // Perubahan: Hanya tampilkan booking dari 7 hari yang lalu hingga masa mendatang
            // Ini membantu validator mengakomodasi keterlambatan check-in
            ->whereDate('check_in_date', '>=', Carbon::today()->subDays(30))
            
            ->latest('check_in_date')
            ->paginate(10);

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
}