<?php
// resources/views/validator/bookings/index.blade.php
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Gaya tambahan untuk responsif tabel */
        @media (max-width: 639px) {
            .mobile-table thead { display: none; }
            .mobile-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-bottom: 2px solid #e5e7eb;
                background-color: #fff;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                border-radius: 0.5rem;
            }
            .mobile-table tbody td {
                display: block;
                text-align: right !important;
                padding-left: 50% !important;
                position: relative;
                border: none !important;
            }
            .mobile-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: 600;
                color: #4b5563;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

<x-modern-header />

        {{-- KONTEN UTAMA --}}
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold">Validator Bookings</h3>
                                <div class="text-sm text-gray-600">
                                    Total: <span class="font-semibold">{{ $bookings->total() }}</span> booking
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 mobile-table">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Booking</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gunung</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($bookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" data-label="Kode Booking">
                                                {{ $booking->booking_code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Nama Customer">
                                                {{ $booking->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Gunung">
                                                {{ $booking->mountain->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Jalur">
                                                {{ $booking->trailRoute->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Tanggal">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Jumlah">
                                                {{ $booking->member_count }} orang
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap" data-label="Status">
                                                @if($booking->status === 'paid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Paid - Belum Konfirmasi
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Sudah Konfirmasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" data-label="Aksi">
                                                @if($booking->status === 'paid')
                                                    <form action="{{ route('validator.bookings.checkIn', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi untuk booking ini{{ $booking->booking_code }}?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    <p>Tidak ada booking yang perlu di konfirmasi saat ini</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <x-modern-footer />
    </div>
</body>
</html>