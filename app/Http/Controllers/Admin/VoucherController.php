<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest; 

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $validated = $request->validated();

        $validated['created_by'] = auth()->id();

        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $validated = $request->validated();

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus.');
    }

        public function report()
    {
        // Ambil semua voucher beserta jumlah penggunaannya
        $vouchers = Voucher::withCount('voucherUsages')->orderBy('created_at', 'desc')->get();

        // Statistik keseluruhan
        $totalVouchers = Voucher::count();
        $totalUsage = VoucherUsage::count();
        $totalDiscountGiven = VoucherUsage::sum('discount_amount');

        // Top 5 voucher berdasarkan jumlah digunakan
        $topVouchersByUsage = Voucher::withCount('voucherUsages')
                                    ->orderBy('voucher_usages_count', 'desc')
                                    ->limit(5)
                                    ->get();

        // Top 5 voucher berdasarkan total diskon diberikan
        $topVouchersByDiscount = VoucherUsage::select('voucher_id', DB::raw('SUM(discount_amount) as total_discount'))
                                              ->groupBy('voucher_id')
                                              ->with('voucher')
                                              ->orderBy('total_discount', 'desc')
                                              ->limit(5)
                                              ->get();

        return view('admin.vouchers.report', compact(
            'vouchers',
            'totalVouchers',
            'totalUsage',
            'totalDiscountGiven',
            'topVouchersByUsage',
            'topVouchersByDiscount'
        ));
    }
}