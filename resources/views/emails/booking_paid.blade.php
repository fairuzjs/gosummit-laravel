<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .header {
            background: linear-gradient(135deg, #7e22ce, #2563eb);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: 700;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #4b5563;
            font-size: 20px;
            margin-top: 0;
        }
        .content p {
            margin: 10px 0;
        }
        .details {
            background-color: #f3f4f6;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .details li {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .details li:last-child {
            border-bottom: none;
        }
        .details strong {
            color: #4b5563;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(to right, #7e22ce, #2563eb);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .footer {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Pembayaran Berhasil!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Halo {{ $booking->members->first()->full_name ?? 'Pendaki' }},</h2>
            <p>Terima kasih telah melakukan pembayaran untuk pesanan pendakian Anda. Pembayaran Anda telah <strong>berhasil diterima</strong>.</p>

            <div class="divider"></div>

            <!-- Booking Details -->
            <h3 style="color: #4b5563;">Detail Pesanan Anda</h3>
            <div class="details">
                <ul>
                    <li><strong>Kode Booking:</strong> {{ $booking->booking_code }}</li>
                    <li><strong>Gunung Tujuan:</strong> {{ $booking->mountain->name }}</li>
                    <li><strong>Jalur Pendakian:</strong> {{ $booking->trailRoute->name ?? 'Umum' }}</li> {{-- ✅ Menambahkan Jalur --}}
                    <li><strong>Tanggal Naik:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</li>
                    <li><strong>Jumlah Rombongan:</strong> {{ $booking->member_count }} orang</li>
                    <li><strong>Total Pembayaran:</strong> <span style="color: #10b981; font-weight: bold;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></li>
                </ul>
            </div>

            <p>
                <strong>E-Ticket Anda</strong> yang berisi <strong>QR Code unik</strong> telah kami lampirkan dalam email ini dalam format <strong>PDF</strong>.
                Silakan tunjukkan e-ticket tersebut kepada petugas di pos pendakian.
            </p>

            <div class="divider"></div>

            <p style="font-style: italic; color: #6b7280;">
                Pastikan Anda membawa identitas asli dan e-ticket saat pendakian.
            </p>

            <a href="{{ route('bookings.ticket.download', $booking) }}" class="cta-button" target="_blank">
                Unduh E-Ticket Sekarang
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah mempercayakan perjalanan Anda kepada <strong>GoSummit</strong>.</p>
            <p style="margin-top: 10px;">
                <a href="{{ route('home') }}">Kunjungi Website Kami</a> | 
                <a href="mailto:support@tiketgunung.test">Hubungi Support</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                &copy; {{ date('Y') }} TiketGunung. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>