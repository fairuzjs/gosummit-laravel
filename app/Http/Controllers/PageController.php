<?php

namespace App\Http\Controllers;

use App\Models\Mountain;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan 3 gunung terbaru untuk landing page.
     */
    public function index()
    {
        // 1. Ambil total jumlah gunung yang statusnya 'open' (PERUBAHAN DITAMBAHKAN)
        $totalMountains = Mountain::where('status', 'open')->count();
        
        // 2. Ambil 3 gunung terbaru untuk "Destinasi Populer"
        $mountains = Mountain::where('status', 'open')
                             ->latest()
                             ->take(6)
                             ->get();
        
        // 3. Ambil top 5 leaderboard sepanjang masa untuk widget
        $topClimbers = app(\App\Services\LeaderboardService::class)->getAllTimeLeaderboard(5);
        
        // Kirim $mountains, $totalMountains, dan $topClimbers ke view
        return view('mountains.index', compact('mountains', 'totalMountains', 'topClimbers')); 
    }

    /**
     * Menampilkan semua gunung dengan fitur search.
     */
    public function list(Request $request)
    {
        // Ambil semua gunung dengan search berdasarkan nama atau lokasi
        $mountains = Mountain::where('status', 'open')
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9); // 9 gunung per halaman (grid 3x3)
        
        return view('mountains.list', compact('mountains'));
    }

    /**
     * Menampilkan detail satu gunung untuk publik.
     */
    public function show(Mountain $mountain)
    {
        $quotas = $mountain->quotas()
                           ->where('date', '>=', now()->startOfDay())
                           ->where('date', '<=', now()->addDays(30))
                           ->orderBy('date', 'asc')
                           ->get();

        return view('mountains.show', compact('mountain', 'quotas'));
    }
}