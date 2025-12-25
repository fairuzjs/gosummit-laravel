<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <style>
        /* Background */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        /* Split Layout Container */
        .split-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        @media (min-width: 1024px) {
            .split-container {
                /* UBAH DI SINI: Kolom kiri (1.5fr) lebih lebar untuk detail, kanan (1fr) untuk summary */
                grid-template-columns: 1.5fr 1fr;
                gap: 2.5rem;
            }
        }
        
        /* Card Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .summary-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(249, 250, 251, 0.98) 100%);
            position: sticky;
            top: 6rem;
            align-self: start;
        }
        
        /* Detail Item */
        .detail-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            background: white;
            border-radius: 12px;
            border: 2px solid #f3f4f6;
            transition: all 0.3s ease;
        }
        
        .detail-item:hover {
            border-color: #e5e7eb;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .detail-item-highlight {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #fbbf24;
        }
        
        /* Button */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        /* Price Display */
        .price-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .price-amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        @media (min-width: 640px) {
            .price-amount {
                font-size: 3rem;
            }
        }
        
        /* Icon Wrapper */
        .icon-wrapper {
            width: 2.5rem;
            height: 2.5rem;
            min-width: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            margin-right: 1rem;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.9;
            }
        }
        
        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Mobile Optimization */
        @media (max-width: 1023px) {
            .summary-card {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">

<x-modern-header />

        {{-- Main Content --}}
        <main class="py-8 px-4 sm:px-6 lg:py-12">
            <div class="max-w-7xl mx-auto">
                {{-- Header --}}
                <div class="text-center mb-8 lg:mb-12 animate-fade-in">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3">
                        {{ __('Konfirmasi Pembayaran') }}
                    </h1>
                    <p class="text-base sm:text-lg text-white/90 max-w-2xl mx-auto">
                        {{ __('Periksa kembali detail pemesanan Anda sebelum melanjutkan') }}
                    </p>
                </div>

                {{-- Split Layout --}}
                <div class="split-container">
                    
                    {{-- LEFT: Booking Details (Moved to Left) --}}
                    {{-- UBAH DI SINI: order-1 (mobile: pertama), lg:order-1 (desktop: kiri/pertama) --}}
                    <div class="order-1 lg:order-1">
                        <div class="glass-card p-6 lg:p-8 animate-fade-in">
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">
                                    {{ __('Detail Pemesanan') }}
                                </h2>
                                <p class="text-gray-600 text-sm">{{ __('Pastikan semua informasi sudah benar') }}</p>
                            </div>

                            {{-- Details Grid --}}
                            <div class="space-y-4">
                                
                                {{-- Booking Code --}}
                                <div class="detail-item detail-item-highlight">
                                    <div class="icon-wrapper">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 mb-1">{{ __('Kode Booking') }}</p>
                                        <p class="font-bold text-gray-900 text-lg truncate">{{ $booking->booking_code }}</p>
                                    </div>
                                </div>

                                {{-- Destination --}}
                                <div class="detail-item">
                                    <div class="icon-wrapper">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 mb-1">{{ __('Destinasi') }}</p>
                                        <p class="font-bold text-gray-900 text-base">{{ $booking->mountain->name }}</p>
                                    </div>
                                </div>

                                {{-- Check-in Date --}}
                                <div class="detail-item">
                                    <div class="icon-wrapper">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 mb-1">{{ __('Tanggal Naik') }}</p>
                                        <p class="font-bold text-gray-900 text-base">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Trail Route --}}
                                <div class="detail-item">
                                    <div class="icon-wrapper">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 mb-1">{{ __('Jalur Pendakian') }}</p>
                                        <p class="font-bold text-gray-900 text-base">
                                            {{ $booking->trailRoute ? $booking->trailRoute->name : 'Tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Member Count --}}
                                <div class="detail-item">
                                    <div class="icon-wrapper">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 mb-1">{{ __('Jumlah Pendaki') }}</p>
                                        <p class="font-bold text-gray-900 text-base">{{ $booking->member_count }} Orang</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Payment Summary (Moved to Right, Sticky) --}}
                    {{-- UBAH DI SINI: order-2 (mobile: kedua), lg:order-2 (desktop: kanan/kedua) --}}
                    <div class="order-2 lg:order-2">
                        <div class="glass-card summary-card p-6 lg:p-8 animate-fade-in">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                                {{ __('Ringkasan Pembayaran') }}
                            </h2>

                            {{-- Price Display --}}
                            <div class="price-display pulse-animation">
                                <p class="text-white/80 text-sm mb-2">{{ __('Total Pembayaran') }}</p>
                                <p class="price-amount">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </p>
                                <p class="text-white/70 text-xs">
                                    untuk {{ $booking->member_count }} orang
                                </p>
                            </div>

                            {{-- Pay Button --}}
                            <button id="pay-button" class="btn-primary mb-4">
                                {{ __('Lanjutkan Pembayaran') }}
                            </button>

                            {{-- Cancel Link --}}
                            <div class="text-center mb-6">
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-purple-600 font-medium transition-colors duration-200">
                                    {{ __('Batalkan atau Bayar Nanti') }}
                                </a>
                            </div>

                            {{-- Security Notice --}}
                            <div class="pt-6 border-t-2 border-gray-200">
                                <div class="flex items-start text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span>{{ __('Pembayaran aman dan terenkripsi melalui Midtrans Payment Gateway') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <x-modern-footer />
    </div>

    {{-- Midtrans Snap Script --}}
    <script type="text/javascript">
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            window.location.href = '{{ route('dashboard') }}';
          },
          onPending: function(result){
            alert("Menunggu pembayaran Anda!");
            window.location.href = '{{ route('dashboard') }}';
          },
          onError: function(result){
            alert("Pembayaran gagal! Silakan coba lagi.");
          },
          onClose: function(){
            // User closed the popup without completing payment
          }
        })
      });
    </script>
</body>
</html>