<div>
    {{-- Custom CSS untuk Flatpickr agar indikator kuota terlihat rapi --}}
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
        }
        /* Flatpickr Customization */
        .flatpickr-calendar {
            width: auto !important;
            font-family: inherit !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #e5e7eb !important;
        }
        .flatpickr-days {
            width: auto !important;
        }
        .flatpickr-day {
            max-width: 40px !important;
            height: 40px !important;
            line-height: 32px !important;
            margin: 2px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            color: #374151 !important;
            position: relative !important;
            border: 1px solid transparent !important;
        }
        .flatpickr-day.flatpickr-disabled {
            color: #d1d5db !important;
            cursor: not-allowed !important;
        }
        /* Kuota Hijau (Aman) */
        .flatpickr-day.quota-green {
            background-color: #ecfdf5 !important;
            border-color: #10b981 !important;
            color: #065f46 !important;
        }
        .flatpickr-day.quota-green.selected {
            background-color: #10b981 !important;
            color: white !important;
        }
        /* Kuota Kuning (Sedang) */
        .flatpickr-day.quota-yellow {
            background-color: #fffbeb !important;
            border-color: #f59e0b !important;
            color: #92400e !important;
        }
        .flatpickr-day.quota-yellow.selected {
            background-color: #f59e0b !important;
            color: white !important;
        }
        /* Kuota Merah (Tipis) */
        .flatpickr-day.quota-red {
            background-color: #fef2f2 !important;
            border-color: #ef4444 !important;
            color: #991b1b !important;
        }
        .flatpickr-day.quota-red.selected {
            background-color: #ef4444 !important;
            color: white !important;
        }
        /* Badge sisa kuota kecil di pojok */
        .quota-badge {
            position: absolute;
            bottom: 1px;
            right: 1px;
            font-size: 8px !important;
            line-height: 1;
            padding: 1px 3px;
            border-radius: 4px;
            font-weight: 700;
            background: rgba(255,255,255,0.8);
            color: #374151;
            pointer-events: none;
        }
        .selected .quota-badge {
            color: #000;
            background: rgba(255,255,255,0.9);
        }
        /* Input dengan validasi visual */
        .input-valid {
            border-color: #10b981 !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2310b981'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem !important;
        }
        .input-error {
            border-color: #ef4444 !important;
        }
        /* Responsifitas Voucher Card */
        @media (max-width: 640px) {
            .voucher-input-group {
                flex-direction: column !important;
            }
            .voucher-button {
                width: 100% !important;
                justify-content: center !important;
            }
        }
        /* Responsifitas untuk Ringkasan Booking di Bawah */
        @media (min-width: 1024px) {
            .summary-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 24px;
            }
        }
    </style>
    {{-- Load Library Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>
    {{-- Notifikasi Error Global --}}
    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 animate-shake">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-bold text-red-800">{{ __('Gagal!') }}</p>
                    <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
    <form wire:submit.prevent="submitBooking">
        {{-- KOLOM ATAS: Form Input --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 md:p-8">
                {{-- 1. Bagian Pilih Tanggal --}}
                <div class="mb-6 sm:mb-8">
                    <label for="check_in_date" class="block text-sm font-semibold text-gray-700 mb-3">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Pilih Tanggal Naik') }} <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    {{-- PENTING: wire:ignore mencegah Flatpickr ter-reset saat Livewire update --}}
                    <div wire:ignore>
                        <input type="text" 
                               id="check_in_date" 
                               class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 cursor-pointer"
                               placeholder="{{ __('Ketuk untuk memilih tanggal...') }}"
                               readonly
                               required>
                    </div>
                    @error('bookingDate') 
                        <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    {{-- Legenda Kuota --}}
                    <div class="mt-3 flex flex-wrap gap-3 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded bg-green-100 border border-green-500 mr-1.5"></div>
                            <span class="text-gray-600">{{ __('Tersedia (>50)') }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded bg-yellow-100 border border-yellow-500 mr-1.5"></div>
                            <span class="text-gray-600">{{ __('Terbatas (11-50)') }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded bg-red-100 border border-red-500 mr-1.5"></div>
                            <span class="text-gray-600">{{ __('Kritis (≤10)') }}</span>
                        </div>
                    </div>
                </div>
                {{-- 2. Bagian Pilih Jalur --}}
                <div class="mb-6 sm:mb-8">
                    <label for="selected_trail_route_id" class="block text-sm font-semibold text-gray-700 mb-3">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Pilih Jalur Pendakian') }} <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    <select wire:model="routeId" 
                            id="selected_trail_route_id"
                            class="w-full px-3 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 hover:border-gray-300"
                            required>
                        <option value="">{{ __('-- Pilih Jalur --') }}</option>
                        @foreach($mountain->trailRoutes->where('status', 'open') as $route)
                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                        @endforeach
                    </select>
                    @error('routeId') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
                    @if($routeId)
                        @php $selectedRoute = $mountain->trailRoutes->find($routeId); @endphp
                        @if($selectedRoute && $selectedRoute->description)
                            <div class="mt-3 bg-purple-50 border border-purple-100 rounded-lg p-3 animate-slide-down">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-purple-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs text-purple-800">
                                        <span class="font-semibold">{{ __('Info Jalur:') }}</span> {{ $selectedRoute->description }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                {{-- Divider --}}
                <div class="relative mb-6 sm:mb-8">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">{{ __('Data Anggota Rombongan') }}</span>
                    </div>
                </div>
                {{-- 3. Bagian Anggota Rombongan - REDESIGNED --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('Daftar Pendaki') }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Maksimal 10 orang per rombongan') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="total_members_input" class="text-sm font-medium text-gray-700">{{ __('Jumlah:') }}</label>
                            <input type="number" 
                                   id="total_members_input"
                                   wire:model.live="totalMembers"
                                   min="1" 
                                   max="10" 
                                   class="w-20 px-3 py-2 text-center font-bold text-gray-900 bg-white border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                   placeholder="1-10">
                            <span class="text-sm text-gray-600">{{ __('orang') }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach($members as $index => $member)
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 sm:p-5 border-2 {{ $index == 0 ? 'border-purple-300' : 'border-gray-200' }} relative group hover:shadow-md transition-all duration-200">
                                {{-- Badge Ketua/Anggota --}}
                                <div class="absolute -top-3 left-4 {{ $index == 0 ? 'bg-gradient-to-r from-purple-600 to-purple-700' : 'bg-gradient-to-r from-gray-600 to-gray-700' }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                                    @if($index == 0)
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        {{ __('Ketua Rombongan') }}
                                    @else
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Anggota') }} {{ $index }}
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                    {{-- Input Nama Lengkap --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                                            {{ __('Nama Lengkap') }} <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               wire:model.blur="members.{{ $index }}.name" 
                                               class="w-full px-3 py-2.5 bg-white border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all {{ !empty($member['name']) && strlen($member['name']) >= 3 ? 'input-valid' : '' }}" 
                                               placeholder="Sesuai KTP/SIM/Passport" 
                                               required>
                                        @error('members.'.$index.'.name') 
                                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    {{-- Input No. Identitas --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                                            {{ __('No. Identitas (KTP/SIM/Passport)') }} <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               wire:model.blur="members.{{ $index }}.id_number" 
                                               class="w-full px-3 py-2.5 bg-white border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm font-mono transition-all {{ !empty($member['id_number']) && strlen($member['id_number']) >= 10 ? 'input-valid' : '' }}" 
                                               placeholder="16 digit (KTP) / 12 digit (SIM)" 
                                               required>
                                        <p class="mt-1 text-[10px] text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('KTP: 16 digit, SIM: 12 digit, Passport: bervariasi') }}
                                        </p>
                                        @error('members.'.$index.'.id_number') 
                                            <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Indikator Data Valid --}}
                                @if(!empty($member['name']) && !empty($member['id_number']) && strlen($member['name']) >= 3 && strlen($member['id_number']) >= 10)
                                    <div class="mt-3 pt-3 border-t border-gray-200 flex items-center text-green-700 text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Data tersimpan') }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
{{-- 4. Bagian Voucher - REDESIGNED --}}
<div class="mb-6">
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-xl border-2 border-blue-100 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-200 opacity-20 rounded-full blur-2xl"></div>
        <div class="relative">
            <label for="voucher_code" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                {{ __('Punya Kode Voucher?') }}
            </label>
            <div class="voucher-input-group flex gap-2">
                <div class="flex-1 relative">
                    <input type="text" 
                           wire:model.defer="voucherCode" 
                           id="voucher_code_input"
                           class="w-full px-4 py-3 pr-12 text-sm font-bold border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase placeholder-gray-400 bg-white"
                           placeholder="Masukkan kode diskon"
                           {{ $appliedVoucher ? 'readonly' : '' }}>
                    
                    {{-- Button X di dalam input --}}
                    @if($appliedVoucher)
                        <button type="button" 
                                wire:click="removeVoucher"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 hover:bg-red-100 rounded-lg transition-all group"
                                title="Hapus Voucher">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
                
                @if(!$appliedVoucher)
                    <button type="button" 
                            wire:click="applyVoucher" 
                            class="voucher-button px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all hover:scale-105 active:scale-95 shadow-md flex items-center gap-2">
                        {{ __('Gunakan') }}
                    </button>
                @endif
            </div>
            {{-- Pesan Voucher --}}
            @if(session()->has('voucher_success'))
                <div class="mt-3 bg-green-100 border border-green-300 rounded-lg p-3 animate-slide-down">
                    <p class="text-xs text-green-800 font-bold flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('voucher_success') }}
                    </p>
                </div>
            @endif
            @if(session()->has('voucher_error'))
                <div class="mt-3 bg-red-100 border border-red-300 rounded-lg p-3 animate-shake">
                    <p class="text-xs text-red-800 font-bold flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('voucher_error') }}
                    </p>
                </div>
            @endif
            {{-- Info Voucher Applied --}}
            @if($appliedVoucher)
                <div class="mt-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg p-4 flex items-center shadow-md animate-slide-down">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="font-bold text-sm">Voucher "{{ $appliedVoucher->code }}" Aktif!</p>
                        <p class="text-xs opacity-90 mt-1">{{ __('Hemat Rp') }} {{ number_format($discountAmount, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

        {{-- RINGKASAN BOOKING (DI BAWAH FORM) --}}
        @if($bookingDate || $routeId)
            <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-200 overflow-hidden mb-6 animate-slide-down">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-5 py-4">
                    <h3 class="text-white font-bold text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Ringkasan Booking') }}
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    {{-- Info Gunung --}}
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500 font-medium">{{ __('Destinasi') }}</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mountain->name }}</p>
                        </div>
                    </div>
                    {{-- Info Tanggal --}}
                    @if($bookingDate)
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500 font-medium">{{ __('Tanggal Naik') }}</p>
                                <p class="text-sm font-bold text-gray-900">
                                    @php
                                        $date = \Carbon\Carbon::parse($bookingDate);
                                        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian');
                                    @endphp
                                    {{ $date->isoFormat('D MMMM Y') }}
                                </p>
                            </div>
                        </div>
                    @endif
                    {{-- Info Jalur --}}
                    @if($routeId)
                        @php $selectedRoute = $mountain->trailRoutes->find($routeId); @endphp
                        @if($selectedRoute)
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500 font-medium">{{ __('Jalur Pendakian') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $selectedRoute->name }}</p>
                                </div>
                            </div>
                        @endif
                    @endif
                    {{-- Info Jumlah Pendaki --}}
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500 font-medium">{{ __('Jumlah Pendaki') }}</p>
                            <p class="text-sm font-bold text-gray-900">{{ count($members) }} Orang</p>
                        </div>
                    </div>
                    {{-- Divider --}}
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">{{ __('Rincian Biaya') }}</h4>
                        {{-- Harga Tiket --}}
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">{{ __('Harga Tiket') }} ({{ count($members) }}x)</span>
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        {{-- Diskon Voucher --}}
                        @if($discountAmount > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-green-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    {{ __('Diskon Voucher') }}
                                </span>
                                <span class="text-sm font-semibold text-green-600">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        {{-- Total Akhir --}}
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-bold text-gray-900">{{ __('Total Pembayaran') }}</span>
                                <span class="text-xl font-bold text-purple-600">Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- CARD TOTAL PEMBAYARAN & BUTTON SUBMIT --}}
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 relative">
                {{-- Background Decoration --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-purple-600 opacity-20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    @if($bookingDate)
                        <div class="mb-4">
                            <p class="text-gray-400 text-xs uppercase tracking-wider font-bold mb-2">{{ __('Total Pembayaran') }}</p>
                            @if($discountAmount > 0)
                                <p class="text-lg text-gray-400 line-through mb-1">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                            @endif
                            <p class="text-4xl font-bold text-white mb-1">Rp {{ number_format($finalPrice, 0, ',', '.') }}</p>
                            @if($discountAmount > 0)
                                <div class="inline-flex items-center bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full mt-2">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('Hemat') }} Rp {{ number_format($discountAmount, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-xl transition-all transform hover:scale-90 active:scale-80 shadow-lg flex items-center justify-center group">
                            {{ __('Lanjut ke Pembayaran') }}
                        </button>
                        <div class="mt-4 flex items-center justify-center text-xs text-gray-400">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('Pembayaran aman & terenkripsi') }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400 text-sm font-medium mb-2">{{ __('Pilih tanggal terlebih dahulu') }}</p>
                            <p class="text-gray-500 text-xs">{{ __('Untuk melanjutkan ke pembayaran') }}</p>
                        </div>
                        <button type="button" 
                                disabled 
                                class="w-full bg-gray-700 text-gray-500 font-bold py-4 px-6 rounded-xl cursor-not-allowed opacity-50">
                            {{ __('Pilih Tanggal Dahulu') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- INFO SECURITY --}}
        <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-xs font-semibold text-blue-900 mb-1">{{ __('Informasi Penting') }}</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• {{ __('Data Anda aman dan terenkripsi') }}</li>
                        <li>• {{ __('Pastikan data sesuai identitas asli') }}</li>
                        <li>• {{ __('Booking dapat dibatalkan sesuai ketentuan') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    {{-- Script Inisialisasi Flatpickr yang Kuat --}}
    <script>
    document.addEventListener('livewire:init', () => {
        // Fungsi utama inisialisasi
        function initFlatpickr() {
            // Ambil data kuota dari PHP yang dikirim via mount()
            // Kita filter kuota > 0 dan format agar mudah dicari
            const rawQuotas = @json($quotas);
            // Ubah array object menjadi map agar pencarian cepat: "2023-10-25" => 50
            let quotaMap = {};
            if (Array.isArray(rawQuotas)) {
                rawQuotas.forEach(q => {
                    quotaMap[q.date] = q.remaining_quota;
                });
            } else {
                // Fallback jika struktur data beda (misal collection)
                for (const key in rawQuotas) {
                    if (rawQuotas[key].date && rawQuotas[key].remaining_quota) {
                        quotaMap[rawQuotas[key].date] = rawQuotas[key].remaining_quota;
                    }
                }
            }
            const inputElement = document.getElementById('check_in_date');
            if (!inputElement) return;
            // Hapus instance lama jika ada (penting saat re-render)
            if (inputElement._flatpickr) {
                inputElement._flatpickr.destroy();
            }
            flatpickr(inputElement, {
                dateFormat: "d-m-Y",  // Format: DD-MM-YYYY (contoh: 30-11-2025)
                altInput: true,       // Gunakan alternate input untuk display
                altFormat: "d-m-Y",   // Format tampilan yang sama
                minDate: "today",     // Mencegah pilih tanggal lewat
                locale: "id",         // Bahasa Indonesia
                disableMobile: true,  // Paksa tampilan custom di HP
                // Fungsi untuk menonaktifkan tanggal tanpa kuota
                disable: [
                    function(date) {
                        // Convert date object ke string YYYY-MM-DD lokal (bukan UTC)
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const dateString = `${year}-${month}-${day}`;
                        // Cek di map, jika undefined atau <= 0, disable
                        return !quotaMap.hasOwnProperty(dateString) || quotaMap[dateString] <= 0;
                    }
                ],
                // Fungsi untuk memodifikasi tampilan setiap tanggal (warna & badge)
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const dateString = `${year}-${month}-${day}`;
                    if (quotaMap.hasOwnProperty(dateString) && quotaMap[dateString] > 0) {
                        const sisa = quotaMap[dateString];
                        let className = '';
                        // Tentukan warna berdasarkan sisa kuota
                        if (sisa <= 10) {
                            className = 'quota-red';
                        } else if (sisa <= 50) {
                            className = 'quota-yellow';
                        } else {
                            className = 'quota-green';
                        }
                        dayElem.classList.add(className);
                        dayElem.innerHTML += `<span class="quota-badge">${sisa}</span>`;
                    }
                },
                // Event saat tanggal dipilih
                onChange: function(selectedDates, dateStr, instance) {
                    // Kirim data ke Livewire variable $bookingDate
                    @this.set('bookingDate', dateStr);
                }
            });
        }
        // Jalankan saat pertama kali load
        initFlatpickr();
        // Jalankan ulang setiap kali Livewire selesai update DOM (misal nambah anggota)
        Livewire.on('updated', () => {
            // Beri jeda sedikit agar DOM siap
            setTimeout(initFlatpickr, 50);
        });
        // Listener khusus jika Anda memancarkan event dari komponen
        Livewire.on('component.initialized', () => {
            initFlatpickr();
        });
    });
    </script>

    {{-- Script untuk Clear Input Voucher setelah dihapus --}}
    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('updated', () => {
            // Clear input field jika voucher dihapus
            const voucherInput = document.getElementById('voucher_code_input');
            if (voucherInput && !voucherInput.hasAttribute('readonly')) {
                // Jika input tidak readonly, berarti voucher sudah dihapus
                // Focus ke input agar user bisa langsung ketik kode baru
                setTimeout(() => {
                    voucherInput.focus();
                }, 100);
            }
        });
    });
    </script>

    {{-- Member Selector Popup (Muncul saat klik "Tambah Anggota") --}}
    @if($showMemberSelector)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" wire:ignore.self>
            <div class="bg-white rounded-2xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ __('Pilih Data Anggota') }}</h3>
                    <button wire:click="closeMemberSelector" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-6">{{ __('Pilih data anggota yang tersimpan atau isi manual') }}</p>
                
                <div class="space-y-3">
                    @foreach($savedMembers as $member)
                        <button wire:click="selectSavedMember({{ $member['id'] }})"
                                class="w-full flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 cursor-pointer transition-all text-left group">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 transition-colors">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="font-bold text-gray-900">{{ $member['name'] }}</p>
                                <p class="text-sm text-gray-600">{{ $member['id_number'] }} • {{ $member['phone'] }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    <button wire:click="skipMemberSelection" 
                            class="w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-1.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('Isi Manual') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>