<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Informasi Pendakian - GoSummit</title>
    <meta name="description" content="Update terbaru seputar dunia pendakian gunung di Indonesia. Informasi, tips, peraturan, dan event pendakian.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hero Carousel Styles */
        .news-hero-carousel {
            height: 600px;
        }

        .news-hero-carousel .swiper-slide {
            position: relative;
            overflow: hidden;
        }

        .news-hero-carousel .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 8s ease;
        }

        .news-hero-carousel .swiper-slide-active img {
            transform: scale(1.1);
        }

        /* Navigation Buttons */
        .news-hero-carousel .swiper-button-prev,
        .news-hero-carousel .swiper-button-next {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .news-hero-carousel .swiper-button-prev:after,
        .news-hero-carousel .swiper-button-next:after {
            font-size: 20px;
            font-weight: 900;
            color: #7c3aed;
        }

        .news-hero-carousel .swiper-button-prev:hover,
        .news-hero-carousel .swiper-button-next:hover {
            background: #7c3aed;
            transform: scale(1.1);
        }

        .news-hero-carousel .swiper-button-prev:hover:after,
        .news-hero-carousel .swiper-button-next:hover:after {
            color: white;
        }

        /* Pagination */
        .news-hero-carousel .swiper-pagination {
            bottom: 30px !important;
        }

        .news-hero-carousel .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .news-hero-carousel .swiper-pagination-bullet-active {
            background: white;
            width: 40px;
            border-radius: 6px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .news-hero-carousel {
                height: 500px;
            }

            .news-hero-carousel .swiper-button-prev,
            .news-hero-carousel .swiper-button-next {
                width: 44px;
                height: 44px;
            }

            .news-hero-carousel .swiper-button-prev:after,
            .news-hero-carousel .swiper-button-next:after {
                font-size: 16px;
            }
        }

        /* Scrollable Buttons - Hide Scrollbar */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;  /* Chrome, Safari and Opera */
        }

        /* Smooth Scrolling */
        .scrollbar-hide {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50">

    <x-modern-header />

    {{-- Hero Carousel Section --}}
    @if($featuredNews->count() > 0)
        <div class="swiper news-hero-carousel">
            <div class="swiper-wrapper">
                @foreach($featuredNews as $item)
                    <div class="swiper-slide">
                        {{-- Background Image --}}
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-600 to-blue-600"></div>
                        @endif

                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>

                        {{-- Content --}}
                        <div class="absolute inset-0 flex items-end">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 w-full">
                                <div class="max-w-3xl">
                                    {{-- Category Badge --}}
                                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full mb-4
                                        @if($item->category_color == 'blue') bg-blue-500 text-white
                                        @elseif($item->category_color == 'green') bg-green-500 text-white
                                        @elseif($item->category_color == 'red') bg-red-500 text-white
                                        @elseif($item->category_color == 'purple') bg-purple-500 text-white
                                        @else bg-gray-500 text-white
                                        @endif">
                                        {{ $item->category_label }}
                                    </span>

                                    {{-- Title --}}
                                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 leading-tight drop-shadow-lg">
                                        {{ $item->title }}
                                    </h2>

                                    {{-- Excerpt --}}
                                    <p class="text-lg md:text-xl text-gray-200 mb-6 line-clamp-2 drop-shadow-md">
                                        {{ $item->excerpt }}
                                    </p>

                                    {{-- Meta Info --}}
                                    <div class="flex flex-wrap items-center gap-4 text-gray-300 text-sm mb-6">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $item->formatted_published_date }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $item->formatted_views }}
                                        </div>
                                    </div>

                                    {{-- CTA Button --}}
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                       class="inline-flex items-center px-8 py-4 bg-white text-slate-900 font-bold rounded-full hover:bg-purple-600 hover:text-white transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                                        {{ __('Read More') }}
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Navigation --}}
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            {{-- Pagination --}}
            <div class="swiper-pagination"></div>
        </div>
    @endif

    {{-- Search & Category Filter Bar --}}
    <section class="bg-white border-b shadow-sm relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            {{-- Search Bar --}}
            <div class="mb-4">
                <form action="{{ route('news.index') }}" method="GET" class="relative group max-w-2xl mx-auto">
                    <div class="relative flex items-center">
                        <div class="absolute left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search news...') }}" 
                               class="block w-full pl-12 pr-24 py-3 bg-slate-50 border border-slate-200 text-gray-900 placeholder-gray-500 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">

                        <div class="absolute right-2 top-1/2 -translate-y-1/2">
                            <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-full transition-colors">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Category Tabs --}}
            <div class="flex gap-2 flex-wrap justify-center">
                <a href="{{ route('news.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ !request('category') ? 'bg-purple-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ __('Semua') }}
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('news.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('category') == $cat ? 'bg-purple-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        @switch($cat)
                            @case('info') {{ __('Informasi') }} @break
                            @case('tips') {{ __('Tips & Trik') }} @break
                            @case('regulation') {{ __('Peraturan') }} @break
                            @case('event') {{ __('Event') }} @break
                        @endswitch
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- All News Grid --}}
    <<main class="relative pb-16 pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Title --}}
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900">
                    @if(request('category'))
                        {{ __('Berita') }} {{ ucfirst(request('category')) }}
                    @elseif(request('search'))
                        {{ __('Hasil Pencarian') }}: "{{ request('search') }}"
                    @else
                        {{ __('All News') }}
                    @endif
                </h2>
            </div>

            @if($news->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $item)
                        <article class="group bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 flex flex-col h-full">
                            {{-- Image --}}
                            <div class="relative h-64 overflow-hidden flex-shrink-0">
                                @if($item->image)
                                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" 
                                         src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-4 right-4 pointer-events-none">
                                    <span class="inline-block px-3 py-1.5 text-xs font-semibold rounded-full shadow-md
                                        @if($item->category_color == 'blue') bg-blue-500 text-white
                                        @elseif($item->category_color == 'green') bg-green-500 text-white
                                        @elseif($item->category_color == 'red') bg-red-500 text-white
                                        @elseif($item->category_color == 'purple') bg-purple-500 text-white
                                        @else bg-gray-500 text-white
                                        @endif">
                                        {{ $item->category_label }}
                                    </span>
                                </div>
                                
                                {{-- Date & Views --}}
                                <div class="absolute bottom-4 left-4 flex items-center gap-3 text-white text-xs pointer-events-none">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $item->formatted_published_date }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $item->formatted_views }}
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                    <a href="{{ route('news.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-slate-500 text-sm mb-6 line-clamp-3 flex-grow">
                                    {{ $item->excerpt }}
                                </p>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                                    <div class="flex items-center text-xs text-slate-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $item->author->name }}
                                    </div>
                                    
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                       class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-purple-600 transition-colors duration-300">
                                        {{ __('Baca') }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-3xl shadow-sm p-12 text-center border border-slate-100">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('Tidak Ada Berita') }}</h3>
                    <p class="text-slate-500 max-w-md mx-auto mb-6">{{ __('Belum ada berita yang sesuai dengan pencarian Anda.') }}</p>
                    <a href="{{ route('news.index') }}" class="inline-flex px-6 py-3 bg-slate-900 text-white font-medium rounded-full hover:bg-purple-600 transition-colors">
                        {{ __('Kembali') }}
                    </a>
                </div>
            @endif
        </div>
    </main>

    {{-- Weather Forecast Widget --}}
    <section class="py-16 bg-gradient-to-b from-slate-50 to-white" x-data="weatherWidget()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">
                    {{ __('Prakiraan Cuaca') }}
                </h2>
                <p class="text-slate-600 mb-6">
                    {{ __('Cari cuaca di lokasi manapun di Indonesia') }}
                </p>
                
                {{-- Location Search --}}
                <div class="max-w-2xl mx-auto relative">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery"
                               @input.debounce.300ms="searchLocation()"
                               @focus="showSuggestions = true"
                               placeholder="{{ __('Cari kota atau lokasi... (contoh: Jakarta, Bandung, Surabaya)') }}"
                               class="w-full px-6 py-4 pl-12 pr-12 border-2 border-slate-200 rounded-full focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all text-lg">
                        
                        <svg class="w-6 h-6 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        
                        <button @click="searchQuery = ''; searchResults = []; showSuggestions = false" 
                                x-show="searchQuery.length > 0"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Search Results Dropdown --}}
                    <template x-if="showSuggestions && Array.isArray(searchResults) && searchResults.length > 0">
                        <div @click.away="showSuggestions = false"
                             class="absolute w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-50">
                            <template x-for="location in searchResults" :key="location.name">
                                <button @click="selectLocation(location)" 
                                        class="w-full px-6 py-3 text-left hover:bg-slate-50 transition-colors border-b border-slate-100 last:border-0">
                                    <div class="font-semibold text-slate-900" x-text="location.name"></div>
                                    <div class="text-sm text-slate-500">
                                        <span x-text="location.state || ''"></span>
                                        <span x-show="location.state">, </span>
                                        <span x-text="location.country"></span>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </template>
                    
                    {{-- Loading Indicator --}}
                    <div x-show="isLoading" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>


            {{-- Suggested Locations (Quick Access) --}}
            <div x-show="!selectedLocation" class="mb-8">
                @if(count($suggestedLocations) > 0)
                    <h3 class="text-center text-sm font-semibold text-slate-600 mb-4">{{ __('Lokasi Populer') }}:</h3>
                    
                    {{-- Scrollable Button Container --}}
                    <div class="relative max-w-4xl mx-auto">
                        {{-- Left Fade Indicator --}}
                        <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-slate-50 to-transparent pointer-events-none z-10 hidden md:block"></div>
                        
                        {{-- Scrollable Buttons --}}
                        <div id="mountainScrollContainer" class="overflow-x-auto scrollbar-hide cursor-grab active:cursor-grabbing">
                            <div class="flex gap-2 px-4 pb-2" style="min-width: min-content;">
                                @foreach($suggestedLocations as $location)
                                    <button @click="quickSelectLocation('{{ $location['city'] }}, {{ $location['region'] }}')"
                                            class="px-4 py-2 bg-white border-2 border-slate-200 rounded-full text-sm font-medium text-slate-700 hover:border-purple-600 hover:text-purple-600 transition-all whitespace-nowrap flex-shrink-0 hover:shadow-md">
                                        {{ $location['name'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Right Fade Indicator --}}
                        <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-slate-50 to-transparent pointer-events-none z-10 hidden md:block"></div>
                    </div>
                    
                    {{-- Scroll Hint (Mobile) --}}
                    <p class="text-center text-xs text-slate-400 mt-2 md:hidden">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        {{ __('Geser untuk melihat lebih banyak') }}
                        <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </p>
                @else
                    <p class="text-center text-slate-500 text-sm">{{ __('Belum ada data gunung tersedia') }}</p>
                @endif
            </div>


            {{-- Default View (Initial State) --}}
            <div x-show="!selectedLocation" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($mountainWeather as $mountain => $data)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                            {{ $mountain }}
                        </h3>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-4xl font-bold text-slate-900">
                                    {{ round($data['main']['temp']) }}°C
                                </div>
                                <div class="text-sm text-slate-500 capitalize mt-1">
                                    {{ $data['weather'][0]['description'] }}
                                </div>
                            </div>
                            <img src="https://openweathermap.org/img/wn/{{ $data['weather'][0]['icon'] }}@2x.png" 
                                 alt="Weather" 
                                 class="w-16 h-16">
                        </div>

                        <div class="space-y-2 text-sm border-t border-slate-100 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600">{{ __('Kelembaban') }}</span>
                                <span class="font-semibold text-slate-900">{{ $data['main']['humidity'] }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600">{{ __('Angin') }}</span>
                                <span class="font-semibold text-slate-900">{{ round($data['wind']['speed'] * 3.6, 1) }} km/h</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Selected Location Detail View --}}
            <div x-show="selectedLocation" x-cloak class="max-w-5xl mx-auto">
                {{-- Back Button --}}
                <button @click="clearSelection()" 
                        class="mb-6 inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-full hover:bg-slate-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali') }}
                </button>

                {{-- Current Weather (Large Card) --}}
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl shadow-2xl p-8 mb-6 text-white">
                    <template x-if="currentWeather">
                        <div>
                            <h3 class="text-2xl font-bold mb-2" x-text="selectedLocation.name"></h3>
                            <p class="text-blue-100 mb-6">
                                <span x-text="selectedLocation.state || ''"></span>
                                <span x-show="selectedLocation.state">, </span>
                                <span x-text="selectedLocation.country"></span>
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-6xl font-bold mb-2">
                                        <span x-text="Math.round(currentWeather.main.temp)"></span>°C
                                    </div>
                                    <div class="text-xl capitalize" x-text="currentWeather.weather[0].description"></div>
                                </div>
                                <img :src="'https://openweathermap.org/img/wn/' + currentWeather.weather[0].icon + '@4x.png'" 
                                     alt="Weather" 
                                     class="w-32 h-32">
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4 mt-8 pt-6 border-t border-white/20">
                                <div>
                                    <div class="text-blue-100 text-sm mb-1">{{ __('Kelembaban') }}</div>
                                    <div class="text-2xl font-bold" x-text="currentWeather.main.humidity + '%'"></div>
                                </div>
                                <div>
                                    <div class="text-blue-100 text-sm mb-1">{{ __('Angin') }}</div>
                                    <div class="text-2xl font-bold" x-text="Math.round(currentWeather.wind.speed * 3.6) + ' km/h'"></div>
                                </div>
                                <div>
                                    <div class="text-blue-100 text-sm mb-1">{{ __('Tekanan') }}</div>
                                    <div class="text-2xl font-bold" x-text="currentWeather.main.pressure + ' hPa'"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>


                {{-- 5-Day Forecast --}}
                <template x-if="Array.isArray(forecast) && forecast.length > 0">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ __('Prakiraan 5 Hari') }}</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                            <template x-for="day in forecast" :key="day.date">
                                <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow border border-slate-100">
                                    <div class="text-sm font-semibold text-slate-600 mb-2" x-text="day.day_name"></div>
                                    <img :src="'https://openweathermap.org/img/wn/' + day.icon + '@2x.png'" 
                                         alt="Weather" 
                                         class="w-16 h-16 mx-auto">
                                    <div class="text-2xl font-bold text-slate-900 mb-1">
                                        <span x-text="day.temp"></span>°C
                                    </div>
                                    <div class="text-xs text-slate-500 capitalize mb-2 line-clamp-2" x-text="day.description"></div>
                                    <div class="flex justify-between text-xs text-slate-600 pt-2 border-t border-slate-100">
                                        <span><span x-text="day.temp_min"></span>°</span>
                                        <span><span x-text="day.temp_max"></span>°</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Disclaimer --}}
            <div class="mt-8 text-center">
                <p class="text-xs text-slate-500 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Data cuaca diperbarui setiap 30 menit. Powered by OpenWeatherMap.') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function weatherWidget() {
            return {
                searchQuery: '',
                searchResults: [],
                showSuggestions: false,
                selectedLocation: null,
                currentWeather: null,
                forecast: [],
                isLoading: false,
                
                async searchLocation() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    
                    this.isLoading = true;
                    
                    try {
                        const response = await fetch(`/api/weather/search?q=${encodeURIComponent(this.searchQuery)}`);
                        const data = await response.json();
                        this.searchResults = data;
                        this.showSuggestions = true;
                    } catch (error) {
                        console.error('Search error:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },
                
                async selectLocation(location) {
                    this.selectedLocation = location;
                    this.showSuggestions = false;
                    this.searchQuery = location.name;
                    this.isLoading = true;
                    
                    try {
                        const response = await fetch(`/api/weather/current?lat=${location.lat}&lon=${location.lon}`);
                        const data = await response.json();
                        this.currentWeather = data.current;
                        this.forecast = data.forecast || [];
                    } catch (error) {
                        console.error('Weather fetch error:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },
                
                async quickSelectLocation(cityName) {
                    this.searchQuery = cityName;
                    await this.searchLocation();
                    
                    // Auto-select first result
                    if (this.searchResults.length > 0) {
                        await this.selectLocation(this.searchResults[0]);
                    }
                },
                
                clearSelection() {
                    this.selectedLocation = null;
                    this.currentWeather = null;
                    this.forecast = [];
                    this.searchQuery = '';
                    this.searchResults = [];
                }
            }
        }
    </script>

    {{-- Mountain Buttons Scroll Enhancement --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainer = document.getElementById('mountainScrollContainer');
            
            if (scrollContainer) {
                // Mouse Wheel Horizontal Scroll
                scrollContainer.addEventListener('wheel', function(e) {
                    if (e.deltaY !== 0) {
                        e.preventDefault();
                        scrollContainer.scrollLeft += e.deltaY;
                    }
                });

                // Drag to Scroll
                let isDown = false;
                let startX;
                let scrollLeft;


                scrollContainer.addEventListener('mousedown', function(e) {
                    // Don't interfere with button clicks
                    if (e.target.tagName === 'BUTTON') return;
                    
                    isDown = true;
                    scrollContainer.style.cursor = 'grabbing';
                    startX = e.pageX - scrollContainer.offsetLeft;
                    scrollLeft = scrollContainer.scrollLeft;
                });

                scrollContainer.addEventListener('mouseleave', function() {
                    isDown = false;
                    scrollContainer.style.cursor = 'grab';
                });

                scrollContainer.addEventListener('mouseup', function() {
                    isDown = false;
                    scrollContainer.style.cursor = 'grab';
                });

                scrollContainer.addEventListener('mousemove', function(e) {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - scrollContainer.offsetLeft;
                    const walk = (x - startX) * 2; // Scroll speed multiplier
                    scrollContainer.scrollLeft = scrollLeft - walk;
                });
            }
        });
    </script>


    <x-modern-footer />

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Hero Carousel
        const heroSwiper = new Swiper('.news-hero-carousel', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

</body>
</html>
