{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Bookings')
@section('header-title', 'Booking History')
@section('header-buttons')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.analytics.index') }}"
           class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
            <span class="hidden sm:inline">Back to Dashboard</span>
            <span class="sm:hidden">Back</span>
        </a>
    </div>
@endsection
@section('content')
<div class="space-y-8">
    <div class="p-4 sm:p-6 lg:p-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
        {{-- Search & Filter Section --}}
        <div class="mb-8">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="space-y-4">
                {{-- Universal Search Bar --}}
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Booking
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kode booking, gunung, jalur, atau nama ketua rombongan..." 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                    <p class="mt-1 text-xs text-gray-500">Contoh: BKN-12345ABC, Rinjani, Jalur Utara, atau nama pendaki</p>
                </div>

                {{-- Compact Filters Row --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    {{-- Status Filter --}}
                    <div>
                        <label for="status" class="block text-xs font-medium text-gray-700 mb-1.5">
                            <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status
                        </label>
                        <select name="status" 
                                id="status"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gray-700 mb-1.5">
                            <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Dari Tanggal
                        </label>
                        <input type="date" 
                               name="date_from" 
                               id="date_from"
                               value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gray-700 mb-1.5">
                            <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Sampai Tanggal
                        </label>
                        <input type="date" 
                               name="date_to" 
                               id="date_to"
                               value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-2">
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        <span class="inline-flex items-center px-3 py-2.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Aktif
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <h3 class="text-xl font-bold text-gray-900 mb-6">Booking List</h3>

        {{-- Desktop Table View --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Kode Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Tgl Naik</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Gunung (Jalur)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Ketua Rombongan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-purple-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-mono text-sm font-bold text-gray-700">{{ $booking->booking_code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $booking->mountain->name ?? 'N/A' }} 
                                <span class="text-xs text-gray-500">({{ $booking->trailRoute->name ?? 'Umum' }})</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $booking->members->first()->full_name ?? $booking->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $booking->member_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'checked_in' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                    ][$booking->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                    @if($booking->status === 'checked_in')
                                        Confirm
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @if ($booking->status === 'paid')
                                        <form action="{{ route('admin.bookings.checkIn', $booking) }}" method="POST" onsubmit="return confirm('Konfirmasi Check-in untuk {{ $booking->booking_code }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @elseif ($booking->status === 'checked_in')
                                        <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" onsubmit="return confirm('Tandai Selesai untuk {{ $booking->booking_code }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                </svg>
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @elseif ($booking->status === 'completed')
                                        <span class="text-gray-400 text-xs italic">Selesai</span>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Menunggu Pembayaran</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium mb-2">Tidak ada data Booking ditemukan.</p>
                                    <p class="text-gray-400 text-sm">Booking baru akan muncul di sini setelah dibuat user.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="lg:hidden space-y-4">
            @forelse ($bookings as $booking)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                    {{-- Card Header --}}
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 px-4 py-3 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-mono text-sm font-bold text-gray-800">{{ $booking->booking_code }}</span>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                                </p>
                            </div>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'checked_in' => 'bg-indigo-100 text-indigo-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                ][$booking->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                @if($booking->status === 'checked_in')
                                    Confirm
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="px-4 py-3 space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Gunung & Jalur</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $booking->mountain->name ?? 'N/A' }}
                                <span class="text-xs text-gray-500 font-normal">({{ $booking->trailRoute->name ?? 'Umum' }})</span>
                            </p>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Ketua Rombongan</p>
                                <p class="text-sm text-gray-800">{{ $booking->members->first()->full_name ?? $booking->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">Jumlah</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $booking->member_count }} orang</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                        @if ($booking->status === 'paid')
                            <form action="{{ route('admin.bookings.checkIn', $booking) }}" method="POST" onsubmit="return confirm('Konfirmasi Check-in untuk {{ $booking->booking_code }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition">
                                    Konfirmasi Check-in
                                </button>
                            </form>
                        @elseif ($booking->status === 'checked_in')
                            <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" onsubmit="return confirm('Tandai Selesai untuk {{ $booking->booking_code }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    Tandai Selesai
                                </button>
                            </form>
                        @elseif ($booking->status === 'completed')
                            <div class="text-center py-2">
                                <span class="text-gray-500 text-sm italic">✓ Booking Selesai</span>
                            </div>
                        @else
                            <div class="text-center py-2">
                                <span class="text-gray-500 text-sm italic">Menunggu Pembayaran</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium mb-2">Tidak ada data Booking ditemukan.</p>
                        <p class="text-gray-400 text-sm">Booking baru akan muncul di sini setelah dibuat user.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection