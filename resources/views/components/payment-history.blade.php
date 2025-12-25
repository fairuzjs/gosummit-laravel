@props(['paidBookings', 'totalPaidCount']) <!-- Tambahkan totalPaidCount ke props -->

<div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl card-hover">
    <div class="p-6 sm:p-8 bg-white">
        <div class="flex justify-between items-center mb-6"> <!-- Bungkus header dan tombol dalam flex -->
            <h3 class="text-2xl font-bold text-gray-900">Riwayat Pembayaran</h3>
            <!-- Tombol "Lihat Semua" untuk Desktop -->
            @if($paidBookings->count() > 0 && $totalPaidCount > $paidBookings->count())
                <a href="{{ route('payments.index') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    Lihat Semua
                </a>
            @endif
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-green-50 to-teal-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">Kode Booking</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">Tanggal Bayar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">Invoice</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($paidBookings as $booking)
                        <tr class="hover:bg-green-50/50">
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-gray-700">{{ $booking->booking_code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->updated_at->format('d F Y') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($booking->total_price) }}</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <a href="{{ route('bookings.invoice.download', $booking) }}" class="text-green-600 hover:text-green-900 font-semibold">
                                    Unduh Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Belum ada pembayaran yang lunas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @forelse ($paidBookings as $booking)
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-4 shadow-sm border border-green-100">
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <span class="text-xs font-semibold text-green-700 uppercase">Kode Booking</span>
                            <span class="font-mono text-sm font-bold text-gray-900">{{ $booking->booking_code }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-green-200 pt-2">
                            <span class="text-xs font-semibold text-green-700 uppercase">Tanggal Bayar</span>
                            <span class="text-sm text-gray-700">{{ $booking->updated_at->format('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-green-200 pt-2">
                            <span class="text-xs font-semibold text-green-700 uppercase">Total</span>
                            <span class="text-base font-bold text-gray-900">Rp {{ number_format($booking->total_price) }}</span>
                        </div>
                        <div class="border-t border-green-200 pt-3">
                            <a href="{{ route('bookings.invoice.download', $booking) }}" 
                               class="block w-full text-center bg-gradient-to-r from-green-500 to-teal-600 text-white font-bold py-2.5 px-4 rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh Invoice
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm italic">Belum ada pembayaran yang lunas.</p>
                </div>
            @endforelse

            <!-- Tombol "Lihat Semua" untuk Mobile -->
            @if($paidBookings->count() > 0 && $totalPaidCount > $paidBookings->count())
                <div class="mt-4">
                    <a href="{{ route('payments.index') }}" class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-teal-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Lihat Semua Riwayat Pembayaran
                    </a>
                </div>
            @endif
        </div>

        <!-- Tombol "Lihat Semua" untuk Desktop (jika tombol tidak ingin di dalam flex header) -->
        <!--
        <div class="mt-4 hidden md:block">
            @if($paidBookings->count() > 0 && $totalPaidCount > $paidBookings->count())
                <a href="{{ route('payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    Lihat Semua Riwayat Pembayaran
                </a>
            @endif
        </div>
        -->
    </div>
</div>