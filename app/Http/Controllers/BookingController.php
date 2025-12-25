<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Method store DIHAPUS karena aplikasi menggunakan Livewire (BookingForm)
     * untuk proses pembuatan booking agar data anggota dan voucher tersimpan dengan benar.
     */

    // --- TAMBAHKAN KODE INI (Method Pay) ---
    public function pay(Booking $booking)
    {
        // 1. Validasi: Pastikan user yang login adalah pemilik booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        // 2. Validasi: Pastikan booking belum dibayar (status 'pending' atau 'unpaid')
        // Sesuaikan 'pending' dengan status default di aplikasi Anda (misal: 'unpaid')
        if ($booking->status !== 'pending' && $booking->status !== 'unpaid') {
            return redirect()->route('bookings.index')
                ->with('error', 'Booking ini sudah dibayar atau tidak dapat diproses.');
        }

        // 3. Tampilkan halaman pembayaran (pastikan file view ini ada)
        return view('bookings.pay', compact('booking'));
    }
    // ----------------------------------------

    // Menandai booking selesai oleh User
    public function complete($id)
    {
        $booking = Booking::where('id', $id)
                         ->where('user_id', Auth::id()) // Validasi milik user sendiri
                         ->where('status', 'paid') // Hanya status paid
                         ->whereDate('check_in_date', '<', Carbon::today()) // Hanya jika tanggal sudah lewat
                         ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan atau belum memenuhi syarat untuk diselesaikan.');
        }

        $booking->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Booking berhasil ditandai sebagai selesai! Terima kasih telah mendaki bersama kami.');
    }
}