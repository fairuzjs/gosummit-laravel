<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - GoSummit</title>
    <meta name="description" content="{{ Str::limit($news->excerpt, 160) }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Article Typography */
        .article-content {
            font-size: 1.125rem;
            line-height: 1.875;
            color: #334155;
        }
        
        .article-content p {
            margin-bottom: 1.5em;
        }
        
        .article-content h1, .article-content h2, .article-content h3 {
            font-weight: 700;
            margin-top: 2.5em;
            margin-bottom: 1em;
            line-height: 1.3;
            color: #0f172a;
        }
        
        .article-content h1 { font-size: 2.25em; }
        .article-content h2 { font-size: 1.875em; }
        .article-content h3 { font-size: 1.5em; }
        
        .article-content ul, .article-content ol {
            margin: 1.5em 0;
            padding-left: 2em;
        }
        
        .article-content li {
            margin: 0.75em 0;
        }
        
        .article-content strong {
            font-weight: 600;
            color: #1e293b;
        }
        
        .article-content a {
            color: #7c3aed;
            text-decoration: underline;
            transition: color 0.2s;
        }
        
        .article-content a:hover {
            color: #6d28d9;
        }
        
        .article-content img {
            border-radius: 1rem;
            margin: 2.5em 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .article-content blockquote {
            border-left: 4px solid #7c3aed;
            padding-left: 1.5em;
            margin: 2em 0;
            font-style: italic;
            color: #475569;
        }

        /* Featured Image Container */
        .featured-image-container {
            position: relative;
            width: 100%;
            max-height: 500px;
            overflow: hidden;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .featured-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>
<body class="antialiased bg-slate-50">

    <x-modern-header />

    {{-- Breadcrumbs --}}
    <div class="bg-white border-b sticky top-16 z-20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-purple-600 transition-colors font-medium">Home</a>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('news.index') }}" class="text-slate-500 hover:text-purple-600 transition-colors font-medium">Berita</a>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-slate-900 font-semibold truncate">{{ Str::limit($news->title, 50) }}</span>
            </nav>
        </div>
    </div>

    {{-- Article Content --}}
    <article class="py-12 lg:py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Category Badge --}}
            <div class="mb-6">
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full shadow-sm
                    @if($news->category_color == 'blue') bg-blue-500 text-white
                    @elseif($news->category_color == 'green') bg-green-500 text-white
                    @elseif($news->category_color == 'red') bg-red-500 text-white
                    @elseif($news->category_color == 'purple') bg-purple-500 text-white
                    @else bg-gray-500 text-white
                    @endif">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ $news->category_label }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
                {{ $news->title }}
            </h1>

            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center gap-6 text-slate-600 mb-10 pb-8 border-b-2 border-slate-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-lg">
                        {{ substr($news->author->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $news->author->name }}</div>
                        <div class="text-xs text-slate-500">{{ __('Author') }}</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ $news->formatted_published_date }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ $news->views }} {{ __('views') }}</span>
                </div>
            </div>


            {{-- Featured Image with Controlled Height & Lightbox --}}
            @if($news->image)
                <div x-data="{ showLightbox: false }" class="mb-10">
                    {{-- Clickable Image Container --}}
                    <div @click="showLightbox = true" 
                         class="featured-image-container cursor-pointer group relative">
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}">
                        
                        {{-- Hover Overlay with Zoom Icon --}}
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                            <div class="transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                <div class="bg-white rounded-full p-4 shadow-2xl">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-center text-sm text-slate-500 mt-3 italic">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('Klik gambar untuk melihat ukuran penuh') }}
                    </p>
                    
                    {{-- Lightbox Modal --}}
                    <div x-show="showLightbox" 
                         x-cloak
                         @click="showLightbox = false"
                         @keydown.escape.window="showLightbox = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
                         style="display: none;">
                        
                        {{-- Close Button --}}
                        <button @click.stop="showLightbox = false"
                                class="absolute top-4 right-4 text-white hover:text-purple-400 transition-colors z-10">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        
                        {{-- Full Size Image --}}
                        <div @click.stop 
                             class="max-w-7xl max-h-full overflow-auto">
                            <img src="{{ asset('storage/' . $news->image) }}" 
                                 alt="{{ $news->title }}"
                                 class="w-auto h-auto max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                        </div>
                        
                        {{-- Instructions --}}
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm bg-black bg-opacity-50 px-4 py-2 rounded-full">
                            <span class="hidden sm:inline">{{ __('Klik di luar gambar atau tekan ESC untuk menutup') }}</span>
                            <span class="sm:hidden">{{ __('Tap di luar gambar untuk menutup') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Excerpt Box --}}
            <div class="bg-gradient-to-r from-purple-50 via-blue-50 to-purple-50 border-l-4 border-purple-600 p-8 rounded-2xl mb-12 shadow-sm">
                <div class="flex items-start">
                    <svg class="w-8 h-8 text-purple-600 mr-4 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg text-slate-700 leading-relaxed font-medium">
                        {{ $news->excerpt }}
                    </p>
                </div>
            </div>

            {{-- Article Content --}}
            <div class="article-content bg-white rounded-2xl p-8 lg:p-12 shadow-sm">
                {!! $news->content !!}
            </div>

            {{-- Share & Back Section --}}
            <div class="mt-12 pt-8 border-t-2 border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('news.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-900 to-slate-700 text-white font-bold rounded-full hover:from-purple-600 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali ke Daftar Berita') }}
                </a>
                
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-600 font-medium">{{ __('Bagikan:') }}</span>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}" 
                           target="_blank"
                           class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->slug)) }}&text={{ urlencode($news->title) }}" 
                           target="_blank"
                           class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center hover:bg-sky-600 transition-colors shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('news.show', $news->slug)) }}" 
                           target="_blank"
                           class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>

    {{-- Related News --}}
    @if($relatedNews->count() > 0)
        <section class="py-16 bg-gradient-to-b from-white to-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900">{{ __('Related News') }}</h2>
                    <a href="{{ route('news.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center">
                        {{ __('Lihat Semua') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedNews as $item)
                        <article class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-purple-200">
                            {{-- Image --}}
                            <div class="relative h-56 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full shadow-lg
                                        @if($item->category_color == 'blue') bg-blue-500 text-white
                                        @elseif($item->category_color == 'green') bg-green-500 text-white
                                        @elseif($item->category_color == 'red') bg-red-500 text-white
                                        @elseif($item->category_color == 'purple') bg-purple-500 text-white
                                        @endif">
                                        {{ $item->category_label }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                    <a href="{{ route('news.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <p class="text-slate-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ $item->excerpt }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-slate-500 pt-4 border-t border-slate-100">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $item->formatted_published_date }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ $item->formatted_views }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-modern-footer />

</body>
</html>
