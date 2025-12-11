@extends('layouts.clean')

@section('content')
<div class="lg:hidden space-y-4">
    @forelse($bookings as $booking)
        <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-4 border border-purple-100 shadow-sm">
            <div class="flex items-center justify-between mb-3 pb-3 border-b border-purple-200">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-purple-600 rounded-full"></div>
                    <span class="font-mono text-xs font-bold text-gray-800">{{ $booking->booking_code }}</span>
                </div>
                <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full shadow-sm
                    @if(in_array($booking->status, ['paid', 'checked_in'])) bg-gradient-to-r from-green-400 to-green-600 text-white
                    @elseif($booking->status == 'pending') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white
                    @elseif($booking->status == 'completed') bg-gradient-to-r from-blue-500 to-blue-700 text-white
                    @elseif($booking->status == 'cancelled') bg-gradient-to-r from-red-400 to-red-600 text-white
                    @else bg-gradient-to-r from-red-400 to-red-600 text-white @endif">
                    @if($booking->status === 'checked_in')
                        Confirm
                    @else
                        {{ ucfirst($booking->status) }}
                    @endif
                </span>
            </div>

            <div class="mb-3">
                <p class="text-base font-bold text-gray-900 ml-">{{ $booking->mountain->name }}</p>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <div class="flex items-center space-x-1 mb-1">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs text-gray-600">Tanggal</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
                </div>
                <div>
                    <div class="flex items-center space-x-1 mb-1">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-xs text-gray-600">Jumlah</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ $booking->member_count }} orang</p>
                </div>
            </div>

            <div class="space-y-2 mt-4 pt-3 border-t border-purple-200">
                @if (in_array($booking->status, ['paid', 'checked_in', 'completed']))
                    <a href="{{ route('bookings.ticket.download', $booking) }}" target="_blank" 
                       class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white text-sm font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Download E-Ticket
                    </a>
                    @if(\Carbon\Carbon::parse($booking->check_in_date)->lt(\Carbon\Carbon::today()))

                    @endif
                @elseif ($booking->status == 'pending')
                    {{-- LOGIC BARU: Cek Kedaluwarsa di Mobile --}}
                    @if(\Carbon\Carbon::now()->startOfDay()->lt($booking->check_in_date))
                        <a href="{{ route('bookings.pay', $booking) }}" 
                           class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-700 text-white text-sm font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Bayar Sekarang
                        </a>
                    @else
                        <div class="w-full px-4 py-2.5 bg-gray-200 text-gray-500 text-sm font-bold rounded-lg text-center cursor-not-allowed">
                            Expired (Lewat Tanggal)
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @empty
        <div class="bg-gray-50 rounded-xl p-8 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-gray-500 text-sm font-medium mb-2">Belum ada booking</p>
            <p class="text-gray-400 text-xs mb-4">Mulai petualangan Anda dengan booking gunung pertama!</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Booking Sekarang
            </a>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>

<div class="hidden lg:block overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Kode Booking</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Gunung</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Tanggal Naik</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Jumlah</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Keterangan</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-purple-600 rounded-full mr-2"></div>
                            <span class="font-mono text-sm font-semibold text-gray-700">{{ $booking->booking_code }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-bold text-gray-900">{{ $booking->mountain->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d F Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            {{ $booking->member_count }} orang
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-4 py-1.5 inline-flex items-center text-xs leading-5 font-bold rounded-full shadow-sm
                            @if(in_array($booking->status, ['paid', 'checked_in'])) bg-gradient-to-r from-green-400 to-green-600 text-white status-badge
                            @elseif($booking->status == 'pending') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white status-badge
                            @elseif($booking->status == 'completed') bg-gradient-to-r from-blue-500 to-blue-700 text-white status-badge
                            @elseif($booking->status == 'cancelled') bg-gradient-to-r from-red-400 to-red-600 text-white
                            @else bg-gradient-to-r from-gray-400 to-gray-600 text-white @endif">
                            @if($booking->status === 'checked_in')
                                Confirm
                            @else
                                {{ ucfirst($booking->status) }}
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if (in_array($booking->status, ['paid', 'checked_in', 'completed']))
                            <a href="{{ route('bookings.ticket.download', $booking) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                E-Ticket
                            </a>
                        @elseif ($booking->status == 'pending')
                            {{-- LOGIC BARU: Cek Kedaluwarsa di Desktop --}}
                            @if(\Carbon\Carbon::now()->startOfDay()->lt($booking->check_in_date))
                                <a href="{{ route('bookings.pay', $booking) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Bayar Sekarang
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Expired
                                </span>
                            @endif
                        @else
                            <span class="text-gray-400 italic">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium mb-2">Belum ada booking</p>
                            <p class="text-gray-400 text-sm mb-4">Mulai petualangan Anda dengan booking gunung pertama!</p>
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