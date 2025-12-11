<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ showImageModal: false, modalImage: '', modalTitle: '' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Temukan Destinasimu') }} - GoSummit</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        
        /* Custom scrollbar untuk dropdown */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Utilitas tambahan untuk line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50">

    <x-modern-header />

    <div class="relative z-30 pt-16 pb-24 bg-gradient-to-b from-slate-900 to-slate-800">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg" data-aos="fade-down">
                {{ __('Temukan Destinasimu') }}
            </h1>
            <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto drop-shadow-md" data-aos="fade-up" data-aos-delay="100">
                {{ __('Jelajahi keindahan pegunungan Indonesia. Cari destinasi impianmu sekarang.') }}
            </p>

            <div class="max-w-2xl mx-auto relative" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('mountains.list') }}" method="GET" class="relative group" autocomplete="off" id="search-form">
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-0 pl-5 flex items-center pointer-events-none z-10">
                            <svg class="h-6 w-6 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input type="text" 
                               name="search" 
                               id="search-input"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Cari nama gunung atau lokasi...') }}" 
                               class="block w-full pl-14 pr-32 py-4 bg-white border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-full focus:outline-none focus:ring-4 focus:ring-purple-500/30 focus:border-purple-500 text-lg shadow-xl transition-all duration-300 relative z-0"
                        >

                        <button type="button" id="reset-btn" class="absolute right-28 text-gray-400 hover:text-red-500 hidden transition-colors z-10 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="absolute right-2 top-2 bottom-2 z-10">
                            <button type="submit" class="h-full px-6 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-full transition-colors shadow-md flex items-center justify-center">
                                {{ __('Cari') }}
                            </button>
                        </div>
                    </div>
                    
                    <div id="autocomplete-list" class="absolute mt-2 w-full bg-white rounded-2xl shadow-2xl z-[70] hidden overflow-hidden border border-slate-100 divide-y divide-slate-100 animate-in fade-in zoom-in-95 duration-200">
                        </div>
                </form>
            </div>
        </div>
    </div>

    <main class="relative z-20 pb-20 pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($mountains) && $mountains->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($mountains as $mountain)
                    
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 flex flex-col h-full"
                         data-aos="fade-up">
                        
                        <div class="relative h-64 overflow-hidden flex-shrink-0 cursor-pointer group/image" 
                             @click="showImageModal = true; modalImage = '{{ $mountain->image_url ? asset('storage/' . $mountain->image_url) : '' }}'; modalTitle = '{{ $mountain->name }}'; document.body.style.overflow = 'hidden';">
                            @if($mountain->image_url)
                                {{-- PERBAIKAN: Menggunakan group-hover/image agar zoom hanya aktif saat hover gambar, bukan hover seluruh kartu --}}
                                <img class="w-full h-full object-cover transform group-hover/image:scale-110 transition-transform duration-700" 
                                     src="{{ asset('storage/' . $mountain->image_url) }}" 
                                     alt="{{ $mountain->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute top-4 right-4 pointer-events-none">
                                <div class="px-3 py-1.5 bg-white/90 backdrop-blur rounded-full shadow-md">
                                    <span class="text-sm font-bold text-purple-700">Rp {{ number_format($mountain->ticket_price ?? $mountain->price_per_person ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="absolute bottom-4 left-4 flex items-center text-white pointer-events-none">
                                <svg class="w-5 h-5 mr-1 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-sm font-medium drop-shadow-md">{{ $mountain->location }}</span>
                            </div>
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            {{-- PERBAIKAN: Mengganti group-hover menjadi hover biasa agar judul berubah warna HANYA saat kursor di atas teks judul --}}
                            <h3 class="text-xl font-bold text-slate-900 mb-2 hover:text-purple-600 transition-colors">
                                {{ $mountain->name }}
                            </h3>
                            <p class="text-slate-500 text-sm mb-6 line-clamp-2 flex-grow">
                                {{ $mountain->description ?? 'Nikmati keindahan alam yang menakjubkan.' }}
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
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
                    @endforeach
                </div>
                
                <div class="mt-12 px-4">
                    {{ $mountains->links() }}
                </div>

            @else
                <div class="bg-white rounded-3xl shadow-sm p-12 text-center border border-slate-100 mt-8" data-aos="zoom-in">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('Gunung tidak ditemukan') }}</h3>
                    <p class="text-slate-500 max-w-md mx-auto mb-6">{{ __('Maaf, kami tidak dapat menemukan gunung dengan kata kunci') }} "<strong>{{ request('search') }}</strong>".</p>
                    <a href="{{ route('mountains.list') }}" class="inline-flex px-6 py-3 bg-slate-900 text-white font-medium rounded-full hover:bg-purple-600 transition-colors">
                        {{ __('Reset Pencarian') }}
                    </a>
                </div>
            @endif
        </div>
    </main>

    <x-modern-footer/>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const autocompleteList = document.getElementById('autocomplete-list');
            const resetBtn = document.getElementById('reset-btn');
            const searchForm = document.getElementById('search-form');
            let timeoutId;

            // Fungsi Toggle Reset Button
            function toggleResetBtn() {
                if (searchInput.value.length > 0) {
                    resetBtn.classList.remove('hidden');
                } else {
                    resetBtn.classList.add('hidden');
                }
            }

            // Event saat user mengetik
            searchInput.addEventListener('input', function() {
                toggleResetBtn();
                clearTimeout(timeoutId);
                const query = this.value;

                if (query.length < 2) {
                    autocompleteList.innerHTML = '';
                    autocompleteList.classList.add('hidden');
                    return;
                }

                // Debounce fetch
                timeoutId = setTimeout(() => {
                    fetch(`{{ route('mountains.autocomplete') }}?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            autocompleteList.innerHTML = '';
                            
if (data.length > 0) {
    autocompleteList.classList.remove('hidden');
    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'group px-4 py-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 cursor-pointer flex items-center gap-3 transition-all duration-200 border-b border-slate-100 last:border-0';
        
        div.innerHTML = `
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2.5 rounded-xl flex-shrink-0 group-hover:scale-110 transition-transform duration-200 shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0 text-left">
                <div class="font-bold text-slate-900 text-base mb-1 group-hover:text-purple-700 transition-colors">${item.name}</div>
                <div class="flex items-center text-xs text-slate-500">
                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="truncate">${item.location}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <div class="text-right">
                    <div class="text-xs text-slate-400 font-medium mb-0.5">Elevation</div>
                    <div class="text-base font-bold text-slate-700">${item.height ? item.height + ' m' : 'N/A'}</div>
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-purple-500 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        `;
        
        div.addEventListener('click', function() {
            searchInput.value = item.name;
            autocompleteList.classList.add('hidden');
            searchForm.submit();
        });
        
        autocompleteList.appendChild(div);
    });
} else {
    autocompleteList.classList.add('hidden');
}
                        })
                        .catch(error => console.error('Error:', error));
                }, 300);
            });

            // Event Reset Button Click
            resetBtn.addEventListener('click', function() {
                searchInput.value = '';
                toggleResetBtn();
                autocompleteList.innerHTML = '';
                autocompleteList.classList.add('hidden');
                
                // Redirect ke halaman list awal untuk reset hasil pencarian
                window.location.href = "{{ route('mountains.list') }}";
            });

            // Init Reset Button state saat load (misal ada value dari old input)
            toggleResetBtn();

            // Sembunyikan dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (e.target !== searchInput && e.target !== autocompleteList && e.target !== resetBtn) {
                    autocompleteList.classList.add('hidden');
                }
            });
            
        });
    </script>
    
    <!-- Image Modal -->
    <div x-show="showImageModal" 
         x-cloak
         @click="showImageModal = false; document.body.style.overflow = '';"
         @keydown.escape.window="showImageModal = false; document.body.style.overflow = '';"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <!-- Close Button -->
        <button @click="showImageModal = false; document.body.style.overflow = '';" 
                class="absolute top-4 right-4 z-10 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full transition-all duration-200 group">
            <svg class="w-6 h-6 text-white group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <!-- Image Container with 4:3 Aspect Ratio -->
        <div @click.stop class="relative w-full max-w-4xl"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <!-- 4:3 Aspect Ratio Container -->
            <div class="relative w-full" style="padding-bottom: 75%;">
                <!-- Image -->
                <img :src="modalImage" 
                     :alt="modalTitle"
                     class="absolute inset-0 w-full h-full object-cover rounded-2xl shadow-2xl">
                
                <!-- Gradient Overlay for Text -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent rounded-2xl pointer-events-none"></div>
                
                <!-- Image Title -->
                <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white drop-shadow-lg line-clamp-2" x-text="modalTitle"></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>