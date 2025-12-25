<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Quota;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class QuotaController extends Controller
{
    /**
     * Menampilkan halaman untuk mengelola kuota gunung tertentu.
     */
public function index(Mountain $mountain)
{
    // Ambil kuota yang sudah ada untuk rentang tanggal yang ingin ditampilkan (misalnya 3 bulan ke depan)
    $existingQuotas = $mountain->quotas()
        ->where('date', '>=', now()->startOfMonth())
        ->where('date', '<=', now()->addMonths(3)->endOfMonth())
        ->orderBy('date', 'asc')
        ->get();

    // Siapkan data dalam format array untuk Flatpickr
    $availableDates = $existingQuotas->map(function ($quota) {
        return [
            'date' => $quota->date, // Format: Y-m-d
            'quota' => $quota->remaining_quota, // Asumsikan kolom ini adalah jumlah kuota yang tersisa
            'day_name' => \Carbon\Carbon::parse($quota->date)->translatedFormat('l'), // Nama hari opsional
        ];
    });

    // Kirim data ke view
    return view('admin.quotas.index', compact('mountain', 'availableDates'));
}

    /**
     * Menyimpan atau memperbarui kuota untuk rentang tanggal tertentu.
     */
    public function store(Request $request, Mountain $mountain)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'daily_quota' => 'required|integer|min:0',
        ]);

        // 2. Buat rentang tanggal menggunakan CarbonPeriod
        $period = CarbonPeriod::create($validated['start_date'], $validated['end_date']);

        // 3. Loop melalui setiap hari dalam rentang tersebut
        foreach ($period as $date) {
            // 4. Gunakan updateOrCreate untuk membuat atau memperbarui kuota
            Quota::updateOrCreate(
                [
                    'mountain_id' => $mountain->id,
                    'date' => $date->format('Y-m-d'),
                ],
                [
                    'remaining_quota' => $validated['daily_quota'],
                ]
            );
        }

        return redirect()->route('admin.mountains.quotas.index', $mountain)
                         ->with('success', 'Quotas have been set successfully for the selected date range.');
    }
}