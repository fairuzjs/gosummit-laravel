{{-- resources/views/invoices/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
            padding: 30px;
            background: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            text-align: right;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .from, .to, .invoice-meta {
            width: 30%;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #1e40af;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #f1f5f9;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 2px solid #cbd5e1;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .total-label {
            padding: 12px 10px;
            font-size: 14px;
        }
        .total-value {
            padding: 12px 10px;
            font-size: 16px;
            color: #1e40af;
        }
        .footer-note {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
            font-size: 11px;
            color: #64748b;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Fairuz Trip Adventure</div>
            <div class="invoice-title">INVOICE</div>
        </div>

        <!-- Invoice Info & Customer -->
        <div class="details">
            <div class="from">
                <div class="section-title">Dari</div>
                <p>
                    Fairuz Trip Adventure<br>
                    Jl. Sukakamu No. 123<br>
                    Kota Bandung, Indonesia<br>
                    Email: info@fairuztrip.com
                </p>
            </div>
            <div class="to">
                <div class="section-title">Kepada</div>
                <p>
                    {{ $booking->members->first()->full_name ?? 'N/A' }}<br>
                    {{ $booking->members->first()->identity_number ?? '–' }}<br>
                    Rombongan: {{ $booking->member_count }} orang
                </p>
            </div>
            <div class="invoice-meta">
                <div class="section-title">Detail Invoice</div>
                <p>
                    <strong>Kode Booking:</strong><br>
                    {{ $booking->booking_code }}<br><br>
                    <strong>Tanggal:</strong><br>
                    {{ $booking->updated_at->format('d F Y') }}
                </p>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Tiket Pendakian {{ $booking->mountain->name }}<br>
                        <small style="color: #64748b;">Jalur: {{ $booking->trailRoute ? $booking->trailRoute->name : 'Tidak tersedia' }}</small>
                    </td>
                    <td>{{ $booking->member_count }} orang</td>
                    <td class="text-right">Rp {{ number_format($booking->mountain->ticket_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <table>
            <tbody>
                <tr class="total-row">
                    <td colspan="3" class="total-label">TOTAL PEMBAYARAN</td>
                    <td class="total-value text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>Terima kasih telah mempercayakan perjalanan Anda kepada kami. Harap simpan invoice ini sebagai bukti pembayaran.</p>
            <p><em>Invoice ini berlaku sebagai bukti pembayaran resmi.</em></p>
        </div>
    </div>
</body>
</html>