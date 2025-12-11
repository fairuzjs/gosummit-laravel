<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket Pendakian</title>
    <style>
        @page {
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #1a202c;
            background: #f8f9fa;
            padding: 40px 20px;
        }
        
        .ticket-container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border: 3px solid #667eea;
            position: relative;
        }
        
        /* Header Section */
        .ticket-header {
            background: #667eea;
            padding: 40px 30px 35px;
            text-align: center;
            color: white;
        }
        
        .logo-text {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        
        .ticket-title {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }
        
        .ticket-subtitle {
            font-size: 13px;
            opacity: 0.95;
            font-weight: 500;
        }
        
        /* Status Badge */
        .status-section {
            background: #10b981;
            padding: 12px;
            text-align: center;
        }
        
        .status-text {
            color: white;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        
        /* Body Content */
        .ticket-body {
            padding: 35px 35px 30px;
        }
        
        /* Booking Code Box */
        .booking-box {
            background: #f8f9fa;
            border: 2px solid #667eea;
            border-left: 6px solid #667eea;
            padding: 20px 25px;
            margin-bottom: 35px;
        }
        
        .booking-label {
            font-size: 10px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }
        
        .booking-code {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
        }
        
        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        
        .details-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .details-table tr:last-child {
            border-bottom: 2px solid #e5e7eb;
        }
        
        .details-table td {
            padding: 15px 0;
            vertical-align: top;
        }
        
        .detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            width: 42%;
            padding-right: 20px;
        }
        
        .detail-value {
            font-size: 14px;
            color: #1a202c;
            font-weight: 600;
        }
        
        /* QR Section */
        .qr-section {
            text-align: center;
            padding: 30px 20px;
            background: #f8f9fa;
            border: 2px dashed #cbd5e0;
            margin-bottom: 30px;
        }
        
        .qr-box {
            display: inline-block;
            padding: 15px;
            background: white;
            border: 2px solid #e5e7eb;
        }
        
        .qr-box img {
            display: block;
            width: 160px;
            height: 160px;
        }
        
        .qr-instruction {
            margin-top: 18px;
            font-size: 12px;
            color: #4b5563;
            font-weight: 600;
        }
        
        .qr-icon {
            display: inline-block;
            width: 5px;
            height: 5px;
            background: #667eea;
            border-radius: 50%;
            margin: 0 6px;
            vertical-align: middle;
        }
        
        /* Important Notes */
        .notes-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        
        .notes-title {
            font-size: 11px;
            font-weight: bold;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .notes-text {
            font-size: 11px;
            color: #78350f;
            line-height: 1.6;
        }
        
        /* Footer */
        .ticket-footer {
            background: #f8f9fa;
            padding: 25px 35px;
            text-align: center;
            border-top: 2px dashed #cbd5e0;
        }
        
        .footer-text {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 8px;
        }
        
        .footer-highlight {
            color: #667eea;
            font-weight: bold;
        }
        
        .footer-company {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Decorative Corner */
        .corner-decoration {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Decorative Corners -->
        <div class="corner-decoration corner-tl"></div>
        <div class="corner-decoration corner-tr"></div>
        <div class="corner-decoration corner-bl"></div>
        <div class="corner-decoration corner-br"></div>
        
        <!-- Header -->
        <div class="ticket-header">
            <div class="logo-text">BOOKING SYSTEM</div>
            <div class="ticket-title">E-TICKET</div>
            <div class="ticket-subtitle">Fairuz Trip Adventure</div>
        </div>
        
        <!-- Status -->
        <div class="status-section">
            <div class="status-text">PEMBAYARAN LUNAS</div>
        </div>
        
        <!-- Body -->
        <div class="ticket-body">
            <!-- Booking Code -->
            <div class="booking-box">
                <div class="booking-label">Kode Booking</div>
                <div class="booking-code">{{ $booking->booking_code }}</div>
            </div>
            
            <!-- Details -->
            <table class="details-table">
                <tr>
                    <td class="detail-label">Nama Ketua Rombongan</td>
                    <td class="detail-value">{{ $booking->members->first()->full_name ?? 'N/A' }}</td> <!-- ✅ SUDAH DIUBAH -->
                </tr>
                <tr>
                    <td class="detail-label">Destinasi Gunung</td>
                    <td class="detail-value">{{ $booking->mountain->name }}</td>
                </tr>
                <tr>
    <td class="detail-label">Jalur Pendakian</td>
    <td class="detail-value">{{ $booking->trailRoute ? $booking->trailRoute->name : 'Tidak tersedia' }}</td>
</tr>
                <tr>
                    <td class="detail-label">Tanggal Pendakian</td>
                    <td class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Jumlah Rombongan</td>
                    <td class="detail-value">{{ $booking->member_count }} Orang</td>
                </tr>
            </table>
            
            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-box">
                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(160)->margin(0)->generate($booking->booking_code)) !!}" alt="QR Code">
                </div>
                <div class="qr-instruction">
                    <span class="qr-icon"></span>
                    Tunjukkan QR Code ini di Pos Pendakian
                    <span class="qr-icon"></span>
                </div>
            </div>
    </div>
</body>
</html>