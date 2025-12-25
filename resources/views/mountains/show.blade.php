<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail: {{ $mountain->name }} - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .info-card {
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(102, 126, 234, 0.3);
        }
        
        .image-overlay {
            position: relative;
            overflow: hidden;
        }
        
        .image-overlay::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
        }
        
        .badge {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <x-modern-header/>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('mountains.list') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium mb-6 group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('Kembali ke Daftar Gunung') }}
            </a>

            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl">
                <div class="image-overlay h-96 relative">
<img class="w-full h-full object-cover" 
     src="{{ $mountain->image_url ? asset('storage/' . $mountain->image_url) : 'https://via.placeholder.com/1200x400.png?text=No+Image' }}" 
     alt="Gambar {{ $mountain->name }}">
                    <div class="absolute bottom-6 left-6 right-6 z-10">
                        <h1 class="text-5xl font-extrabold text-white mb-2 drop-shadow-lg">{{ $mountain->name }}</h1>
                    </div>
                </div>

                <div class="p-8 sm:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div class="info-card bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-6 border border-purple-100">
                            <div class="flex items-center">
                                <div class="bg-purple-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">{{ __('Lokasi') }}</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $mountain->location }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-card bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <div class="flex items-center">
                                <div class="bg-green-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.158-.103.34-.153.527-.153h.08c.187 0 .369.05.527.153l2.92 1.947c.498.331.688.944.446 1.487l-.02.033c-.242.543-.855.733-1.353.402L10 10.399l-1.55 1.033c-.498.331-1.11.14-1.352-.402a1.002 1.002 0 01.446-1.487l2.92-1.947z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0 2a10 10 0 100-20 10 10 0 000 20z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">{{ __('Harga Tiket') }}</p>
                                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($mountain->ticket_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">per orang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ __('Deskripsi') }}</h3>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $mountain->description }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ __('Informasi Kuota & Booking') }}</h3>
                        </div>
                        
                        {{-- Logika Penutupan Gunung Diterapkan Di Sini --}}
                        @if ($mountain->status == 'closed')
                            {{-- Tampilkan Pesan Penutupan Gunung --}}
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    <div>
                                        <p class="font-bold text-lg">{{ __('Pendakian Ditutup') }}</p>
                                        <p>{{ __('Mohon maaf, pendakian ke Gunung') }} {{ $mountain->name }} {{ __('saat ini ditutup sementara dan mohon untuk menunggu info lanjutan.') }}</p>
                                    </div>
                                </div>
                            </div>
                        
                        {{-- Logika Booking Dijalankan Hanya Jika Gunung Terbuka ('open') --}}
@elseif (Auth::check())
                            {{-- Hanya tampilkan form jika user sudah login --}}
                            @if($quotas->isNotEmpty())
                                    {{-- PERBAIKAN: Masukkan $quotas ke dalam Livewire component --}}
                                    @livewire('booking-form', ['mountainId' => $mountain->id, 'quotas' => $quotas])
                            @else
                                <div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 text-orange-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <div>
                                            <p class="font-bold text-orange-800 mb-1">{{ __('Informasi Kuota Tidak Tersedia') }}</p>
                                            <p class="text-orange-700">{{ __('Saat ini belum ada jadwal pendakian yang dibuka untuk gunung ini. Silakan cek kembali nanti.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- Jika belum login --}}
                            <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 rounded-lg p-6">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-bold text-yellow-800 mb-2">{{ __('Anda harus login untuk memesan tiket') }}</p>
                                        <p class="text-yellow-700 mb-4">{{ __('Silakan login atau daftar terlebih dahulu untuk melanjutkan pemesanan.') }}</p>
                                        <div class="flex space-x-3">
                                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                                {{ __('Login Sekarang') }}
                                            </a>
                                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white text-yellow-600 font-semibold rounded-lg border-2 border-yellow-600 hover:bg-yellow-50 transition-colors">
                                                {{ __('Daftar Akun') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-modern-footer/>  

    @livewireScripts
</body>
</html>