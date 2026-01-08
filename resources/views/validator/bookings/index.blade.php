@extends('layouts.validator')

@section('title', 'Validator Bookings')

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-40 h-40 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-10 rounded-full"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Welcome, {{ auth()->guard('validator')->user()->name }}!</h2>
                    <p class="text-green-100 text-lg">Ready to check-in hikers today</p>
                    <div class="mt-4 flex items-center space-x-4">
                        <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold">{{ now()->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold" id="current-time">{{ now()->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm p-6 rounded-2xl">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Bookings -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Bookings</p>
                        <p class="text-4xl font-bold text-gray-900 mt-1">{{ $bookings->count() }}</p>
                    </div>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: 100%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">All bookings in system</p>
            </div>
        </div>

        <!-- Pending Check-in -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pending</p>
                        <p class="text-4xl font-bold text-gray-900 mt-1">{{ $bookings->where('status', 'paid')->count() }}</p>
                    </div>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-full" style="width: {{ $bookings->count() > 0 ? ($bookings->where('status', 'paid')->count() / $bookings->count()) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Waiting for check-in</p>
            </div>
        </div>

        <!-- Checked In -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Checked In</p>
                        <p class="text-4xl font-bold text-gray-900 mt-1">{{ $bookings->where('status', 'checked_in')->count() }}</p>
                    </div>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-green-600 rounded-full" style="width: {{ $bookings->count() > 0 ? ($bookings->where('status', 'checked_in')->count() / $bookings->count()) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Successfully checked in</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('validator.bookings.scanner') }}" 
               class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl hover:shadow-lg transition-all duration-200 group">
                <div class="bg-blue-600 p-3 rounded-lg group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-gray-900">Scan QR Code</h4>
                    <p class="text-sm text-gray-600">Quick check-in with QR scanner</p>
                </div>
            </a>

            <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl">
                <div class="bg-green-600 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-gray-900">Today's Report</h4>
                    <p class="text-sm text-gray-600">{{ $bookings->where('status', 'checked_in')->count() }} hikers checked in today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 flex items-center">
                        Recent Bookings
                        <span class="ml-2 px-2 py-0.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Last 24h</span>
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600 mt-1">Showing bookings from the last 24 hours (max 10)</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                        {{ $bookings->count() }} Total
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Booking Code</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Mountain</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Trail</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Hikers</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-green-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <span class="font-mono text-sm font-bold text-gray-900">{{ $booking->booking_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-semibold text-gray-900">{{ $booking->mountain->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $booking->trailRoute->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-semibold text-gray-700">{{ $booking->member_count }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($booking->status === 'paid')
                                <span class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    Pending
                                </span>
                            @else
                                <span class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Checked In
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($booking->status === 'paid')
                                <form action="{{ route('validator.bookings.checkIn', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Confirm check-in for {{ $booking->booking_code }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-xs font-bold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Check In
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 text-xs font-medium rounded-lg">
                                    Completed
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-100 p-6 rounded-full mb-4">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-lg font-semibold mb-2">No bookings to check-in</p>
                                <p class="text-gray-400 text-sm">New bookings will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (visible only on mobile) -->
        <div class="md:hidden">
            @forelse($bookings as $booking)
            <div class="border-b border-gray-200 p-4 hover:bg-green-50 transition-colors duration-150">
                <!-- Booking Code & Status -->
                <div class="flex items-center justify-between mb-3">
                    <span class="font-mono text-sm font-bold text-gray-900">{{ $booking->booking_code }}</span>
                    @if($booking->status === 'paid')
                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pending
                        </span>
                    @else
                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                            Checked In
                        </span>
                    @endif
                </div>

                <!-- Customer Info -->
                <div class="mb-3">
                    <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                    <div class="text-xs text-gray-500 truncate">{{ $booking->user->email }}</div>
                </div>

                <!-- Mountain & Trail Info -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                    <div>
                        <span class="text-gray-500">Mountain:</span>
                        <div class="font-semibold text-gray-900 truncate">{{ $booking->mountain->name }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Trail:</span>
                        <div class="font-semibold text-gray-900 truncate">{{ $booking->trailRoute->name ?? '-' }}</div>
                    </div>
                </div>

                <!-- Date & Hikers Info -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                    <div>
                        <span class="text-gray-500">Date:</span>
                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffForHumans() }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Hikers:</span>
                        <div class="font-semibold text-gray-900">{{ $booking->member_count }} person(s)</div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-3">
                    @if($booking->status === 'paid')
                        <form action="{{ route('validator.bookings.checkIn', $booking) }}" method="POST" onsubmit="return confirm('Confirm check-in for {{ $booking->booking_code }}?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-sm font-bold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                Check In Now
                            </button>
                        </form>
                    @else
                        <div class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-500 text-sm font-medium rounded-lg">
                            Completed
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-gray-100 p-6 rounded-full mb-4">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg font-semibold mb-2">No bookings to check-in</p>
                    <p class="text-gray-400 text-sm">New bookings will appear here</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update time every second
    setInterval(() => {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}`;
    }, 1000);
</script>
@endpush
@endsection