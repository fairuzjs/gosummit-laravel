@extends('layouts.clean')

@section('content')
<!-- Date Filter Form -->
<div class="bg-gradient-to-r from-purple-50 to-blue-50 p-4 rounded-xl shadow-sm mb-6 border border-purple-100">
    <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Tanggal Mulai
            </label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
        </div>
        
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Tanggal Akhir
            </label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter
            </button>
            
            @if(request('start_date') || request('end_date'))
            <a href="{{ route('payments.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Reset
            </a>
            @endif
        </div>
    </form>
    
    @if(request('start_date') || request('end_date'))
    <div class="mt-3 pt-3 border-t border-purple-200 text-sm text-gray-700">
        <strong class="text-purple-700">Filter aktif:</strong>
        @if(request('start_date'))
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-medium ml-2">
                Dari {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
            </span>
        @endif
        @if(request('end_date'))
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-medium ml-2">
                Sampai {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
            </span>
        @endif
    </div>
    @endif
</div>

<!-- Mobile Card View -->
<div class="lg:hidden space-y-4">
    @forelse($payments as $booking)
        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-4 border border-green-100 shadow-sm">
            <!-- Header Card -->
            <div class="flex items-center justify-between mb-3 pb-3 border-b border-green-200">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                    <span class="font-mono text-xs font-bold text-gray-800">{{ $booking->booking_code }}</span>
                </div>
                <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full shadow-sm bg-gradient-to-r from-green-400 to-green-600 text-white">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <!-- Nama Gunung -->
            <div class="mb-3">
                <p class="text-base font-bold text-gray-900">{{ $booking->mountain->name }}</p>
            </div>

            <!-- Info Row 1 -->
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <div class="flex items-center space-x-1 mb-1">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs text-gray-600">Tanggal</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</p>
                </div>
                <div>
                    <div class="flex items-center space-x-1 mb-1">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-xs text-gray-600">Total</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($booking->total_price) }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2 mt-4 pt-3 border-t border-green-200">
                <a href="{{ route('bookings.invoice.download', $booking) }}" target="_blank" 
                   class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-green-500 to-teal-600 text-white text-sm font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Invoice
                </a>
            </div>
        </div>
    @empty
        <div class="bg-gray-50 rounded-xl p-8 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-gray-500 text-sm font-medium mb-2">Belum ada pembayaran</p>
            <p class="text-gray-400 text-xs mb-4">Booking dan lakukan pembayaran untuk melihat riwayat di sini.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Booking Sekarang
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>

<!-- Desktop Table View -->
<div class="hidden lg:block overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-green-50 to-teal-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Kode Booking</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Gunung</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Tanggal Bayar</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Total</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Invoice</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($payments as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-600 rounded-full mr-2"></div>
                            <span class="font-mono text-sm font-semibold text-gray-700">{{ $booking->booking_code }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-gray-900">{{ $booking->mountain->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('d F Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($booking->total_price) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('bookings.invoice.download', $booking) }}" target="_blank" class="text-green-600 hover:text-green-900 underline">Unduh Invoice</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium mb-2">Belum ada pembayaran</p>
                            <p class="text-gray-400 text-sm mb-4">Booking dan lakukan pembayaran untuk melihat riwayat di sini.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Booking Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection