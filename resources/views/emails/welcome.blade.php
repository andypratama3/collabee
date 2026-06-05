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
            <div class="greeting">Halo, {{ $user->name }}!</div>
            <p class="text">Selamat datang di <strong>Collabee</strong> — platform kolaborasi antara Brand dan KOL terkemuka di Indonesia.</p>
            <p class="text">Akun Anda telah berhasil dibuat. Silakan lengkapi profil Anda dan mulai menjelajahi campaign atau KOL terbaik.</p>
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="btn">Mulai Sekarang</a>
            </div>
            <p class="text" style="font-size: 13px; color: #6b7280;">Jika tombol di atas tidak berfungsi, salin tautan berikut: {{ config('app.url') }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Collabee. Semua hak dilindungi.</p>
            <p>Jl. Contoh No. 123, Jakarta, Indonesia</p>
        </div>
    </div>
</body>
</html>
