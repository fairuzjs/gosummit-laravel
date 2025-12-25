@props(['notifications'])

<div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-2xl rounded-2xl border border-gray-100">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifikasi Penting
            </h3>
            
            <div class="flex items-center space-x-3">
                @if(count($notifications) > 0)
                    {{-- Badge Jumlah Notifikasi --}}
                    <span class="bg-white bg-opacity-30 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                        {{ count($notifications) }}
                    </span>
                    
                    {{-- Tombol Hapus Semua Notifikasi --}}
                    {{-- Asumsi rute 'notifications.deleteAll' menerima metode DELETE --}}
                    <form method="POST" action="{{ route('notifications.deleteAll') }}" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA notifikasi? Tindakan ini tidak dapat dibatalkan.')" 
                          class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus Semua Notifikasi"
                                class="text-white bg-white/20 hover:bg-white/40 p-1.5 rounded-full transition duration-150 ease-in-out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="p-6">
        {{-- Area Notifikasi dengan Scroll Bar --}}
        {{-- max-h-96: Membatasi tinggi maksimum (sekitar 24rem). overflow-y-auto: Menambahkan scroll bar vertikal. --}}
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse ($notifications as $notification)
                @php
                    $typeConfig = [
                        'warning' => [
                            'bg' => 'bg-amber-50',
                            'border' => 'border-amber-400',
                            'text' => 'text-amber-800',
                            'icon_bg' => 'bg-amber-100',
                            'icon_color' => 'text-amber-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
                        ],
                        'promo' => [
                            'bg' => 'bg-green-50',
                            'border' => 'border-green-400',
                            'text' => 'text-green-800',
                            'icon_bg' => 'bg-green-100',
                            'icon_color' => 'text-green-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'
                        ],
                        'info' => [
                            'bg' => 'bg-blue-50',
                            'border' => 'border-blue-400',
                            'text' => 'text-blue-800',
                            'icon_bg' => 'bg-blue-100',
                            'icon_color' => 'text-blue-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                        ]
                    ];
                    
                    $config = $typeConfig[$notification->type] ?? $typeConfig['info'];
                @endphp

                <div class="flex items-start space-x-3 p-4 {{ $config['bg'] }} border-l-4 {{ $config['border'] }} rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex-shrink-0">
                        <div class="{{ $config['icon_bg'] }} rounded-full p-2">
                            <svg class="w-5 h-5 {{ $config['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $config['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold {{ $config['text'] }} mb-1">
                            {{ $notification->title }}
                        </p>
                        <p class="text-sm {{ $config['text'] }} opacity-90">
                            {{ $notification->message }}
                        </p>
                        @if(isset($notification->created_at))
                            <p class="text-xs {{ $config['text'] }} opacity-60 mt-2">
                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                    
                    {{-- Tombol Hapus Satu Notifikasi --}}
                    {{-- Asumsi rute 'notifications.delete' menerima ID notifikasi --}}
                    <div class="flex-shrink-0 ml-2 pt-1">
                        <form method="POST" action="{{ route('notifications.delete', $notification->id) }}" onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus Notifikasi Ini"
                                    class="text-gray-400 hover:text-red-600 transition duration-150 ease-in-out p-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Tidak ada notifikasi baru</p>
                    <p class="text-xs text-gray-400 mt-1">Anda akan menerima notifikasi di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>