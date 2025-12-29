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
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <h3 class="text-xl font-bold mb-2">How to Use QR Scanner</h3>
                <ul class="space-y-1 text-blue-100">
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
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
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
            <div id="qr-reader" class="mb-6"></div>
            
            <!-- Camera Selection -->
            <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
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

    <!-- Alert Messages Container -->
    <div id="alert-container" class="space-y-3"></div>

    <!-- Recent Scans -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Recent Scan History
            </h3>
            <p class="text-sm text-gray-600 mt-1">Last 5 scanned bookings</p>
        </div>
        <div class="p-6">
            <div id="recent-scans" class="space-y-3">
                <div class="text-center py-8">
                    <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">No scans yet</p>
                    <p class="text-gray-400 text-sm mt-1">Scan history will appear here</p>
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
            showAlert('error', '❌ Failed to start camera. Please allow camera access.');
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
            showAlert('error', '❌ Error processing check-in. Please try again.');
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
            ? 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-400' 
            : 'bg-gradient-to-r from-red-50 to-rose-50 border-red-400';
        const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
        const iconColor = type === 'success' ? 'text-green-600' : 'text-red-600';
        const icon = type === 'success' 
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
        
        let bookingInfo = '';
        if (booking) {
            bookingInfo = `
                <div class="mt-3 grid grid-cols-2 gap-2 text-sm ${textColor}">
                    <div class="bg-white/50 rounded-lg p-2">
                        <p class="text-xs text-gray-600 font-semibold">Mountain</p>
                        <p class="font-bold">${booking.mountain}</p>
                    </div>
                    <div class="bg-white/50 rounded-lg p-2">
                        <p class="text-xs text-gray-600 font-semibold">Hikers</p>
                        <p class="font-bold">${booking.member_count} people</p>
                    </div>
                    <div class="bg-white/50 rounded-lg p-2 col-span-2">
                        <p class="text-xs text-gray-600 font-semibold">Check-in Date</p>
                        <p class="font-bold">${booking.check_in_date}</p>
                    </div>
                </div>
            `;
        }
        
        const alertHTML = `
            <div id="${alertId}" class="border-l-4 ${bgColor} p-5 rounded-xl shadow-lg ${type === 'success' ? 'success-animation' : 'shake'}">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-7 h-7 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${icon}
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="font-bold text-lg ${textColor}">${message}</p>
                        ${bookingInfo}
                    </div>
                    <button onclick="document.getElementById('${alertId}').remove()" class="ml-4 ${textColor} hover:opacity-70 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('afterbegin', alertHTML);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    }

    // Add Recent Scan
    function addRecentScan(code, status, booking) {
        const recentScans = document.getElementById('recent-scans');
        
        // Remove "no scans" message
        if (recentScans.querySelector('.text-center')) {
            recentScans.innerHTML = '';
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
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:shadow-md transition-all">
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
        
        // Keep only last 5 scans
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
            showAlert('error', '❌ No cameras detected on this device.');
        }
    }).catch(err => {
        console.error("Error getting cameras:", err);
        showAlert('error', '❌ Failed to access camera. Please check browser permissions.');
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (html5QrCode) {
            html5QrCode.stop();
        }
    });
</script>
@endpush
