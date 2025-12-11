{{-- resources/views/admin/notifications/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Notifications')
@section('header-title', 'Manage Notifications')

@section('header-buttons')
    <a href="{{ route('admin.analytics.index') }}"
       class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
        <span class="hidden sm:inline">Back to Dashboard</span>
        <span class="sm:hidden">Back</span>
    </a>
@endsection

@section('content')
<!-- Form Tambah Notifikasi -->
<div class="p-4 sm:p-6 lg:p-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Add New Notification</h3>
    <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input 
                type="text" 
                name="title" 
                value="{{ old('title') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                placeholder="Enter title"
                required
            >
        </div>

        <div>
            <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
            <textarea 
                name="message" 
                rows="4"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
                placeholder="Enter a description of the notification">{{ old('message') }}</textarea>
        </div>

        <div>
            <label for="type" class="block text-gray-700 font-semibold mb-2">Type</label>
            <select 
                name="type"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
            >
                <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Info (Blue)</option>
                <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning (Yellow)</option>
                <option value="promo" {{ old('type') == 'promo' ? 'selected' : '' }}>Promo (Green)</option>
            </select>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                Save Notification
            </button>
        </div>
    </form>
</div>

<!-- Daftar Notifikasi -->
<div class="p-4 sm:p-6 lg:p-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl mt-6">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Existing Notifications</h3>

    {{-- Desktop Table View --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Message</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($notifications as $notification)
                    <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-600 rounded-full mr-3"></div>
                                <span class="text-sm font-bold text-gray-900">{{ $notification->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-md">
                            <div class="line-clamp-2">{{ $notification->message }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full shadow-sm
                                @if($notification->type === 'info') bg-gradient-to-r from-blue-400 to-blue-600 text-white
                                @elseif($notification->type === 'warning') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white
                                @else bg-gradient-to-r from-green-400 to-green-600 text-white @endif">
                                {{ ucfirst($notification->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200" onclick="return confirm('Are you sure you want to delete this notification?')">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium mb-2">No notifications found.</p>
                                <p class="text-gray-400 text-sm">Add one using the form above!</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="md:hidden space-y-4">
        @forelse ($notifications as $notification)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 px-4 py-3 border-b border-gray-200">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="w-2 h-2 bg-purple-600 rounded-full mr-2 flex-shrink-0"></div>
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $notification->title }}</h4>
                        </div>
                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full shadow-sm flex-shrink-0
                            @if($notification->type === 'info') bg-gradient-to-r from-blue-400 to-blue-600 text-white
                            @elseif($notification->type === 'warning') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white
                            @else bg-gradient-to-r from-green-400 to-green-600 text-white @endif">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="px-4 py-3">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $notification->message }}</p>
                </div>

                {{-- Card Footer --}}
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200" 
                                onclick="return confirm('Are you sure you want to delete this notification?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Notification
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium mb-2">No notifications found.</p>
                    <p class="text-gray-400 text-sm">Add one using the form above!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection