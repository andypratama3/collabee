<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 0; background-color: #f9fafb; }
        .container { max-width: 560px; margin: 0 auto; padding: 24px; }
        .header { text-align: center; padding: 32px 0; }
        .logo { font-size: 28px; font-weight: 700; color: #4f46e5; }
        .body-card { background-color: #ffffff; border-radius: 12px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .greeting { font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 16px; }
        .text { font-size: 15px; color: #374151; line-height: 1.6; margin-bottom: 12px; }
        .info-box { background-color: #eef2ff; border-radius: 8px; padding: 16px; margin: 16px 0; }
        .info-label { font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { font-size: 15px; color: #111827; font-weight: 500; margin-top: 2px; }
        .footer { text-align: center; padding: 24px 0; font-size: 13px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Collabee</div>
        </div>
        <div class="body-card">
            <div class="greeting">Halo!</div>
            <p class="text">Pembayaran Anda sebesar <strong>Rp. {{ number_format($payment->total_amount, 0, ',', '.') }}</strong> telah berhasil dikonfirmasi.</p>
            <div class="info-box">
                <div style="margin-bottom: 12px;">
                    <div class="info-label">Invoice</div>
                    <div class="info-value">{{ $payment->invoice_number }}</div>
                </div>
                <div style="margin-bottom: 12px;">
                    <div class="info-label">Jumlah</div>
                    <div class="info-value">Rp. {{ number_format($payment->amount, 0, ',', '.') }}</div>
                </div>
                <div style="margin-bottom: 12px;">
                    <div class="info-label">Biaya Platform</div>
                    <div class="info-value">Rp. {{ number_format($payment->platform_fee, 0, ',', '.') }}</div>
                </div>
                <div>
                    <div class="info-label">Total Dibayar</div>
                    <div class="info-value">Rp. {{ number_format($payment->total_amount, 0, ',', '.') }}</div>
                </div>
            </div>
            <p class="text">Terima kasih telah menggunakan Collabee. Kemitraan Anda sekarang dapat berjalan.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Collabee. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
