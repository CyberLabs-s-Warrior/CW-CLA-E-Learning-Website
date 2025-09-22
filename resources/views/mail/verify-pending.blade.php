@php
  $appName     = config('app.name', 'Learnify');
  $supportMail = config('mail.from.address');
  $primary     = '#0d6efd';  // warna utama (selaras Bootstrap)
  $link        = $url ?? '#';
  $userName    = $userName ?? null; // kirim dari Mailable bila tersedia
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Verifikasi Email - {{ $appName }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Preheader (teks singkat yang muncul di preview email) -->
  <style>.preheader{display:none!important;visibility:hidden;opacity:0;color:transparent;height:0;width:0;overflow:hidden;mso-hide:all}</style>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;">
  <div class="preheader">
    Verifikasi email Anda untuk menyelesaikan pendaftaran {{ $appName }}.
  </div>

  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f7fb;">
    <tr>
      <td align="center" style="padding:24px;">
        <!-- Card -->
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;background:#ffffff;border-radius:12px;border:1px solid #e6eaf0;">
          <!-- Header -->
          <tr>
            <td align="center" style="padding:28px 28px 0 28px;">
              {{-- Jika punya logo absolut (https://...), kirim via $logoUrl dan tampilkan di sini --}}
              @isset($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $appName }}" width="56" height="56" style="display:block;border:0;border-radius:12px;">
              @endisset
              <div style="font:600 14px system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#64748b;margin-top:12px;letter-spacing:.3px;text-transform:uppercase;">
                {{ $appName }}
              </div>
            </td>
          </tr>

          <!-- Title + message -->
          <tr>
            <td style="padding:24px 28px 0 28px;text-align:center;">
              <h1 style="margin:0 0 8px;font:800 22px/1.3 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#0f172a;">
                Verifikasi Email Anda
              </h1>
              <p style="margin:0;font:400 14px/1.7 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#334155;">
                @if($userName)
                  Halo {{ $userName }},
                @else
                  Halo,
                @endif
                <br>Terima kasih telah mendaftar. Klik tombol di bawah ini untuk menyelesaikan pendaftaran Anda.
              </p>
            </td>
          </tr>

          <!-- CTA Button -->
          <tr>
            <td align="center" style="padding:20px 28px 0 28px;">
              <a href="{{ $link }}"
                 style="display:inline-block;background:{{ $primary }};color:#ffffff;text-decoration:none;
                        font:600 14px/1 system-ui,-apple-system,Segoe UI,Arial,sans-serif;
                        padding:14px 22px;border-radius:10px;border:1px solid {{ $primary }};">
                Verifikasi Email
              </a>
            </td>
          </tr>

          <!-- Backup link -->
          <tr>
            <td style="padding:20px 28px 0 28px;">
              <p style="margin:0;font:400 12px/1.7 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#475569;">
                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke bilah alamat browser Anda:
              </p>
              <p style="word-break:break-all;margin:8px 0 0;">
                <a href="{{ $link }}" style="color:{{ $primary }};text-decoration:underline;font:500 12px/1.6 system-ui,-apple-system,Segoe UI,Arial,sans-serif;">
                  {{ $link }}
                </a>
              </p>
            </td>
          </tr>

          <!-- Info masa berlaku -->
          <tr>
            <td style="padding:16px 28px 0 28px;">
              <p style="margin:0;font:400 12px/1.7 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#64748b;">
                @isset($expiresAt)
                  Tautan ini berlaku hingga <strong>{{ $expiresAt->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</strong>.
                @else
                  Tautan ini berlaku selama <strong>24 jam</strong>.
                @endisset
              </p>
            </td>
          </tr>

          <!-- Divider -->
          <tr>
            <td style="padding:24px 28px 0 28px;">
              <hr style="border:none;border-top:1px solid #e6eaf0;margin:0;">
            </td>
          </tr>

          <!-- Help text -->
          <tr>
            <td style="padding:16px 28px 0 28px;">
              <p style="margin:0;font:400 12px/1.7 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#64748b;">
                Tidak merasa mendaftar di {{ $appName }}? Abaikan email ini. Bila butuh bantuan, hubungi kami di
                @if($supportMail)
                  <a href="mailto:{{ $supportMail }}" style="color:{{ $primary }};text-decoration:underline;">{{ $supportMail }}</a>.
                @else
                  email dukungan kami.
                @endif
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="padding:28px;">
              <p style="margin:0;font:400 11px/1.7 system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:#94a3b8;">
                © {{ now()->year }} {{ $appName }}. Semua hak dilindungi.
              </p>
            </td>
          </tr>
        </table>
        <!-- /Card -->
      </td>
    </tr>
  </table>
</body>
</html>
