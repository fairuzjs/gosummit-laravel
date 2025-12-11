<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Croppie.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            min-height: 100vh;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .sidebar-nav {
            top: 100px;
            align-self: flex-start;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            margin-bottom: 0.5rem;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            color: white;
            border: 4px solid white;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }

        .card-modern {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .input-modern {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.9375rem;
            transition: all 0.3s;
            background: white;
        }

        .input-modern:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* Floating Notification */
        .floating-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            animation: slideInRight 0.4s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .notification-exit {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        /* Croppie Modal */
        .cropper-modal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 999999 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            backdrop-filter: blur(5px);
        }

        .cropper-container-wrapper {
            background: white;
            border-radius: 16px;
            padding: 24px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 1000000 !important;
        }

        @keyframes modalPop {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .croppie-preview-area {
            width: 100%;
            min-height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9fafb;
            border-radius: 12px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .croppie-container {
            width: 100% !important;
            height: auto !important;
        }

        .croppie-container .cr-slider-wrap {
            margin-top: 20px;
        }

        /* Mobile tabs */
        .mobile-tabs {
            display: flex;
            overflow-x: auto;
            gap: 0.5rem;
            padding: 0.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .mobile-tabs::-webkit-scrollbar {
            display: none;
        }

        .mobile-tab {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.3s;
            color: #6b7280;
        }

        .mobile-tab:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .mobile-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .password-strength-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .avatar-upload-preview {
            position: relative;
            display: inline-block;
        }

        .avatar-upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
            cursor: pointer;
        }

        .avatar-upload-preview:hover .avatar-upload-overlay {
            opacity: 1;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Floating Notifications -->
    <div x-data="{ 
message: '{{ session('status') === 'profile-updated' ? __('Profil berhasil diperbarui') : (session('status') === 'password-updated' ? __('Kata sandi berhasil diperbarui') : (session('success') ? session('success') : '')) }}',
            if (this.show) {
                setTimeout(() => {
                    this.$el.classList.add('notification-exit');
                    setTimeout(() => { this.show = false; }, 300);
                }, 3000);
            }
        }
    }" x-show="show" x-cloak class="floating-notification">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold" x-text="message"></span>
        </div>
    </div>

    <div class="min-h-screen" x-data="{ 
        activeTab: 'overview',
        profileImage: null,
        showImagePreview: false,
        previewUrl: '{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}',

        // Saved Members
        showAddForm: false,
        savedMembersCount: {{ $savedMembers->count() }},
        
        // Croppie variables
        showCropperModal: false,
        cropperInstance: null,
        originalImage: null,
        
        // Open cropper modal with Croppie
        openCropper(event) {
            const file = event.target.files[0];
            if (file) {
                this.originalImage = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.showCropperModal = true;
                    document.body.style.overflow = 'hidden';
                    
                    this.$nextTick(() => {
                        const el = document.getElementById('croppieContainer');
                        
                        // Destroy previous instance
                        if (this.cropperInstance) {
                            this.cropperInstance.destroy();
                        }
                        
                        // Initialize Croppie
                        this.cropperInstance = new Croppie(el, {
                            viewport: { width: 250, height: 250, type: 'circle' },
                            boundary: { width: 300, height: 300 },
                            showZoomer: true,
                            enableOrientation: true,
                            enableResize: false
                        });
                        
                        // Bind image
                        this.cropperInstance.bind({
                            url: e.target.result
                        });
                    });
                };
                reader.readAsDataURL(file);
            }
        },
        
        // Apply crop
        applyCrop() {
            if (this.cropperInstance) {
                this.cropperInstance.result({
                    type: 'blob',
                    size: { width: 400, height: 400 },
                    format: 'jpeg',
                    quality: 0.9,
                    circle: false
                }).then((blob) => {
                    const url = URL.createObjectURL(blob);
                    this.previewUrl = url;
                    
                    const file = new File([blob], this.originalImage.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('profilePictureInput').files = dataTransfer.files;
                    
                    this.closeCropper();
                });
            }
        },
        
        // Rotate image
        rotateImage(degrees) {
            if (this.cropperInstance) {
                this.cropperInstance.rotate(degrees);
            }
        },
        
        // Close cropper
        closeCropper() {
            if (this.cropperInstance) {
                this.cropperInstance.destroy();
                this.cropperInstance = null;
            }
            this.showCropperModal = false;
            document.body.style.overflow = '';
            if (!this.previewUrl || this.previewUrl === '{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}') {
                document.getElementById('profilePictureInput').value = '';
            }
        }
    }">
        <x-modern-header />

        <!-- Compact Header -->
        <header class="profile-header text-white py-8 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <!-- Avatar -->
                    <div class="avatar-upload-preview">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="profile-avatar-large">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="avatar-upload-overlay" @click="document.getElementById('profilePictureInput').click()">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div>
                        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                        <p class="text-purple-200">{{ $user->email }}</p>
                        <p class="text-sm text-purple-300 mt-1">{{ __('Member sejak') }} {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                    
                    <!-- Sidebar Navigation (Desktop) -->
                    <div class="lg:col-span-1 hidden lg:block">
                        <nav class="sidebar-nav card-modern">
                            <div class="nav-item" :class="{ 'active': activeTab === 'overview' }" @click="activeTab = 'overview'">
                                {{ __('Ringkasan') }}
                            </div>
                            <div class="nav-item" :class="{ 'active': activeTab === 'profile' }" @click="activeTab = 'profile'">
                                {{ __('Profil') }}
                            </div>
                            <div class="nav-item" :class="{ 'active': activeTab === 'security' }" @click="activeTab = 'security'">
                                {{ __('Keamanan') }}
                            </div>
                            <div class="nav-item" :class="{ 'active': activeTab === 'members' }" @click="activeTab = 'members'">
                                {{ __('Data Anggota') }}
                            </div>
                            <div class="nav-item" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
                                {{ __('Pengaturan') }}
                            </div>
                        </nav>
                    </div>

                    <!-- Mobile Tabs -->
                    <div class="lg:hidden mb-6">
                        <div class="mobile-tabs">
                            <div class="mobile-tab" :class="{ 'active': activeTab === 'overview' }" @click="activeTab = 'overview'">
                                {{ __('Ringkasan') }}
                            </div>
                            <div class="mobile-tab" :class="{ 'active': activeTab === 'profile' }" @click="activeTab = 'profile'">
                                {{ __('Profil') }}
                            </div>
                            <div class="mobile-tab" :class="{ 'active': activeTab === 'security' }" @click="activeTab = 'security'">
                                {{ __('Keamanan') }}
                            </div>
                            <div class="mobile-tab" :class="{ 'active': activeTab === 'members' }" @click="activeTab = 'members'">
                                {{ __('Data Anggota') }}
                            </div>
                            <div class="mobile-tab" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
                                {{ __('Pengaturan') }}
                            </div>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="lg:col-span-3">
                        
                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" x-cloak>
                            <div class="card-modern">
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Selamat Datang') }}, {{ $user->name }}!</h2>
                                <p class="text-gray-600 mb-6">{{ __('Kelola profil dan keamanan akun Anda dengan mudah.') }}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl border-2 border-purple-100">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">{{ __('Informasi Profil') }}</p>
                                                <p class="text-lg font-bold text-gray-800">{{ $user->name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-100">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">{{ __('Email') }}</p>
                                                <p class="text-lg font-bold text-gray-800 truncate">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">{{ __('Tips Keamanan') }}</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>{{ __('Gunakan kata sandi yang kuat dan unik') }}</li>
                                                    <li>{{ __('Perbarui informasi profil Anda secara berkala') }}</li>
                                                    <li>{{ __('Jangan bagikan kata sandi kepada siapa pun') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Tab -->
                        <div x-show="activeTab === 'profile'" x-cloak>
                            <div class="card-modern">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Informasi Profil') }}</h2>
                                <p class="text-gray-600 mb-6">{{ __('Perbarui informasi profil dan foto Anda') }}</p>

                                <!-- Profile Picture Upload -->
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="mb-8 pb-6 border-b border-gray-200">
                                        <label class="block text-sm font-semibold text-gray-700 mb-4">{{ __('Foto Profil') }}</label>
                                        <div class="flex items-center gap-6">
                                            <div class="avatar-upload-preview">
                                                <template x-if="previewUrl">
                                                    <img :src="previewUrl" alt="Profile" class="profile-avatar-large">
                                                </template>
                                                <template x-if="!previewUrl">
                                                    @if($user->profile_picture)
                                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="profile-avatar-large">
                                                    @else
                                                        <div class="avatar-placeholder">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </template>
                                            </div>
                                            <div>
                                                <input type="file" 
                                                       id="profilePictureInput"
                                                       name="profile_picture" 
                                                       accept="image/*"
                                                       class="hidden"
                                                       @change="openCropper($event)">
                                                <button type="button" 
                                                        @click="document.getElementById('profilePictureInput').click()"
                                                        class="btn-secondary mb-2">
                                                    {{ __('Upload Foto') }}
                                                </button>
                                                <p class="text-xs text-gray-500">{{ __('JPG, PNG atau GIF. Maksimal 2MB.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nama Lengkap') }}</label>
                                            <input type="text" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}"
                                                   class="input-modern"
                                                   required>
                                            @error('name')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Email') }}</label>
                                            <input type="email" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}"
                                                   class="input-modern"
                                                   required>
                                            @error('email')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nomor Telepon') }}</label>
                                            <input type="text" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}"
                                                   class="input-modern"
                                                   placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="identity_number" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nomor Identitas (KTP/SIM)') }}</label>
                                            <input type="text" 
                                                   id="identity_number" 
                                                   name="identity_number" 
                                                   value="{{ old('identity_number', $user->identity_number) }}"
                                                   class="input-modern"
                                                   placeholder="16 digit KTP / 12 digit SIM">
                                            @error('identity_number')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" class="btn-primary">
                                            {{ __('Simpan Perubahan') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Tab -->
                        <div x-show="activeTab === 'security'" x-cloak x-data="{
                            password: '',
                            showPassword: false,
                            showConfirm: false,
                            strength: 0,
                            strengthText: '',
                            requirements: {
                                length: false,
                                uppercase: false,
                                lowercase: false,
                                number: false,
                                special: false
                            }
                        }">
                            <div class="card-modern">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Keamanan Akun') }}</h2>
                                <p class="text-gray-600 mb-6">{{ __('Perbarui kata sandi untuk menjaga keamanan akun') }}</p>

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="mb-6">
                                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Kata Sandi Saat Ini') }}</label>
                                        <input type="password" 
                                               id="current_password" 
                                               name="current_password"
                                               class="input-modern"
                                               required>
                                        @error('current_password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Kata Sandi Baru') }}</label>
                                        <div class="relative">
                                            <input x-bind:type="showPassword ? 'text' : 'password'" 
                                                   id="password" 
                                                   name="password"
                                                   x-model="password"
                                                   x-on:input="
                                                       requirements.length = password.length >= 8;
                                                       requirements.uppercase = /[A-Z]/.test(password);
                                                       requirements.lowercase = /[a-z]/.test(password);
                                                       requirements.number = /\d/.test(password);
                                                       requirements.special = /[!@#$%^&*(),.?:{}|<>]/.test(password);
                                                       const passed = Object.values(requirements).filter(Boolean).length;
                                                       if (password.length === 0) {
                                                           strength = 0;
                                                           strengthText = '';
                                                       } else if (passed <= 2) {
                                                           strength = 33;
                                                           strengthText = '{{ __('Lemah') }}';
                                                       } else if (passed <= 3) {
                                                           strength = 66;
                                                           strengthText = '{{ __('Sedang') }}';
                                                       } else {
                                                           strength = 100;
                                                           strengthText = '{{ __('Kuat') }}';
                                                       }
                                                   "
                                                   class="input-modern pr-12"
                                                   required>
                                            <button type="button" 
                                                    @click="showPassword = !showPassword"
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    <path x-show="showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror

                                        <!-- Password Strength -->
                                        <div class="mt-3" x-show="password.length > 0">
                                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                                <div class="password-strength-bar h-full transition-all duration-300"
                                                     :class="{
                                                         'bg-red-500': strength === 33,
                                                         'bg-yellow-500': strength === 66,
                                                         'bg-green-500': strength === 100
                                                     }"
                                                     :style="`width: ${strength}%`"></div>
                                            </div>
                                            <p class="mt-1 text-xs font-medium"
                                               :class="{
                                                   'text-red-600': strength === 33,
                                                   'text-yellow-600': strength === 66,
                                                   'text-green-600': strength === 100
                                               }"
                                               x-text="'Kekuatan: ' + strengthText"></p>
                                        </div>

                                        <!-- Requirements -->
                                        <div class="mt-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                            <h4 class="text-xs font-semibold text-gray-700 mb-2">{{ __('Persyaratan:') }}</h4>
                                            <ul class="space-y-1">
                                                <li class="flex items-center text-xs" :class="requirements.length ? 'text-green-600' : 'text-gray-600'">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path x-show="requirements.length" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        <path x-show="!requirements.length" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('Minimal 8 karakter') }}
                                                </li>
                                                <li class="flex items-center text-xs" :class="requirements.uppercase ? 'text-green-600' : 'text-gray-600'">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path x-show="requirements.uppercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        <path x-show="!requirements.uppercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('Huruf kapital') }}
                                                </li>
                                                <li class="flex items-center text-xs" :class="requirements.lowercase ? 'text-green-600' : 'text-gray-600'">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path x-show="requirements.lowercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        <path x-show="!requirements.lowercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('Huruf kecil') }}
                                                </li>
                                                <li class="flex items-center text-xs" :class="requirements.number ? 'text-green-600' : 'text-gray-600'">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path x-show="requirements.number" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        <path x-show="!requirements.number" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('Angka') }}
                                                </li>
                                                <li class="flex items-center text-xs" :class="requirements.special ? 'text-green-600' : 'text-gray-600'">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path x-show="requirements.special" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        <path x-show="!requirements.special" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('Karakter spesial') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
                                        <div class="relative">
                                            <input :type="showConfirm ? 'text' : 'password'" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation"
                                                   class="input-modern pr-12"
                                                   required>
                                            <button type="button" 
                                                    @click="showConfirm = !showConfirm"
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path x-show="!showConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path x-show="!showConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    <path x-show="showConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" class="btn-primary">
                                            {{ __('Ubah Kata Sandi') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- TAB DATA ANGGOTA (RESPONSIF YANG DIPERBAIKI) -->
                        <div x-show="activeTab === 'members'" x-cloak>
                            <div class="card-modern">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900">{{ __('Data Anggota Tersimpan') }}</h2>
                                        <p class="text-gray-600 mt-1">{{ __('Simpan data anggota untuk mempermudah booking (Max 5 anggota)') }}</p>
                                    </div>
                                    <button 
                                        @click="showAddForm = !showAddForm"
                                        :disabled="savedMembersCount >= 5"
                                        :class="savedMembersCount >= 5 ? 'opacity-50 cursor-not-allowed' : ''"
                                        class="w-full sm:w-auto px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        {{ __('Tambah Anggota') }}
                                    </button>
                                </div>

                                <!-- Add Member Form -->
                                <div x-show="showAddForm" x-cloak class="bg-purple-50 p-6 rounded-xl mb-6 border-2 border-purple-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Tambah Data Anggota Baru') }}</h3>
                                    <form method="POST" action="{{ route('profile.members.store') }}">
                                        @csrf
                                        <div class="grid md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Nama Lengkap') }}</label>
                                                <input type="text" name="name" required
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                @error('name')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Nomor Identitas (KTP/SIM)') }}</label>
                                                <input type="text" name="id_number" required
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                       placeholder="16 digit KTP / 12 digit SIM">
                                                @error('id_number')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Nomor Telepon') }}</label>
                                                <input type="text" name="phone" required
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                       placeholder="08xxxxxxxxxx">
                                                @error('phone')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex gap-2 mt-4">
                                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                                {{ __('Simpan Data') }}
                                            </button>
                                            <button type="button" @click="showAddForm = false" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                                {{ __('Batal') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @if($savedMembers->count() > 0)
                                    <!-- Mobile View (Cards) - Tidak Ada Scroll Horizontal -->
                                    <div class="block sm:hidden space-y-4">
                                        @foreach($savedMembers as $member)
                                            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all">
                                                <div class="flex items-center space-x-3 mb-3 pb-3 border-b border-gray-100">
                                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 text-purple-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</p>
                                                        <p class="text-xs text-gray-500">Anggota Terdaftar</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="space-y-3">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-xs text-gray-500">{{ __('Nomor Identitas') }}</span>
                                                        <span class="text-sm font-mono font-medium text-gray-800">{{ $member->id_number }}</span>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-xs text-gray-500">{{ __('No. Telepon') }}</span>
                                                        <span class="text-sm font-medium text-gray-800">{{ $member->phone }}</span>
                                                    </div>
                                                </div>

                                                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                                                    <form method="POST" action="{{ route('profile.members.destroy', $member) }}" 
                                                          onsubmit="return confirm('Yakin ingin menghapus data anggota ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition-colors">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            {{ __('Hapus Data') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Desktop View (Table) -->
                                    <div class="hidden sm:block overflow-x-auto border border-gray-200 rounded-xl">
                                        <table class="w-full text-sm text-left text-gray-500">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                                <tr>
                                                    <th class="px-6 py-3 whitespace-nowrap">{{ __('Nama Lengkap') }}</th>
                                                    <th class="px-6 py-3 whitespace-nowrap">{{ __('Nomor Identitas') }}</th>
                                                    <th class="px-6 py-3 whitespace-nowrap">{{ __('No. Telepon') }}</th>
                                                    <th class="px-6 py-3 text-center whitespace-nowrap">{{ __('Aksi') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($savedMembers as $member)
                                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors last:border-0">
                                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 text-purple-600">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                                </div>
                                                                {{ $member->name }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-gray-600">
                                                            {{ $member->id_number }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                                            {{ $member->phone }}
                                                        </td>
                                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                                            <form method="POST" action="{{ route('profile.members.destroy', $member) }}" 
                                                                  onsubmit="return confirm('Yakin ingin menghapus data anggota ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium hover:bg-red-50 px-3 py-1 rounded-lg transition-colors">
                                                                    {{ __('Hapus') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-gray-600 font-medium">{{ __('Belum ada data anggota tersimpan') }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ __('Klik "Tambah Anggota" untuk menyimpan data') }}</p>
                                    </div>
                                @endif

                                <!-- Info Box -->
                                <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li> {{ __('Data anggota akan muncul saat booking untuk mempermudah pengisian') }}</li>
                                                    <li> {{ __('Maksimal 5 data anggota dapat disimpan') }}</li>
                                                    <li> {{ __('Nomor identitas harus unik untuk setiap anggota') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div x-show="activeTab === 'settings'" x-cloak>

                            <!-- Delete Account -->
                            <div class="card-modern border-2 border-red-100">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ __('Hapus Akun') }}</h2>
                                        <p class="text-gray-600 mb-4">
                                            {{ __('Setelah akun dihapus, semua data akan dihapus secara permanen. Harap unduh data penting sebelum melanjutkan.') }}
                                        </p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('delete')

                                    <div class="mb-4">
                                        <label for="delete_password" class="block text-sm font-semibold text-gray-700 mb-2"> {{ __('Konfirmasi Kata Sandi') }}</label>
                                        <input type="password" 
                                               id="delete_password" 
                                               name="password"
                                               class="input-modern"
                                               required
                                               placeholder="Masukkan kata sandi untuk konfirmasi">
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" 
                                                class="btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                                            {{ __('Hapus Akun Permanen') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <x-modern-footer />

        <!-- Croppie Modal -->
        <div x-show="showCropperModal" 
             x-cloak 
             class="cropper-modal"
             @click.self="closeCropper()">
            <div class="cropper-container-wrapper">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Crop Foto Profil</h3>
                    <button @click="closeCropper()" type="button" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Croppie Container -->
                <div class="croppie-preview-area">
                    <div id="croppieContainer"></div>
                </div>

                <!-- Rotate Controls -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <button type="button" @click="rotateImage(-90)" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Putar Kiri
                    </button>
                    <button type="button" @click="rotateImage(90)" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"></path>
                        </svg>
                        Putar Kanan
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" @click="closeCropper()" class="w-full py-2.5 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="button" @click="applyCrop()" class="w-full py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all transform hover:scale-[1.02]">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>