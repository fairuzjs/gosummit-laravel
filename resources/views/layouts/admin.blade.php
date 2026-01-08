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
                {{-- Konten Utama dari View yang Extend --}}
                @yield('content')

            </div>
        </main>
    </div>

    {{-- Floating Toast Notifications --}}
    @if (session('success'))
        <div id="toast-notification" 
             class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white rounded-xl shadow-2xl border-l-4 border-green-500 overflow-hidden transform transition-all duration-300 ease-out"
             style="animation: slideInRight 0.3s ease-out;"
             role="alert">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-bold text-gray-900">Success!</p>
                        <p class="text-sm text-gray-700 mt-1">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeToast()" class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="h-1 bg-green-500" style="animation: shrink 3s linear;"></div>
        </div>
    @endif

    @if (session('error'))
        <div id="toast-notification" 
             class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white rounded-xl shadow-2xl border-l-4 border-red-500 overflow-hidden transform transition-all duration-300 ease-out"
             style="animation: slideInRight 0.3s ease-out;"
             role="alert">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-bold text-gray-900">Error!</p>
                        <p class="text-sm text-gray-700 mt-1">{{ session('error') }}</p>
                    </div>
                    <button onclick="closeToast()" class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="h-1 bg-red-500" style="animation: shrink 3s linear;"></div>
        </div>
    @endif

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @keyframes shrink {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    </style>

    {{-- Script untuk toast notification --}}
    <script>
        function closeToast() {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toast-notification');
            
            if (toast) {
                // Auto-dismiss after 3 seconds
                setTimeout(function () {
                    closeToast();
                }, 3000);
            }
        });
    </script>

    <!-- Alpine.js for dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Custom Confirmation Modal -->
    @include('components.confirm-modal')

    @stack('scripts') {{-- Untuk script tambahan di halaman tertentu --}}
</body>
</html>