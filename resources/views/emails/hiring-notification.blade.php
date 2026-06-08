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
        .btn { display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; margin: 16px 0; }
        .footer { text-align: center; padding: 24px 0; font-size: 13px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Collabee</div>
        </div>
        <div class="body-card">
            <div class="greeting">Halo, {{ $hiring->kolProfile?->display_name ?? 'KOL' }}!</div>
            <p class="text">Anda mendapatkan tawaran kerja sama dari <strong>{{ $hiring->brandProfile?->brand_name ?? 'Brand' }}</strong>!</p>
            <div class="info-box">
                <div style="margin-bottom: 12px;">
                    <div class="info-label">Campaign</div>
                    <div class="info-value">{{ $hiring->campaign?->title ?? 'N/A' }}</div>
                </div>
                <div style="margin-bottom: 12px;">
                    <div class="info-label">Budget yang Ditawarkan</div>
                    <div class="info-value">Rp. {{ number_format($hiring->proposed_budget, 0, ',', '.') }}</div>
                </div>
                @if($hiring->message)
                <div>
                    <div class="info-label">Pesan</div>
                    <div class="info-value">{{ $hiring->message }}</div>
                </div>
                @endif
            </div>
            <p class="text">Silakan masuk ke akun Collabee Anda untuk menerima atau menolak tawaran ini.</p>
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/kol/hiring" class="btn">Lihat Tawaran</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Collabee. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
