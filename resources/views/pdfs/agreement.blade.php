<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Perjanjian Kerjasama {{ $agreement->agreement_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; line-height: 1.6; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; }
        .header h1 { font-size: 18px; color: #4f46e5; margin: 0 0 5px; }
        .header p { margin: 2px 0; font-size: 11px; color: #666; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 14px; color: #4f46e5; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; }
        .info-grid { width: 100%; margin-bottom: 15px; }
        .info-grid td { padding: 4px 8px; vertical-align: top; }
        .info-grid .label { font-weight: bold; width: 150px; color: #555; }
        .terms { white-space: pre-line; }
        .signature-section { margin-top: 40px; }
        .signature-box { width: 45%; display: inline-block; vertical-align: top; }
        .signature-box h3 { font-size: 13px; margin-bottom: 5px; }
        .signature-line { border-top: 1px solid #333; width: 70%; margin-top: 40px; padding-top: 5px; font-size: 11px; }
        .footer { margin-top: 40px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 10px; color: #999; text-align: center; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 3px; font-size: 11px; font-weight: bold; }
        .status-signed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERJANJIAN KERJASAMA</h1>
        <p>Nomor Perjanjian: {{ $agreement->agreement_number }}</p>
        <p>Status: <span class="status-badge status-{{ $agreement->status === 'signed' ? 'signed' : 'pending' }}">{{ $agreement->status === 'signed' ? 'Ditandatangani' : 'Menunggu' }}</span></p>
        <p>Tanggal: {{ $agreement->created_at->format('d F Y') }}</p>
    </div>

    <div class="section">
        <h2>Informasi Para Pihak</h2>
        <table class="info-grid">
            <tr><td class="label">Brand:</td><td>{{ $agreement->hiring->brandProfile->brand_name }} ({{ $agreement->hiring->brandProfile->user->name }})</td></tr>
            <tr><td class="label">KOL/Influencer:</td><td>{{ $agreement->hiring->kolProfile->display_name }}</td></tr>
            <tr><td class="label">Kampanye:</td><td>{{ $agreement->hiring->campaign->title }}</td></tr>
            <tr><td class="label">Platform:</td><td>{{ implode(', ', $agreement->hiring->campaign->platforms ?? []) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Ketentuan Keuangan</h2>
        <table class="info-grid">
            <tr><td class="label">Jumlah Total:</td><td>Rp. {{ number_format($agreement->total_amount, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Biaya Platform:</td><td>{{ $agreement->platform_fee_percent }}%</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Syarat & Ketentuan</h2>
        <div class="terms">{{ $agreement->terms }}</div>
    </div>

    <div class="signature-section">
        <h2>Tanda Tangan Digital</h2>
        <div class="signature-box">
            <h3>Brand: {{ $agreement->hiring->brandProfile->brand_name }}</h3>
            @if($agreement->brand_signed_at)
                <div class="signature-line">
                    Ditandatangani: {{ $agreement->brand_signed_at->format('d F Y H:i') }}<br>
                    IP: {{ $agreement->brand_signed_ip }}
                </div>
            @else
                <p style="color: #ca8a04; font-style: italic;">Menunggu tanda tangan Brand</p>
            @endif
        </div>
        <div class="signature-box" style="float: right;">
            <h3>KOL: {{ $agreement->hiring->kolProfile->display_name }}</h3>
            @if($agreement->kol_signed_at)
                <div class="signature-line">
                    Ditandatangani: {{ $agreement->kol_signed_at->format('d F Y H:i') }}<br>
                    IP: {{ $agreement->kol_signed_ip }}
                </div>
            @else
                <p style="color: #ca8a04; font-style: italic;">Menunggu tanda tangan KOL</p>
            @endif
        </div>
    </div>

    <div class="footer">
        <p>Perjanjian ini dibuat dan ditandatangani secara elektronik melalui Platform Collabee.</p>
        <p>Nomor Perjanjian: {{ $agreement->agreement_number }} | Dibuat: {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
