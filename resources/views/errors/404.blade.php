<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | GoSummit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .animate-scaleIn {
            animation: scaleIn 0.5s ease-out forwards;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-modern-header />

    <main class="flex-grow flex items-center justify-center px-4 py-16">
        <div class="max-w-4xl w-full text-center">
            
            {{-- Animated Mountain SVG --}}
            <div class="mb-2 animate-float">
                <svg class="w-64 h-64 mx-auto" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {{-- Mountains --}}
                    <path d="M20 150 L60 80 L100 120 L140 60 L180 150 Z" fill="url(#gradient1)" opacity="0.3"/>
                    <path d="M40 150 L80 90 L120 110 L160 70 L200 150 Z" fill="url(#gradient2)" opacity="0.5"/>
                    <path d="M0 150 L50 100 L100 130 L150 80 L200 150 Z" fill="url(#gradient3)"/>
                    
                    {{-- Lost Hiker --}}
                    <circle cx="100" cy="110" r="8" fill="#667eea"/>
                    <path d="M100 118 L100 135" stroke="#667eea" stroke-width="3" stroke-linecap="round"/>
                    <path d="M100 125 L92 132" stroke="#667eea" stroke-width="3" stroke-linecap="round"/>
                    <path d="M100 125 L108 132" stroke="#667eea" stroke-width="3" stroke-linecap="round"/>
                    
                    {{-- Question Marks --}}
                    <text x="85" y="95" font-size="16" fill="#764ba2" opacity="0.7">?</text>
                    <text x="115" y="95" font-size="16" fill="#764ba2" opacity="0.7">?</text>
                    
                    {{-- Gradients --}}
                    <defs>
                        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#4299e1;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#667eea;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#3182ce;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            {{-- 404 Number --}}
            <div class="mb-6 animate-scaleIn">
                <h1 class="text-9xl font-black gradient-text leading-none">404</h1>
            </div>

            {{-- Main Message --}}
            <div class="mb-4 animate-fadeInUp" style="animation-delay: 0.1s; opacity: 0;">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">
                    Oops! Halaman Tidak Ditemukan
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Sepertinya Anda tersesat di jalur pendakian. Jangan khawatir, kami akan membantu Anda kembali ke jalur yang benar!
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12 animate-fadeInUp" style="animation-delay: 0.3s; opacity: 0;">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('mountains.list') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-purple-600 bg-white border-2 border-purple-600 rounded-full hover:bg-purple-50 transform hover:scale-105 transition-all duration-200">
                    Jelajahi Gunung
                </a>
            </div>
        </div>
    </main>

    <x-modern-footer />
</body>
</html>
