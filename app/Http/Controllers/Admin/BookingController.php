<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings for the admin.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'mountain', 'trailRoute', 'members']);

        // Universal search across booking code, mountain, trail, and member name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Search booking code
                $q->where('booking_code', 'like', '%' . $searchTerm . '%')
                  // Search mountain name
                  ->orWhereHas('mountain', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  })
                  // Search trail route name
                  ->orWhereHas('trailRoute', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  })
                  // Search member name
                  ->orWhereHas('members', function($q) use ($searchTerm) {
                      $q->where('full_name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('check_in_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('check_in_date', '<=', $request->date_to);
        }

        // Default ordering
        $bookings = $query->orderByRaw("FIELD(status, 'pending', 'paid', 'checked_in', 'completed', 'failed')")
                          ->orderBy('check_in_date', 'asc')
                          ->paginate(15)
                          ->appends($request->except('page'));
                            
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Handle the check-in confirmation by the admin.
     */
    public function checkIn(Booking $booking)
    {
        // Hanya izinkan check-in untuk booking dengan status PAID
        if ($booking->status !== 'paid') {
            return redirect()->back()->with('error', 'Booking harus berstatus PAID untuk dikonfirmasi Check-in.');
        }

        $booking->update([
            'status' => 'checked_in',
        ]);

        return redirect()->back()->with('success', 'Booking dengan kode ' . $booking->booking_code . ' berhasil dikonfirmasi Check-in.');
    }
    
    /**
     * Handle the completion status update (hike finished) by admin.
     */
    public function complete(Booking $booking)
    {
        // Izinkan penandaan selesai untuk status PAID (jika lupa check-in) atau CHECKED_IN
        if (!in_array($booking->status, ['paid', 'checked_in'])) {
            return redirect()->back()->with('error', 'Booking harus berstatus PAID atau CHECKED_IN untuk ditandai Selesai.');
        }

        $booking->update([
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Booking dengan kode ' . $booking->booking_code . ' berhasil ditandai Selesai.');
    }
}