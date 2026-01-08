@extends('layouts.validator')

@section('title', 'QR Code Scanner')

@push('styles')
<style>
    #qr-reader {
        border: 4px solid #10b981;
        border-radius: 16px;
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    #qr-reader video {
        border-radius: 12px;
    }

    .success-animation {
        animation: successPulse 0.6s ease-in-out;
    }

    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .shake {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .scan-indicator {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Floating notification animation */
    .slide-in-right {
        animation: slideInRight 0.4s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .slide-out-right {
        animation: slideOutRight 0.3s ease-in forwards;
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(120%);
            opacity: 0;
        }
    }
</style>
@endpush

<!-- HTML5 QR Code Scanner Library -->
@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <div>
        <a href="{{ route('validator.bookings.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bookings
        </a>
    </div>
    
    <!-- Scanner Instructions Banner -->
    <div class="bg-gradient-to-r from-green-600 via-green-600 to-green-600 rounded-2xl shadow-xl p-6 text-white">
        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <h3 class="text-xl font-bold mb-2">How to Use QR Scanner</h3>
                <ul class="space-y-1 text-green-100">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Allow camera access when prompted
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Point camera at hiker's e-ticket QR code
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        System will automatically check-in when detected
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Successful Scans</p>
                    <p class="text-4xl font-bold text-green-600" id="success-count">0</p>
                    <p class="text-xs text-gray-500 mt-1">Total check-ins today</p>
                </div>
                <div class="bg-green-100 p-4 rounded-xl">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-500" id="success-bar" style="width: 0%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Failed Scans</p>
                    <p class="text-4xl font-bold text-red-600" id="error-count">0</p>
                    <p class="text-xs text-gray-500 mt-1">Invalid or rejected</p>
                </div>
                <div class="bg-red-100 p-4 rounded-xl">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-red-500 to-rose-500 rounded-full transition-all duration-500" id="error-bar" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Scanner Section -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div>
                        <h3 class="text-xl font-bold">Camera Scanner</h3>
                        <p class="text-green-100 text-sm">Point at QR code to scan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                    </span>
                    <span class="text-sm font-semibold" id="scanner-status">Ready to Scan</span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- QR Reader Container -->
            <div id="qr-reader"></div>
            
            <!-- Camera Selection -->
            <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200 mt-6">
                <label for="camera-select" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Select Camera
                </label>
                <select id="camera-select" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-gray-700 font-medium">
                    <option value="">Loading cameras...</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Alert Messages Container (Floating) -->
    <div id="alert-container" class="fixed top-20 right-4 z-50 space-y-2 max-w-sm w-full px-4 sm:px-0"></div>

    <!-- Recent Scans -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Recent Scan History
                <span class="ml-2 px-2 py-0.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Last 24h</span>
            </h3>
            <p class="text-sm text-gray-600 mt-1">Last 5 scanned bookings (auto-cleared after 24 hours)</p>
        </div>
        <div class="p-6">
            <div id="recent-scans" class="space-y-3">
                @forelse($recentScans as $scan)
                <div onclick="showBookingDetail({{ json_encode([
                    'booking_code' => $scan->booking_code,
                    'customer_name' => $scan->user->name,
                    'mountain' => $scan->mountain->name,
                    'trail' => $scan->trailRoute->name ?? 'Umum',
                    'check_in_date' => \Carbon\Carbon::parse($scan->check_in_date)->format('d M Y'),
                    'member_count' => $scan->member_count,
                    'total_price' => 'Rp ' . number_format($scan->total_price, 0, ',', '.'),
                    'status' => $scan->status,
                    'scanned_at' => $scan->updated_at->format('d M Y H:i:s')
                ]) }})" 
                     class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:shadow-md hover:border-green-300 transition-all cursor-pointer">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 border-green-200 text-xs font-bold rounded-full border-2">
                                Success
                            </span>
                        </div>
                        <div class="flex-1">
                            <p class="font-mono text-sm font-bold text-gray-900">{{ $scan->booking_code }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $scan->mountain->name ?? 'N/A' }} • {{ $scan->member_count }} hikers</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500 font-semibold">{{ $scan->updated_at->format('H:i:s') }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">No scans yet</p>
                    <p class="text-gray-400 text-sm mt-1">Scan history will appear here</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Booking Detail Modal -->
    <div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4" onclick="closeModal(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Booking Details</h3>
                    <button onclick="closeModal()" class="text-white hover:bg-white/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <!-- Booking Code (Full Width) -->
                <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                    <p class="text-xs text-gray-600 mb-1">Booking Code</p>
                    <p class="font-mono text-lg font-bold text-gray-900" id="modal-booking-code">-</p>
                </div>

                <!-- 2 Column Grid Layout -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Customer</p>
                                <p class="font-semibold text-gray-900 text-sm truncate" id="modal-customer-name">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Mountain</p>
                                <p class="font-semibold text-gray-900 text-sm truncate" id="modal-mountain">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Trail Route</p>
                                <p class="font-semibold text-gray-900 text-sm truncate" id="modal-trail">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Check-in Date</p>
                                <p class="font-semibold text-gray-900 text-sm" id="modal-check-in-date">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Members</p>
                                <p class="font-semibold text-gray-900 text-sm" id="modal-member-count">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Total Price</p>
                                <p class="font-semibold text-green-600 text-base" id="modal-total-price">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Scanned At</p>
                                <p class="font-semibold text-gray-900 text-xs" id="modal-scanned-at">-</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600">Status</p>
                                <p class="font-semibold text-green-600 text-sm">Checked In</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let html5QrCode;
    let successCount = 0;
    let errorCount = 0;
    let lastScannedCode = '';
    let lastScanTime = 0;
    const SCAN_COOLDOWN = 3000; // 3 seconds cooldown

    // Initialize Scanner
    function initScanner(cameraId) {
        html5QrCode = new Html5Qrcode("qr-reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        html5QrCode.start(
            cameraId,
            config,
            onScanSuccess,
            onScanError
        ).catch(err => {
            console.error("Error starting scanner:", err);
            showAlert('error', 'Failed to start camera. Please allow camera access.');
        });
    }

    // On Scan Success
    function onScanSuccess(decodedText, decodedResult) {
        const now = Date.now();
        
        // Prevent duplicate scans
        if (decodedText === lastScannedCode && (now - lastScanTime) < SCAN_COOLDOWN) {
            return;
        }
        
        lastScannedCode = decodedText;
        lastScanTime = now;
        
        // Update status
        updateScannerStatus('Processing...', 'text-yellow-600');
        
        // Play success sound
        playBeep();
        
        // Send to server
        checkInBooking(decodedText);
    }

    // On Scan Error (silent)
    function onScanError(errorMessage) {
        // Ignore scan errors
    }

    // Check-in Booking via AJAX
    function checkInBooking(bookingCode) {
        fetch(`{{ route('validator.bookings.scanCheckIn') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ booking_code: bookingCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successCount++;
                updateCounts();
                showAlert('success', data.message, data.booking);
                addRecentScan(bookingCode, 'success', data.booking);
            } else {
                errorCount++;
                updateCounts();
                showAlert('error', data.message);
                addRecentScan(bookingCode, 'error', null);
            }
            
            // Reset status
            setTimeout(() => {
                updateScannerStatus('Ready to Scan', 'text-white');
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            errorCount++;
            updateCounts();
            showAlert('error', 'Error processing check-in. Please try again.');
            updateScannerStatus('Ready to Scan', 'text-white');
        });
    }

    // Update Scanner Status
    function updateScannerStatus(text, colorClass) {
        const statusEl = document.getElementById('scanner-status');
        statusEl.textContent = text;
        statusEl.className = `text-sm font-semibold ${colorClass}`;
    }

    // Update Counts
    function updateCounts() {
        document.getElementById('success-count').textContent = successCount;
        document.getElementById('error-count').textContent = errorCount;
        
        const total = successCount + errorCount;
        if (total > 0) {
            const successPercent = (successCount / total) * 100;
            const errorPercent = (errorCount / total) * 100;
            document.getElementById('success-bar').style.width = successPercent + '%';
            document.getElementById('error-bar').style.width = errorPercent + '%';
        }
    }

    // Show Alert
    function showAlert(type, message, booking = null) {
        const alertContainer = document.getElementById('alert-container');
        const alertId = 'alert-' + Date.now();
        
        const bgColor = type === 'success' 
            ? 'bg-white' 
            : 'bg-white';
        const borderColor = type === 'success' ? 'border-green-500' : 'border-red-500';
        const textColor = type === 'success' ? 'text-gray-800' : 'text-gray-800';
        const iconBg = type === 'success' ? 'bg-green-100' : 'bg-red-100';
        const iconColor = type === 'success' ? 'text-green-600' : 'text-red-600';
        const icon = type === 'success' 
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
        
        let bookingInfo = '';
        if (booking) {
            bookingInfo = `
                <div class="mt-2 flex items-center gap-3 text-xs text-gray-600">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        ${booking.mountain}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        ${booking.member_count} hikers
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        ${booking.check_in_date}
                    </span>
                </div>
            `;
        }
        
        const alertHTML = `
            <div id="${alertId}" class="${bgColor} border-l-4 ${borderColor} rounded-lg shadow-lg slide-in-right backdrop-blur-sm">
                <div class="flex items-start gap-3 p-3">
                    <div class="${iconBg} rounded-full p-1.5 flex-shrink-0">
                        <svg class="w-4 h-4 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${icon}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm ${textColor} leading-tight">${message}</p>
                        ${bookingInfo}
                    </div>
                    <button onclick="dismissAlert('${alertId}')" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('afterbegin', alertHTML);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            dismissAlert(alertId);
        }, 5000);
    }

    // Dismiss Alert with animation
    function dismissAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.classList.remove('slide-in-right');
            alert.classList.add('slide-out-right');
            setTimeout(() => alert.remove(), 300);
        }
    }

    // Add Recent Scan (adds to top, keeps database scans)
    function addRecentScan(code, status, booking) {
        const recentScans = document.getElementById('recent-scans');
        
        // Remove "no scans" message if exists
        const emptyState = recentScans.querySelector('.text-center');
        if (emptyState) {
            emptyState.remove();
        }
        
        const statusColor = status === 'success' 
            ? 'bg-green-100 text-green-800 border-green-200' 
            : 'bg-red-100 text-red-800 border-red-200';
        const statusIcon = status === 'success'
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
        const statusText = status === 'success' ? 'Success' : 'Failed';
        const time = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        
        const scanHTML = `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:shadow-md transition-all new-scan">
                <div class="flex items-center space-x-4 flex-1">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-3 py-1.5 ${statusColor} text-xs font-bold rounded-full border-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${statusIcon}
                            </svg>
                            ${statusText}
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="font-mono text-sm font-bold text-gray-900">${code}</p>
                        ${booking ? `<p class="text-xs text-gray-600 mt-1">${booking.mountain} • ${booking.member_count} hikers</p>` : ''}
                    </div>
                </div>
                <span class="text-xs text-gray-500 font-semibold ml-4">${time}</span>
            </div>
        `;
        
        recentScans.insertAdjacentHTML('afterbegin', scanHTML);
        
        // Keep only last 5 scans (remove oldest if more than 5)
        while (recentScans.children.length > 5) {
            recentScans.removeChild(recentScans.lastChild);
        }
    }

    // Play Beep Sound
    function playBeep() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.1);
    }

    // Get Cameras and Initialize
    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            const cameraSelect = document.getElementById('camera-select');
            cameraSelect.innerHTML = '';
            
            cameras.forEach((camera, index) => {
                const option = document.createElement('option');
                option.value = camera.id;
                option.text = camera.label || `Camera ${index + 1}`;
                cameraSelect.appendChild(option);
            });
            
            // Start with back camera (usually index 1 on mobile)
            const defaultCamera = cameras.length > 1 ? cameras[1].id : cameras[0].id;
            initScanner(defaultCamera);
            
            // Change camera on select
            cameraSelect.addEventListener('change', (e) => {
                html5QrCode.stop().then(() => {
                    initScanner(e.target.value);
                });
            });
        } else {
            showAlert('error', 'No cameras detected on this device.');
        }
    }).catch(err => {
        console.error("Error getting cameras:", err);
        showAlert('error', 'Failed to access camera. Please check browser permissions.');
    });

    // Show Booking Detail Modal
    function showBookingDetail(booking) {
        document.getElementById('modal-booking-code').textContent = booking.booking_code;
        document.getElementById('modal-customer-name').textContent = booking.customer_name;
        document.getElementById('modal-mountain').textContent = booking.mountain;
        document.getElementById('modal-trail').textContent = booking.trail;
        document.getElementById('modal-check-in-date').textContent = booking.check_in_date;
        document.getElementById('modal-member-count').textContent = booking.member_count + ' hikers';
        document.getElementById('modal-total-price').textContent = booking.total_price;
        document.getElementById('modal-scanned-at').textContent = booking.scanned_at;
        
        const modal = document.getElementById('booking-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    }

    // Close Modal
    function closeModal(event) {
        // Only close if clicking on overlay or close button, not on modal content
        if (!event || event.target.id === 'booking-modal' || event.type === 'click') {
            const modal = document.getElementById('booking-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scroll
        }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (html5QrCode) {
            html5QrCode.stop();
        }
    });
</script>
@endpush