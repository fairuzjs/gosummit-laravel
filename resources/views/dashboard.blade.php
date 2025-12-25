<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .card-hover:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); 
        }
        .main-content {
            min-height: calc(100vh - 20rem);
        }
        
        /* Timeline Styles */
        .timeline-item {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0.375rem;
            top: 2rem;
            bottom: -1rem;
            width: 2px;
            background: linear-gradient(to bottom, #e5e7eb, transparent);
        }
        .timeline-item:last-child::before {
            display: none;
        }
        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0.75rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            background: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        /* Custom Scrollbar for Navigation Tabs */
        .nav-scroll-container {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE 10+ */
        }
        .nav-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Webkit */
        }
/* Bottom Navigation Styles */
.bottom-nav {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
    z-index: 50;
    padding: 8px 16px;
    max-width: 360px;
    width: auto;
}
.nav-item {
    position: relative;
    flex: 0 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 6px 8px;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.nav-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    background: transparent;
    color: #9ca3af;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.nav-icon:hover {
    background: #f3f4f6;
    color: #6b7280;
}
.nav-icon-active {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 8px 20px -4px rgba(102, 126, 234, 0.4),
                0 4px 8px -2px rgba(102, 126, 234, 0.3);
    transform: translateY(-16px);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.nav-icon-active:hover {
    transform: translateY(-16px) scale(1.05);
    box-shadow: 0 12px 24px -4px rgba(102, 126, 234, 0.5),
                0 6px 12px -2px rgba(102, 126, 234, 0.4);
}
.nav-icon svg,
.nav-icon-active svg {
    width: 24px;
    height: 24px;
}
.nav-item:active .nav-icon,
.nav-item:active .nav-icon-active {
    transform: scale(0.95);
}
/* Add padding for bottom nav on all screens */
main {
    padding-bottom: 120px !important;
}
/* Hide pill tabs on all screens */
.top-tabs-nav {
    display: none;
}
/* Mobile adjustments */
@media (max-width: 767px) {
    .bottom-nav {
        bottom: 16px;
        left: 16px;
        right: 16px;
        transform: none;
        max-width: none;
        width: auto;
        padding: 8px 16px;
    }
    
    main {
        padding-bottom: 100px !important;
    }
}
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div x-data="{ activeTab: 'beranda' }" class="min-h-screen flex flex-col">
        <x-modern-header />
        <header class="hero-gradient text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold mb-2">{{ __('Selamat Datang') }}, {{ Auth::user()->name }}!</h1>
                        <p class="text-lg text-purple-100">{{ __('Kelola perjalanan pendakian Anda') }}</p>
                    </div>
                    <div class="hidden md:flex gap-8 mt-4 md:mt-0">
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $totalBookings ?? auth()->user()->bookings()->count() }}</p>
                            <p class="text-sm text-purple-200">{{ __('Total Trips') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $paidCount ?? auth()->user()->bookings()->whereIn('status', ['paid', 'checked_in', 'completed'])->count() }}</p>
                            <p class="text-sm text-purple-200">{{ __('Completed') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Floating Notification (Auto-hide after 3s) --}}
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 3000)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="fixed top-20 right-4 z-50 max-w-sm w-full sm:w-96"
                 role="alert">
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-xl shadow-2xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-bold text-green-800 text-sm">{{ __('Berhasil') }}!</p>
                            <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="ml-4 flex-shrink-0 text-green-600 hover:text-green-800 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <main class="py-8 flex-grow main-content">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                {{-- TAB BERANDA: Stats + Chart Only --}}
                <div x-show="activeTab === 'beranda'" x-transition class="space-y-8">
                    {{-- Statistics Cards - 2x2 Grid --}}
                    <section>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                            {{-- Total Booking --}}
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 card-hover">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">{{ $totalBookings ?? auth()->user()->bookings()->count() }}</p>
                                        <p class="text-xs sm:text-sm text-gray-500">{{ __('Total Booking') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Booking Lunas --}}
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 card-hover">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-2xl sm:text-3xl font-bold text-green-600 truncate">{{ $paidCount ?? auth()->user()->bookings()->where('status', 'paid')->count() }}</p>
                                        <p class="text-xs sm:text-sm text-gray-500">{{ __('Booking Lunas') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Booking Pending --}}
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 card-hover">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-2xl sm:text-3xl font-bold text-yellow-600 truncate">{{ $pendingCount ?? auth()->user()->bookings()->where('status', 'pending')->count() }}</p>
                                        <p class="text-xs sm:text-sm text-gray-500">{{ __('Pending') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Spent --}}
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 card-hover">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-lg sm:text-xl font-bold text-blue-600 truncate">Rp {{ number_format(auth()->user()->bookings()->whereIn('status', ['paid', 'checked_in', 'completed'])->sum('total_price') / 1000000, 1) }}K</p>
                                        <p class="text-xs sm:text-sm text-gray-500">{{ __('Total Spent') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Booking Statistics Chart --}}
                    <section class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ __('Statistik Booking') }}</h2>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="hidden sm:inline">{{ __('Trend') }}</span>
                            </div>
                        </div>
                        <div class="h-72 sm:h-80">
                            <canvas id="bookingChart"></canvas>
                        </div>
                    </section>
                </div>

                {{-- TAB BOOKING SAYA: Timeline View --}}
                <div x-show="activeTab === 'booking'" x-transition>
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ __('Booking Terbaru') }}</h2>
                            @if($allBookings->count() > 0 && auth()->user()->bookings()->count() > $allBookings->count())
                                <a href="{{ route('bookings.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm sm:text-base flex items-center gap-1">
                                    {{ __('Lihat Semua') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        
                        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                            @if($allBookings->count() > 0)
                                <div class="space-y-1">
                                    @foreach($allBookings->take(5) as $booking)
                                    <div class="timeline-item py-4">
                                        <div class="timeline-dot"></div>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-xl hover:bg-gray-50 transition">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="font-bold text-gray-900 truncate">{{ $booking->mountain->name }}</h4>
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full flex-shrink-0
                                                        @if(in_array($booking->status, ['paid', 'checked_in'])) bg-green-100 text-green-700
                                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-700
                                                        @elseif($booking->status == 'completed') bg-blue-100 text-blue-700
                                                        @else bg-red-100 text-red-700 @endif">
                                                        {{ $booking->status === 'checked_in' ? 'Confirm' : ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        <span>{{ $booking->member_count }} {{ __('orang') }}</span>
                                                    </div>
                                                    <span class="font-mono text-xs">{{ $booking->booking_code }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex gap-2">
                                                @if(in_array($booking->status, ['paid', 'checked_in', 'completed']))
                                                    <a href="{{ route('bookings.ticket.download', $booking) }}" 
                                                       class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                        </svg>
                                                        <span class="sm:inline">{{ __('E-Ticket') }}</span>
                                                    </a>
                                                @elseif($booking->status == 'pending')
                                                    <a href="{{ route('bookings.pay', $booking) }}" 
                                                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                        </svg>
                                                        <span class="sm:inline">{{ __('Bayar') }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Belum ada booking') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ __('Mulai petualangan Anda dengan booking gunung favorit!') }}</p>
                                    <div class="mt-6">
                                        <a href="{{ route('mountains.list') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            {{ __('Booking Sekarang') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>

                {{-- TAB PEMBAYARAN: Payment History - CARD VIEW --}}
                <div x-show="activeTab === 'pembayaran'" x-transition class="bg-white rounded-2xl shadow-lg p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ __('Riwayat Pembayaran') }}</h3>
                        @if($paidBookings->count() > 0 && $totalPaidCount > $paidBookings->count())
                                <a href="{{ route('payments.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-xl hover:shadow-lg transform hover:scale-105 transition-all">
                                    {{ __('Lihat Semua') }}
                                </a>
                        @endif
                    </div>
                    
                    {{-- Desktop Table --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-green-50 to-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">{{ __('Kode') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">{{ __('Gunung') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">{{ __('Tanggal Bayar') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">{{ __('Total') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase">{{ __('Invoice') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($paidBookings as $booking)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">{{ $booking->booking_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $booking->mountain->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('bookings.invoice.download', $booking) }}" class="text-green-600 hover:text-green-900 font-medium">Unduh</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="lg:hidden space-y-4">
                        @forelse($paidBookings as $booking)
                            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-4 border border-green-100">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">{{ __('Kode Booking') }}</p>
                                        <p class="font-mono text-sm font-bold">{{ $booking->booking_code }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                        {{ __('Lunas') }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-bold text-gray-900">{{ $booking->mountain->name }}</p>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ __('Tanggal Bayar') }}:</span>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ __('Total') }}:</span>
                                        <span class="font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-green-200">
                                    <a href="{{ route('bookings.invoice.download', $booking) }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700">Unduh Invoice</a>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 rounded-xl p-8 text-center">
                                <p class="text-gray-500">{{ __('Belum ada pembayaran') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- TAB PROFIL: Info & Quick Actions --}}
                <div x-show="activeTab === 'profil'" x-transition>
                    <section>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">{{ __('Informasi') }}</h2>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            @include('components.user-profile-card')
                            @include('components.notifications-panel', ['notifications' => $notifications])
                            @if($activeBooking)
                                @include('components.upcoming-hike-card', ['booking' => $activeBooking])
                            @else
                                <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl shadow-lg p-6 card-hover">
                                    <h3 class="text-xl font-semibold mb-4">{{ __('Pendakian Berikutnya') }}</h3>
                                    <p class="text-center text-purple-100 mb-6">{{ __('Tidak ada pendakian yang terjadwal.') }}</p>
                                    <a href="{{ route('home') }}" class="block w-full text-center px-4 py-3 bg-white text-purple-600 font-bold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all">
                                        {{ __('Booking Sekarang') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </main>

        <x-modern-footer/>

        {{-- Bottom Navigation - Mobile Only --}}
        <nav class="bottom-nav">
            <div class="max-w-md mx-auto px-4 py-3">
                <div class="flex items-end justify-around relative">
                    {{-- Home --}}
                    <button @click="activeTab = 'beranda'" class="nav-item" aria-label="{{ __('Beranda') }}">
                        <div :class="activeTab === 'beranda' ? 'nav-icon-active' : 'nav-icon'">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/>
                            </svg>
                        </div>
                    </button>
                    {{-- Booking --}}
                    <button @click="activeTab = 'booking'" class="nav-item" aria-label="{{ __('Booking') }}">
                        <div :class="activeTab === 'booking' ? 'nav-icon-active' : 'nav-icon'">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                    </button>
                    {{-- Mountains/Payment --}}
                    <button @click="activeTab = 'pembayaran'" class="nav-item" aria-label="{{ __('Pembayaran') }}">
                        <div :class="activeTab === 'pembayaran' ? 'nav-icon-active' : 'nav-icon'">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 6l-4.22 5.63 1.25 1.67L14 9.33 19 16h-8.46l-4.01-5.37L1 18h22L14 6zM5 16l1.52-2.03L8.04 16H5z"/>
                            </svg>
                        </div>
                    </button>
                    {{-- Profile/Info --}}
                    <button @click="activeTab = 'profil'" class="nav-item" aria-label="{{ __('Informasi') }}">
                        <div :class="activeTab === 'profil' ? 'nav-icon-active' : 'nav-icon'">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <script>
        // Professional Line Chart for Booking Statistics
        const ctx = document.getElementById('bookingChart').getContext('2d');
        
        // Create gradient for line
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');

        const bookingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Total Booking', 'Booking Lunas', 'Booking Pending'],
                datasets: [{
                    label: 'Jumlah Booking',
                    data: [
                        {{ $totalBookings ?? auth()->user()->bookings()->count() }},
                        {{ $paidCount ?? auth()->user()->bookings()->where('status', 'paid')->count() }},
                        {{ $pendingCount ?? auth()->user()->bookings()->where('status', 'pending')->count() }}
                    ],
                    backgroundColor: gradient,
                    borderColor: 'rgb(102, 126, 234)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgb(102, 126, 234)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgb(102, 126, 234)',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' booking';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            },
                            color: '#6b7280'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#374151'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    </script>
</body>
</html>