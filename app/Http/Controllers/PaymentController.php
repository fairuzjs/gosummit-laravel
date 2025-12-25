<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use App\Models\Quota;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingPaid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Menampilkan halaman pembayaran (Midtrans Snap)
     */
    public function show(Booking $booking)
    {
        // Validasi keamanan kepemilikan
        if ($booking->user_id !== auth()->id()) {
            abort(404);
        }

        // --- LOGIC BARU: CEK KEDALUWARSA ---
        // Jika status masih pending DAN (Hari ini >= Tanggal Check In)
        // Artinya user telat bayar sampai hari H pendakian
        if ($booking->status == 'pending' && now()->startOfDay()->gte($booking->check_in_date)) {
            
            // Update status jadi canceled
            $booking->update(['status' => 'canceled']);

            // Redirect kembali dengan pesan error
            return redirect()->route('bookings.index')
                ->with('error', 'Booking telah kedaluwarsa karena melewati batas waktu pembayaran (H-1 Pendakian).');
        }

        // Pastikan status masih pending (jika sudah paid/canceled, jangan buka halaman bayar)
        if ($booking->status !== 'pending') {
             return redirect()->route('bookings.index');
        }
        // -----------------------------------

        // Buat order_id unik agar tidak bentrok di Midtrans jika user mencoba bayar ulang
        $uniqueOrderId = $booking->booking_code . '-' . uniqid();
        $booking->midtrans_order_id = $uniqueOrderId;
        $booking->save();

        // FIX: Pastikan gross_amount adalah INTEGER murni
        $grossAmount = (int) $booking->total_price;

        // Parameter transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId,
                'gross_amount' => $grossAmount, 
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
            // --- TAMBAHAN: Expiry Time ---
            // Link pembayaran akan kadaluwarsa dalam 24 jam (atau bisa disesuaikan)
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s T"),
                'unit' => 'hour',
                'duration' => 24
            ],
        ];

        try {
            // Ambil Snap Token
            $snapToken = Snap::getSnapToken($params);
            
            // FIX: Tentukan URL Library berdasarkan Environment (Sandbox/Production)
            $snapLibraryUrl = config('services.midtrans.is_production') 
                ? 'https://app.midtrans.com/snap/snap.js' 
                : 'https://app.sandbox.midtrans.com/snap/snap.js';

            // Tampilkan halaman pembayaran
            return view('bookings.pay', compact('booking', 'snapToken', 'snapLibraryUrl'));

        } catch (\Exception $e) {
            Log::error('Midtrans Token Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat sistem pembayaran. Cek konfigurasi Server Key.');
        }
    }

    /**
     * Webhook Midtrans untuk update status otomatis
     */
    public function webhook(Request $request)
    {
        // Log payload untuk debugging
        Log::info('Midtrans Webhook Payload:', $request->all());

        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        // Validasi Signature Key (Opsional tapi disarankan)
        if ($hashed !== $request->signature_key) {
             Log::error('Invalid Signature Key');
             // return response()->json(['message' => 'Invalid Signature'], 403);
        }

        DB::beginTransaction();
        try {
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;
            $orderId = $request->order_id;

            // Cari booking berdasarkan midtrans_order_id
            $booking = Booking::where('midtrans_order_id', $orderId)->lockForUpdate()->first();

            if (!$booking) {
                // Fallback ke logic lama (explode booking code)
                $bookingCode = explode('-', $orderId)[0] . '-' . explode('-', $orderId)[1]; // Asumsi format BKN-XXXX-TIMESTAMP
                $booking = Booking::where('booking_code', explode('-', $orderId)[0] . '-' . explode('-', $orderId)[1])->first();
                
                // Jika masih tidak ketemu, coba cari exact match booking_code (siapa tahu format lama)
                if (!$booking) {
                     $booking = Booking::where('booking_code', explode('-', $orderId)[0])->first();
                }
            }

            if (!$booking) {
                Log::error("Booking not found for Order ID: $orderId");
                return response()->json(['message' => 'Booking not found'], 404);
            }
            
            Log::info("Processing booking: {$booking->booking_code} with status: $transactionStatus");

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($fraudStatus == 'accept') {
                    $booking->status = 'paid';
                    $booking->save();
                    
                    // Kirim email dalam blok try-catch terpisah agar tidak membatalkan transaksi jika gagal
                    try {
                        Mail::to($booking->user->email)->send(new BookingPaid($booking));
                    } catch (\Exception $mailError) {
                        Log::error('Gagal kirim email: ' . $mailError->getMessage());
                        // Lanjutkan proses, jangan throw error
                    }
                }
            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $booking->status = 'failed';
                $booking->save();

                // Kembalikan Kuota
                $quota = Quota::where('mountain_id', $booking->mountain_id)
                              ->where('date', $booking->check_in_date)
                              ->first();
                
                if ($quota) {
                    $quota->increment('remaining_quota', $booking->member_count);
                }

                // Kembalikan Voucher
                $voucherUsage = VoucherUsage::where('booking_id', $booking->id)->first();
                if ($voucherUsage) {
                    if ($voucherUsage->voucher) {
                        $voucherUsage->voucher->decrement('used_count');
                    }
                    $voucherUsage->delete();
                }
            } elseif ($transactionStatus == 'pending') {
                // Do nothing / keep pending
            }

            DB::commit();
            return response()->json(['message' => 'Notification processed successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            // Return 200 agar Midtrans tidak mencoba kirim ulang terus menerus jika error logic internal
            // Atau return 500 jika ingin Midtrans retry
            return response()->json(['message' => 'Error processing notification: ' . $e->getMessage()], 500);
        }
    }

    public function downloadTicket(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($booking->status, ['paid', 'checked_in', 'completed'])) {
            abort(403, 'E-Ticket hanya tersedia setelah pembayaran lunas.');
        }

        $pdf = Pdf::loadView('tickets.eticket', ['booking' => $booking]);
        return $pdf->stream('e-ticket-' . $booking->booking_code . '.pdf');
    }

    public function downloadInvoice(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id || !in_array($booking->status, ['paid', 'checked_in', 'completed'])) {
            abort(403, 'Unauthorized action or invoice not available.');
        }

        $pdf = Pdf::loadView('invoices.invoice', ['booking' => $booking]);
        return $pdf->download('invoice-' . $booking->booking_code . '.pdf');
    }
}