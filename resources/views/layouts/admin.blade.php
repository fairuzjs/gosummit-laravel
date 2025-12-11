<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Admin')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles') {{-- Untuk style tambahan di halaman tertentu --}}
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">

        <!-- Header Atas -->
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-xl sm:text-2xl text-gray-800 flex items-center">
                        @yield('header-title', 'Admin Dashboard')
                    </h1>

                    <!-- Tombol-tombol di Header -->
                    <div class="flex items-center space-x-3">
                        @yield('header-buttons')
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-4 sm:p-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                {{-- Notifikasi Success --}}
                @if (session('success'))
                    <div id="notification" class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-xl shadow-md" role="alert">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Success!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Notifikasi Error --}}
                @if (session('error'))
                    <div id="notification" class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-xl shadow-md" role="alert">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Error!</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Konten Utama dari View yang Extend --}}
                @yield('content')

            </div>
        </main>
    </div>

    {{-- Script untuk menghilangkan notifikasi otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cari elemen notifikasi
            const notification = document.getElementById('notification');

            if (notification) {
                // Set timer untuk menghilangkan notifikasi setelah 3 detik (3000ms)
                setTimeout(function () {
                    notification.style.transition = 'opacity 0.5s ease-out';
                    notification.style.opacity = '0';
                    // Hilangkan elemen dari DOM setelah transisi selesai
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 3000); // 3 detik

                // Opsional: Tambahkan event listener untuk menutup manual saat diklik
                notification.addEventListener('click', function () {
                    this.style.transition = 'opacity 0.5s ease-out';
                    this.style.opacity = '0';
                    setTimeout(() => {
                        this.remove();
                    }, 500);
                });
            }
        });
    </script>

    <!-- Alpine.js for dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('scripts') {{-- Untuk script tambahan di halaman tertentu --}}
</body>
</html>