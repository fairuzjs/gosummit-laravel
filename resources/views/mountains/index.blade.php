<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticketing Pendakian</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        
        /* Holographic Card Effect */
.holographic-card {
    position: relative;
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 32px 24px;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.holographic-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        0deg, 
        transparent, 
        transparent 30%, 
        rgba(102, 126, 234, 0.4),
        rgba(118, 75, 162, 0.4)
    );
    transform: rotate(-45deg);
    transition: all 0.6s ease;
    opacity: 0;
}
.holographic-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(102, 126, 234, 0.3), 
                0 10px 10px -5px rgba(102, 126, 234, 0.2);
    border-color: rgba(102, 126, 234, 0.5);
}
.holographic-card:hover::before {
    opacity: 1;
    transform: rotate(-45deg) translateY(100%);
}
/* Icon Container - Base Style */
.holographic-card .icon-container {
    position: relative;
    z-index: 2;
    width: 64px;
    height: 64px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
}
.holographic-card:hover .icon-container {
    transform: scale(1.1) rotate(5deg);
}
/* Individual Icon Colors */
.icon-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    box-shadow: 0 8px 16px -4px rgba(139, 92, 246, 0.4);
}
.holographic-card:hover .icon-purple {
    box-shadow: 0 12px 24px -4px rgba(139, 92, 246, 0.6);
}
.icon-green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.4);
}
.holographic-card:hover .icon-green {
    box-shadow: 0 12px 24px -4px rgba(16, 185, 129, 0.6);
}
.icon-orange {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    box-shadow: 0 8px 16px -4px rgba(249, 115, 22, 0.4);
}
.holographic-card:hover .icon-orange {
    box-shadow: 0 12px 24px -4px rgba(249, 115, 22, 0.6);
}
.icon-blue {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 8px 16px -4px rgba(59, 130, 246, 0.4);
}
.holographic-card:hover .icon-blue {
    box-shadow: 0 12px 24px -4px rgba(59, 130, 246, 0.6);
}
.icon-pink {
    background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    box-shadow: 0 8px 16px -4px rgba(236, 72, 153, 0.4);
}
.holographic-card:hover .icon-pink {
    box-shadow: 0 12px 24px -4px rgba(236, 72, 153, 0.6);
}
.icon-yellow {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.4);
}
.holographic-card:hover .icon-yellow {
    box-shadow: 0 12px 24px -4px rgba(245, 158, 11, 0.6);
}
/* Text Styling */
.holographic-card h3 {
    position: relative;
    z-index: 2;
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 12px;
    text-align: center;
}
.holographic-card p {
    position: relative;
    z-index: 2;
    color: rgba(255, 255, 255, 0.8);
    text-align: center;
    line-height: 1.6;
}
/* Responsive */
@media (max-width: 768px) {
    .holographic-card {
        padding: 24px 20px;
    }
    
    .holographic-card .icon-container {
        width: 56px;
        height: 56px;
    }
}
/* 1. Blur to Focus - Hero Section */
.scroll-blur {
    opacity: 0;
    filter: blur(10px);
    transform: translateY(20px);
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}
.scroll-blur.visible {
    opacity: 1;
    filter: blur(0);
    transform: translateY(0);
}
/* 2. Fade Up - Mountain Cards */
.scroll-fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.scroll-fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}
/* 3. Stagger Animation - Why Choose Us */
.scroll-stagger {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.scroll-stagger.visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}
.scroll-stagger:nth-child(1).visible { transition-delay: 0.1s; }
.scroll-stagger:nth-child(2).visible { transition-delay: 0.2s; }
.scroll-stagger:nth-child(3).visible { transition-delay: 0.3s; }
.scroll-stagger:nth-child(4).visible { transition-delay: 0.4s; }
.scroll-stagger:nth-child(5).visible { transition-delay: 0.5s; }
.scroll-stagger:nth-child(6).visible { transition-delay: 0.6s; }
/* 4. Counter Animation - Statistics */
.scroll-counter {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.scroll-counter.visible {
    opacity: 1;
    transform: translateY(0);
}
/* Smooth counter number transition */
.stat-number {
    transition: all 0.3s ease;
}
/* Accessibility - Reduce motion */
@media (prefers-reduced-motion: reduce) {
    .scroll-blur,
    .scroll-fade-up,
    .scroll-stagger,
    .scroll-counter {
        opacity: 1 !important;
        filter: none !important;
        transform: none !important;
        transition: none !important;
    }
}

        html { scroll-behavior: smooth; }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .video-docker {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .video-docker video {
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
        }

        /* Custom styles for equal height cards */
        .mountain-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%; 
        }
        
        .mountain-card .card-image {
            flex-shrink: 0;
        }
        
        .mountain-card .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .mountain-card .card-description {
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .mountain-card .card-footer {
            margin-top: auto;
        }

        /* Custom styles for statistics cards - Mobile Optimized */
        .stats-container {
            padding: 3rem 1rem;
        }
        
        .stats-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, 1fr);
        }
        
        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
            }
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        @media (min-width: 640px) {
            .stat-card {
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            overflow: hidden;
        }
        
        @media (min-width: 640px) {
            .stat-icon {
                width: 70px;
                height: 70px;
                margin-bottom: 1.5rem;
            }
        }
        
        .stat-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.5s;
        }
        
        .stat-card:hover .stat-icon::before {
            animation: shine 0.5s ease-in-out;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .stat-number {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
            line-height: 1;
        }
        
        @media (min-width: 640px) {
            .stat-number {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }
        }
        
        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        
        @media (min-width: 640px) {
            .stat-label {
                font-size: 1rem;
            }
        }

        @media (max-width: 380px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .stat-card {
                display: flex;
                align-items: center;
                text-align: left;
                padding: 1rem;
            }
            
            .stat-icon {
                margin: 0 1rem 0 0;
                flex-shrink: 0;
            }
            
            .stat-content {
                flex: 1;
            }
        }
        /* ===== SWIPER CAROUSEL STYLES ===== */
        .mountain-carousel {
            padding: 60px 10px;
            overflow: hidden; 
        }
        .mountain-carousel .swiper-slide {
            height: auto;
            display: flex;
            justify-content: center;
        }
        /* Navigation Arrows */
        .mountain-carousel .swiper-button-prev,
        .mountain-carousel .swiper-button-next {
            width: 56px;
            height: 56px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            z-index: 10;
        }
        .mountain-carousel .swiper-button-prev:after,
        .mountain-carousel .swiper-button-next:after {
            font-size: 20px;
            font-weight: 900;
            color: #667eea;
            transition: color 0.3s ease;
        }
        .mountain-carousel .swiper-button-prev:hover,
        .mountain-carousel .swiper-button-next:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: white;
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.3);
        }
        .mountain-carousel .swiper-button-prev:hover:after,
        .mountain-carousel .swiper-button-next:hover:after {
            color: white;
        }
        /* Pagination Dots */
        .mountain-carousel .swiper-pagination {
            position: relative;
            margin-top: 32px;
        }
        .mountain-carousel .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #cbd5e1;
            opacity: 1;
            transition: all 0.3s ease;
        }
        .mountain-carousel .swiper-pagination-bullet:hover {
            background: #94a3b8;
            transform: scale(1.2);
        }
        .mountain-carousel .swiper-pagination-bullet-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 32px;
            border-radius: 6px;
        }
        /* Mobile Responsive */
        @media (max-width: 640px) {
            .mountain-carousel {
                padding: 40px 0;
            }
            
            .mountain-carousel .swiper-button-prev,
            .mountain-carousel .swiper-button-next {
                width: 44px;
                height: 44px;
            }
            
            .mountain-carousel .swiper-button-prev:after,
            .mountain-carousel .swiper-button-next:after {
                font-size: 16px;
            }
            /* Custom Swiper Navigation Buttons */
        .mountain-carousel .swiper-button-next,
        .mountain-carousel .swiper-button-prev {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .mountain-carousel .swiper-button-next:hover,
        .mountain-carousel .swiper-button-prev:hover {
            background: #7c3aed;
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
            transform: scale(1.1);
        }
        .mountain-carousel .swiper-button-next::after,
        .mountain-carousel .swiper-button-prev::after {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
        }
        .mountain-carousel .swiper-button-next:hover::after,
        .mountain-carousel .swiper-button-prev:hover::after {
            color: white;
        }
        /* Position buttons OUTSIDE the carousel */
        .mountain-carousel .swiper-button-prev {
            left: -60px;
        }
        .mountain-carousel .swiper-button-next {
            right: -60px;
        }
        /* Hide buttons on mobile/tablet */
        @media (max-width: 1280px) {
            .mountain-carousel .swiper-button-next,
            .mountain-carousel .swiper-button-prev {
                display: none;
            }
        }
        /* Custom Swiper Pagination */
        .mountain-carousel .swiper-pagination {
            bottom: -40px !important;
        }
        .mountain-carousel .swiper-pagination-bullet {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            background: #cbd5e1;
            opacity: 1;
            transition: all 0.3s ease;
        }
        .mountain-carousel .swiper-pagination-bullet-active {
            background: #7c3aed;
            width: 40px;
        }
    }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50">

<x-modern-header />

<section class="relative h-[85vh] flex flex-col items-center justify-center text-center px-4 overflow-hidden scroll-blur">
    <div class="video-docker">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('videos/cinems.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-gray-900/50"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto mt-10">
        <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold tracking-widest uppercase mb-6">
            {{ __('Early Access') }}
        </span>
        
        <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight drop-shadow-lg">
            {{ __('Taklukkan Puncak') }} <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                {{ __('Impianmu') }}
            </span>
        </h1>
        
        <p class="mt-4 max-w-5xl mx-auto text-lg sm:text-xl text-gray-200 font-light mb-10 drop-shadow-md">
            {{ __('Platform booking tiket pendakian gunung nomor satu di Indonesia.') }}
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#mountains" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transform transition-all duration-200">
                {{ __('Mulai Mendaki') }}
            </a>
        </div>
    </div>
</section>

<section class="relative z-20 py-16 bg-gradient-to-b from-white to-slate-50 scroll-counter">
    <div class="max-w-6xl mx-auto stats-container">
        <div class="stats-grid">
            <!-- Stat 1: Mountains -->
            <div class="stat-card">
                <div class="stat-icon">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number" data-target="{{ \App\Models\Mountain::count() }}" data-suffix="+">0</div>
                    <div class="stat-label">{{ __('Gunung Tersedia') }}</div>
                </div>
            </div>
            <!-- Stat 2: Hikers -->
            <div class="stat-card">
                <div class="stat-icon">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number" data-target="{{ number_format(\App\Models\User::where('role', 'customer')->count()) }}+" data-suffix="+">0</div>
                    <div class="stat-label">{{ __('Pendaki') }}</div>
                </div>
            </div>
            <!-- Stat 3: Safe & Trusted -->
            <div class="stat-card">
                <div class="stat-icon">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number" data-target="100" data-suffix="%">0</div>
                    <div class="stat-label">{{ __('Aman & Terpercaya') }}</div>
                </div>
            </div>
            <!-- Stat 4: Support 24/7 -->
            <div class="stat-card">
                <div class="stat-icon">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">{{ __('Layanan Support') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Year 2026 Event Popup Modal -->
<div id="newYearPopup" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
    <!-- Backdrop Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeNewYearPopup()"></div>
    
    <!-- Modal Content -->
    <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300" id="popupContent">
        <!-- Close Button -->
        <button onclick="closeNewYearPopup()" class="absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full text-white transition-all duration-300 hover:rotate-90 group">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Banner Card -->
        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900"></div>
            
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-10 left-10 w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
                <div class="absolute top-20 right-10 w-32 h-32 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-10 left-1/2 w-32 h-32 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
            </div>
            
            <!-- Sparkle/Star Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full animate-pulse"></div>
                <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-yellow-300 rounded-full animate-ping"></div>
                <div class="absolute bottom-1/4 right-1/4 w-2 h-2 bg-white rounded-full animate-pulse animation-delay-1000"></div>
                <div class="absolute top-1/2 left-1/3 w-1 h-1 bg-purple-300 rounded-full animate-ping animation-delay-2000"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 py-8 px-6 md:py-12 md:px-10 text-center">
                <!-- Event Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 text-slate-900 font-bold text-xs md:text-sm uppercase tracking-wider mb-4 shadow-lg animate-bounce">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    {{ __('Event Spesial Tahun Baru') }}
                </div>
                
                <!-- Main Title -->
                <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-yellow-200 to-white mb-3 leading-tight">
                    NEW YEAR, NEW SUMMIT 2026
                </h2>
                
                <!-- Subtitle -->
                <p class="text-base md:text-lg text-white/90 mb-6 max-w-xl mx-auto font-medium">
                    {{ __('Rayakan tahun baru dengan petualangan baru! Dapatkan diskon') }} 
                    <span class="text-yellow-300 font-bold text-xl md:text-2xl">26%</span> 
                    {{ __('untuk semua pemesanan di Januari 2026') }}
                </p>
                
                <!-- Promo Code Badge -->
                <div class="inline-block mb-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative px-5 py-2.5 bg-slate-900 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="text-white/70 text-xs md:text-sm font-semibold">{{ __('Kode Promo:') }}</span>
                                <span class="text-yellow-300 text-lg md:text-xl font-black tracking-wider" id="promoCodePopup">NEWYEAR2026</span>
                                <button onclick="copyPromoCodePopup()" class="ml-1 p-1.5 hover:bg-white/10 rounded-lg transition-colors" title="Salin kode">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Countdown Timer -->
                <div class="flex justify-center gap-2 md:gap-4 mb-6">
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 md:p-3 min-w-[60px] md:min-w-[75px]">
                        <div class="text-xl md:text-3xl font-black text-white" id="daysPopup">00</div>
                        <div class="text-[10px] md:text-xs text-white/70 font-semibold uppercase">{{ __('Hari') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 md:p-3 min-w-[60px] md:min-w-[75px]">
                        <div class="text-xl md:text-3xl font-black text-white" id="hoursPopup">00</div>
                        <div class="text-[10px] md:text-xs text-white/70 font-semibold uppercase">{{ __('Jam') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 md:p-3 min-w-[60px] md:min-w-[75px]">
                        <div class="text-xl md:text-3xl font-black text-white" id="minutesPopup">00</div>
                        <div class="text-[10px] md:text-xs text-white/70 font-semibold uppercase">{{ __('Menit') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-2 md:p-3 min-w-[60px] md:min-w-[75px]">
                        <div class="text-xl md:text-3xl font-black text-white" id="secondsPopup">00</div>
                        <div class="text-[10px] md:text-xs text-white/70 font-semibold uppercase">{{ __('Detik') }}</div>
                    </div>
                </div>
                
                <!-- CTA Button -->
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('mountains.list') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm md:text-base font-bold text-slate-900 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-2xl hover:shadow-yellow-500/50 hover:scale-105 transform transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        {{ __('Pesan Sekarang') }}
                    </a>
                    <button onclick="closeNewYearPopup()" class="inline-flex items-center justify-center px-6 py-3 text-sm md:text-base font-bold text-white bg-white/10 backdrop-blur-md border-2 border-white/30 rounded-full hover:bg-white/20 hover:scale-105 transform transition-all duration-300">
                        {{ __('Lihat Destinasi') }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Terms -->
                <p class="mt-4 text-[10px] md:text-xs text-white/60">
                    {{ __('*Promo berlaku untuk semua pemesanan dari 1-31 Januari 2026. Syarat dan ketentuan berlaku.') }}
                </p>
                
                <!-- Don't Show Again Button -->
                <button onclick="dontShowAgain()" class="mt-3 text-xs text-white/50 hover:text-white/80 underline transition-colors duration-200">
                    {{ __('Jangan tampilkan lagi selama 1 jam') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    /* Prevent body scroll when popup is open */
    body.popup-open {
        overflow: hidden;
    }
</style>

<script>
    // Countdown Timer for Popup
    function updateCountdownPopup() {
        const eventEnd = new Date('2026-01-31T23:59:59').getTime();
        const now = new Date().getTime();
        const distance = eventEnd - now;
        
        if (distance < 0) {
            document.getElementById('daysPopup').textContent = '00';
            document.getElementById('hoursPopup').textContent = '00';
            document.getElementById('minutesPopup').textContent = '00';
            document.getElementById('secondsPopup').textContent = '00';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('daysPopup').textContent = String(days).padStart(2, '0');
        document.getElementById('hoursPopup').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutesPopup').textContent = String(minutes).padStart(2, '0');
        document.getElementById('secondsPopup').textContent = String(seconds).padStart(2, '0');
    }
    
    // Copy promo code function for popup
    function copyPromoCodePopup() {
        const promoCode = document.getElementById('promoCodePopup').textContent;
        navigator.clipboard.writeText(promoCode).then(() => {
            // Show success feedback
            const button = event.currentTarget;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 2000);
        });
    }
    
    // Show popup function
    function showNewYearPopup() {
        const popup = document.getElementById('newYearPopup');
        const popupContent = document.getElementById('popupContent');
        
        popup.classList.remove('hidden');
        document.body.classList.add('popup-open');
        
        // Trigger animation
        setTimeout(() => {
            popup.classList.remove('opacity-0');
            popupContent.classList.remove('scale-95');
            popupContent.classList.add('scale-100');
        }, 10);
        
        // Start countdown
        updateCountdownPopup();
        setInterval(updateCountdownPopup, 1000);
    }
    
    // Close popup function (does NOT save to localStorage)
    function closeNewYearPopup() {
        const popup = document.getElementById('newYearPopup');
        const popupContent = document.getElementById('popupContent');
        
        // Animate out
        popup.classList.add('opacity-0');
        popupContent.classList.remove('scale-100');
        popupContent.classList.add('scale-95');
        
        setTimeout(() => {
            popup.classList.add('hidden');
            document.body.classList.remove('popup-open');
        }, 300);
        
        // DO NOT save to localStorage - popup will show again on refresh
    }
    
    // Don't show again function (saves to localStorage for 1 hour)
    function dontShowAgain() {
        const popup = document.getElementById('newYearPopup');
        const popupContent = document.getElementById('popupContent');
        
        // Animate out
        popup.classList.add('opacity-0');
        popupContent.classList.remove('scale-100');
        popupContent.classList.add('scale-95');
        
        setTimeout(() => {
            popup.classList.add('hidden');
            document.body.classList.remove('popup-open');
        }, 300);
        
        // Save to localStorage to not show again for 1 hour
        const expiryTime = new Date().getTime() + (1 * 60 * 60 * 1000); // 1 hour
        localStorage.setItem('newYearPopupDontShow', expiryTime);
    }
    
    // Check if popup should be shown
    function checkAndShowPopup() {
        const dontShowTime = localStorage.getItem('newYearPopupDontShow');
        const currentTime = new Date().getTime();
        
        // Check if event is still active (before Jan 31, 2026)
        const eventEnd = new Date('2026-01-31T23:59:59').getTime();
        if (currentTime > eventEnd) {
            return; // Event has ended, don't show popup
        }
        
        // Check if user clicked "Don't Show Again" and 1 hour hasn't passed
        if (dontShowTime && currentTime < parseInt(dontShowTime)) {
            return; // Don't show popup, user requested to hide it
        }
        
        // Show popup (always show on refresh unless "Don't Show Again" was clicked)
        setTimeout(() => {
            showNewYearPopup();
        }, 1000);
    }
    
    // Run on page load
    document.addEventListener('DOMContentLoaded', checkAndShowPopup);
    
    // Close popup on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const popup = document.getElementById('newYearPopup');
            if (!popup.classList.contains('hidden')) {
                closeNewYearPopup();
            }
        }
    });
</script>

    <!-- Why Choose Us Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                {{ __('Mengapa Memilih GoSummit?') }}
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                {{ __('Platform terpercaya untuk petualangan pendakian Anda') }}
            </p>
        </div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Feature 1: Booking Mudah - PURPLE -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-purple">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h3>{{ __('Booking Mudah & Cepat') }}</h3>
        <p>{{ __('Pesan tiket pendakian hanya dalam 3 langkah sederhana') }}</p>
    </div>
    <!-- Feature 2: Pembayaran Aman - GREEN -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-green">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h3>{{ __('Pembayaran Aman') }}</h3>
        <p>{{ __('Transaksi terenkripsi dengan Midtrans Payment Gateway') }}</p>
    </div>
    <!-- Feature 3: E-Ticket Digital - ORANGE -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-orange">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
        </div>
        <h3>{{ __('E-Ticket Digital') }}</h3>
        <p>{{ __('Tiket langsung dikirim ke email, tanpa perlu print') }}</p>
    </div>
    <!-- Feature 4: Kuota Real-time - BLUE -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-blue">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <h3>{{ __('Kuota Real-time') }}</h3>
        <p>{{ __('Lihat ketersediaan kuota secara langsung') }}</p>
    </div>
    <!-- Feature 5: Customer Support - PINK -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-pink">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <h3>{{ __('Support 24/7') }}</h3>
        <p>{{ __('Tim kami siap membantu kapan saja') }}</p>
    </div>
    <!-- Feature 6: Flexible Cancellation - YELLOW -->
    <div class="holographic-card scroll-stagger">
        <div class="icon-container icon-yellow">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </div>
        <h3>{{ __('Pembatalan Fleksibel') }}</h3>
        <p>{{ __('Batalkan booking sesuai ketentuan yang berlaku') }}</p>
    </div>
</div>
    </div>
</section>



    <main id="mountains" class="pt-24 pb-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-2">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">{{ __('Destinasi Populer') }}</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">{{ __('Pilih gunung impianmu dan rasakan pengalaman mendaki yang tak terlupakan.') }}</p>
            </div>
            

@if($mountains->count() > 0)
    <div class="swiper mountain-carousel">
        <div class="swiper-wrapper">
            @foreach($mountains as $mountain)
            <div class="swiper-slide">
                <div class="mountain-card scroll-fade-up bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 h-full">
                    <div class="card-image relative overflow-hidden h-64">
                        @if($mountain->image_url)
                            <img src="{{ asset('storage/' . $mountain->image_url) }}" 
                                 alt="{{ $mountain->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        @elseif($mountain->image)
                            <img src="{{ asset('storage/' . $mountain->image) }}" 
                                 alt="{{ $mountain->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-slate-900 shadow-lg">
                                <svg class="w-3 h-3 mr-1 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                {{ $mountain->location }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-content p-6">
                        <h3 class="text-2xl font-extrabold text-slate-900 mb-2 line-clamp-1">
                            {{ $mountain->name }}
                        </h3>
                        
                        <p class="card-description text-slate-600 text-sm mb-4 line-clamp-2">
                            {{ $mountain->description }}
                        </p>
                        
                        <div class="card-footer flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-xs text-slate-400 uppercase font-bold">{{ __('Ketinggian') }}</span>
                                <span class="text-sm font-semibold text-slate-700">{{ $mountain->height }} mdpl</span>
                            </div>
                            
                            <a href="{{ route('mountains.show', $mountain->id) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-purple-600 transition-colors duration-300">
                                {{ __('Detail') }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        
        <div class="swiper-pagination"></div>
    </div>
@else
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <p class="text-slate-500 text-lg">{{ __('Belum ada data gunung tersedia saat ini.') }}</p>
    </div>
@endif

            <div class="mt-6 text-center">
                <a href="{{ route('mountains.list') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition-all duration-300 transform bg-slate-900 rounded-full hover:bg-purple-600 hover:scale-105 hover:shadow-xl shadow-lg shadow-slate-300/50">
                    {{ __('Lihat Semua Gunung') }}
                </a>
            </div>

        </div>
    </main>

{{-- Leaderboard Widget Section --}}
<section class="relative py-16 bg-gradient-to-b from-slate-50 to-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 text-slate-900 font-bold text-xs uppercase tracking-wider mb-4 shadow-lg">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                {{ __('Leaderboard') }}
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
                {{ __('Hall of Fame - Pendaki Terbaik') }}
            </h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                {{ __('Lihat pendaki terbaik yang telah menyelesaikan pendakian terbanyak sepanjang masa') }}
            </p>
        </div>

        {{-- Leaderboard Cards --}}
        <div class="grid gap-4 mb-8">
            @forelse($topClimbers as $index => $climber)
                <div class="group relative bg-white rounded-xl p-4 shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100 hover:border-purple-200 {{ $index < 3 ? 'hover:scale-[1.02]' : '' }}">
                    <div class="flex items-center gap-4">
                        {{-- Rank Badge --}}
                        <div class="flex-shrink-0">
                            @if($index === 0)
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-black text-xl shadow-lg">
                                    1
                                </div>
                            @elseif($index === 1)
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-slate-300 to-slate-400 flex items-center justify-center text-white font-black text-xl shadow-lg">
                                    2
                                </div>
                            @elseif($index === 2)
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-black text-xl shadow-lg">
                                    3
                                </div>
                            @else
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-700 font-bold text-xl">
                                    {{ $index + 1 }}
                                </div>
                            @endif
                        </div>

                        {{-- User Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ strtoupper(substr($climber->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="font-bold text-slate-900 text-sm sm:text-base truncate">
                                        {{ $climber->name }}
                                    </div>
                                    <div class="text-xs text-slate-500 truncate">
                                        {{ $climber->masked_email ?? mask_email($climber->email) }}
                                    </div>
                                </div>
                            </div>
                            @if($index < 3)
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                        {{ __('TOP') }} {{ $index + 1 }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Stats --}}
                        <div class="hidden md:block text-right">
                            <div class="font-bold text-sm {{ $climber->userStatistic->total_spent === null ? 'text-gray-400 italic' : 'text-slate-900' }}">
                                @if($climber->userStatistic->total_spent === null)
                                    Private
                                @else
                                    Rp {{ number_format($climber->userStatistic->total_spent ?? 0, 0, ',', '.') }}
                                @endif
                            </div>
                            <div class="text-xs text-slate-500">{{ __('Total Pengeluaran') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-slate-500 font-semibold">{{ __('Belum ada data leaderboard') }}</p>
                    <p class="text-slate-400 text-sm mt-1">{{ __('Jadilah yang pertama!') }}</p>
                </div>
            @endforelse
        </div>

        {{-- View All Button --}}
        <div class="text-center">
            <a href="{{ route('leaderboard.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                {{ __('Lihat Leaderboard Lengkap') }}
            </a>
        </div>

    </div>
</section>

<!-- FAQ Section - Redesigned -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-white to-purple-50 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center p-2 bg-purple-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                {{ __('Pertanyaan yang Sering Diajukan') }}
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                {{ __('Temukan jawaban untuk pertanyaan Anda') }}
            </p>
        </div>
        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ openFaq: null }">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                <button @click="openFaq = openFaq === 1 ? null : 1" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between group">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors">
                            <span class="text-purple-600 font-bold">1</span>
                        </div>
                        <span class="font-bold text-slate-900 group-hover:text-purple-600 transition-colors text-base md:text-lg">
                            {{ __('Bagaimana cara memesan tiket pendakian?') }}
                        </span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300 flex-shrink-0 ml-4" 
                         :class="{ 'rotate-180 text-purple-600': openFaq === 1 }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 1" 
                     x-collapse 
                     class="px-6 pb-5">
                    <div class="pl-14 pr-4">
                        <p class="text-slate-600 leading-relaxed">
                            {{ __('Pilih gunung yang ingin didaki, pilih tanggal dan jalur, isi data pendaki, lalu lakukan pembayaran. E-ticket akan dikirim ke email Anda.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                <button @click="openFaq = openFaq === 2 ? null : 2" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between group">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                            <span class="text-blue-600 font-bold">2</span>
                        </div>
                        <span class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors text-base md:text-lg">
                            {{ __('Apakah bisa membatalkan booking?') }}
                        </span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300 flex-shrink-0 ml-4" 
                         :class="{ 'rotate-180 text-blue-600': openFaq === 2 }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 2" 
                     x-collapse 
                     class="px-6 pb-5">
                    <div class="pl-14 pr-4">
                        <p class="text-slate-600 leading-relaxed">
                            {{ __('Ya, pembatalan dapat dilakukan sesuai dengan ketentuan yang berlaku. Silakan hubungi customer service kami untuk informasi lebih lanjut.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                <button @click="openFaq = openFaq === 3 ? null : 3" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between group">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                            <span class="text-green-600 font-bold">3</span>
                        </div>
                        <span class="font-bold text-slate-900 group-hover:text-green-600 transition-colors text-base md:text-lg">
                            {{ __('Metode pembayaran apa saja yang tersedia?') }}
                        </span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300 flex-shrink-0 ml-4" 
                         :class="{ 'rotate-180 text-green-600': openFaq === 3 }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 3" 
                     x-collapse 
                     class="px-6 pb-5">
                    <div class="pl-14 pr-4">
                        <p class="text-slate-600 leading-relaxed">
                            {{ __('Kami menerima pembayaran melalui transfer bank, e-wallet (GoPay, OVO, DANA), dan kartu kredit/debit via Midtrans Payment Gateway.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- FAQ 4 -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                <button @click="openFaq = openFaq === 4 ? null : 4" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between group">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-200 transition-colors">
                            <span class="text-orange-600 font-bold">4</span>
                        </div>
                        <span class="font-bold text-slate-900 group-hover:text-orange-600 transition-colors text-base md:text-lg">
                            {{ __('Apakah perlu print e-ticket?') }}
                        </span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300 flex-shrink-0 ml-4" 
                         :class="{ 'rotate-180 text-orange-600': openFaq === 4 }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 4" 
                     x-collapse 
                     class="px-6 pb-5">
                    <div class="pl-14 pr-4">
                        <p class="text-slate-600 leading-relaxed">
                            {{ __('Tidak wajib. Anda bisa menunjukkan e-ticket digital dari smartphone Anda. Namun, kami sarankan untuk print sebagai backup.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- FAQ 5 -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                <button @click="openFaq = openFaq === 5 ? null : 5" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between group">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-pink-200 transition-colors">
                            <span class="text-pink-600 font-bold">5</span>
                        </div>
                        <span class="font-bold text-slate-900 group-hover:text-pink-600 transition-colors text-base md:text-lg">
                            {{ __('Bagaimana jika kuota penuh?') }}
                        </span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300 flex-shrink-0 ml-4" 
                         :class="{ 'rotate-180 text-pink-600': openFaq === 5 }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 5" 
                     x-collapse 
                     class="px-6 pb-5">
                    <div class="pl-14 pr-4">
                        <p class="text-slate-600 leading-relaxed">
                            {{ __('Anda bisa memilih tanggal lain atau mendaftar di waiting list. Kami akan memberitahu jika ada slot yang tersedia.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <x-modern-footer />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out-cubic',
            });
        }

        if (typeof Swiper !== 'undefined') {
            try {
                const mountainSwiper = new Swiper('.mountain-carousel', {
                    observer: true,
                    observeParents: true,
                    
                    loop: true,        
                    rewind: false,     
                    
                    slidesPerView: 1,
                    spaceBetween: 20,
                    
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: false,
                    },
                    
pagination: {
    el: '.swiper-pagination',
    clickable: true,
    dynamicBullets: false,
    renderBullet: function (index, className) {
        return '<span class="' + className + '"></span>';
    },
},
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 32,
                        },
                    },
                    
                    effect: 'slide',
                    lazy: true,
                    watchSlidesProgress: true,
                });
                
                console.log('✅ Swiper initialized successfully:', mountainSwiper);
            } catch (error) {
                console.error('❌ Swiper initialization failed:', error);
            }
        } else {
            console.error('❌ Swiper library not loaded!');
        }
    });

    
document.addEventListener('DOMContentLoaded', function() {
    
    // Intersection Observer Options
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    // Observer for general animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // For counter animation
                if (entry.target.classList.contains('scroll-counter')) {
                    animateCounters(entry.target);
                }
                
                // Unobserve after animation (animate once)
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    // Observe all animated elements
    document.querySelectorAll('.scroll-blur, .scroll-fade-up, .scroll-stagger, .scroll-counter').forEach(el => {
        observer.observe(el);
    });
    // ========================================
    // COUNTER ANIMATION FUNCTION
    // ========================================
function animateCounters(container) {
    const counters = container.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const targetAttr = counter.getAttribute('data-target');
        
        // Skip if no data-target (like 24/7)
        if (!targetAttr) return;
        
        const target = parseInt(targetAttr);
        const suffix = counter.getAttribute('data-suffix') || '';
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        const updateCounter = () => {
            current += increment;
            
            if (current < target) {
                counter.textContent = Math.floor(current) + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target + suffix;
            }
        };
        updateCounter();
    });
}
});
</script>

</body>
</html>