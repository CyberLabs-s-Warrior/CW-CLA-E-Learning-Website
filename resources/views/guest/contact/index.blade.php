{{-- resources/views/guest/contact.blade.php --}}
@extends('layouts.guest')

@push('styles')
  <link rel="stylesheet" href="{{ asset('guest/contact.css') }}">
@endpush

@section('content')
<section class="contact-section">
  <h1 class="contact-title">Kontak Kami</h1>

  <div class="contact-grid">
    {{-- LEFT: Cards --}}
    <div class="contact-left">
      <div class="cards">

        {{-- Email --}}
        <div class="card">
          <div class="card__body">
            <div class="card__icon" aria-hidden="true">
              {{-- mail icon (inline SVG) --}}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="#0d6efd" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5L4 8V6l8 5 8-5v2Z"/>
              </svg>
            </div>
            <div class="card__text">
              <div class="card__label">Email</div>
              @if(!empty($contact?->email))
                <div class="card__value">
                  <a href="mailto:{{ $contact->email }}" class="contact-link">{{ $contact->email }}</a>
                </div>
              @else
                <div class="card__value card__value-muted">-</div>
              @endif
            </div>

            @if(!empty($contact?->email))
              <div class="card__actions">
                <a class="btn-chip" href="mailto:{{ $contact->email }}">
                  {{-- send icon --}}
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#0f172a" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 2 11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="m22 2-7 20-4-9-9-4 20-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="none"/>
                  </svg>
                  Kirim Email
                </a>
              </div>
            @endif
          </div>
        </div>

        {{-- Telepon --}}
        @php
          $tel     = $contact->telepon ?? null;
          $telHref = $tel ? preg_replace('/[^0-9+]/','',$tel) : null;
        @endphp
        <div class="card">
          <div class="card__body">
            <div class="card__icon" aria-hidden="true">
              {{-- phone icon --}}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="#0d6efd" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.73 19.73 0 0 1-8.59-3.07 19.5 19.5 0 0 1-6-6A19.73 19.73 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.12.9.32 1.77.59 2.61a2 2 0 0 1-.45 2.11L8 9a16 16 0 0 0 6 6l.56-.14a2 2 0 0 1 2.11.45 13 13 0 0 0 2.61.59A2 2 0 0 1 22 16.92Z"/>
              </svg>
            </div>
            <div class="card__text">
              <div class="card__label">Telepon</div>
              @if($tel)
                <div class="card__value">
                  <a href="tel:{{ $telHref }}" class="contact-link">{{ $tel }}</a>
                </div>
              @else
                <div class="card__value card__value-muted">-</div>
              @endif
            </div>

            @if($tel && $telHref)
              <div class="card__actions">
                <a class="btn-chip" href="tel:{{ $telHref }}">
                  {{-- phone action icon --}}
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#0f172a" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.73 19.73 0 0 1-8.59-3.07 19.5 19.5 0 0 1-6-6A19.73 19.73 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3" stroke="currentColor" stroke-width="2" fill="none"/>
                  </svg>
                  Panggil
                </a>
              </div>
            @endif
          </div>
        </div>

        {{-- Alamat --}}
        @php
          $gmapsClick = null;
          if (!empty($contact?->alamat)) {
            $gmapsClick = 'https://www.google.com/maps/search/?api=1&query='.urlencode($contact->alamat);
          } elseif (!empty($contact?->latitude) && !empty($contact?->longitude)) {
            $gmapsClick = 'https://www.google.com/maps?q='.$contact->latitude.','.$contact->longitude;
          }
        @endphp
        <div class="card" style="grid-column: 1 / -1;">
          <div class="card__body">
            <div class="card__icon" aria-hidden="true">
              {{-- pin icon --}}
              <svg width="20" height="20" viewBox="0 0 24 24" fill="#0d6efd" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22s8-4.5 8-12a8 8 0 1 0-16 0c0 7.5 8 12 8 12Z"/>
                <circle cx="12" cy="10" r="3" fill="#fff"/>
              </svg>
            </div>
            <div class="card__text">
              <div class="card__label">Alamat</div>
              <div class="card__value">
                <span class="contact-address">{{ $contact->alamat ?? '-' }}</span>
              </div>
            </div>

            @if($gmapsClick)
              <div class="card__actions">
                <a class="btn-chip" href="{{ $gmapsClick }}" target="_blank" rel="noopener">
                  {{-- map icon --}}
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#0f172a" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18 3 21V6l6-3 6 3 6-3v15l-6 3-6-3Z" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M9 18V3m6 3v15" stroke="currentColor" stroke-width="2" />
                  </svg>
                  Buka di Google Maps
                </a>
              </div>
            @endif
          </div>
        </div>

        {{-- Sosial Media --}}
        @php
          $fb = trim($contact->social_facebook ?? '');
          $ig = trim($contact->social_instagram ?? '');
          $tt = trim($contact->social_tiktok ?? '');
          $xx = trim($contact->social_x ?? '');
          $hasSocial = $fb || $ig || $tt || $xx;
        @endphp
        <div class="card" style="grid-column: 1 / -1;">
          <div class="card__body">
            <div class="card__icon" aria-hidden="true">
              <i class="fas fa-share-alt" style="color:#0d6efd"></i>
            </div>
            <div class="card__text">
              <div class="card__label">Sosial Media</div>
              @if(!$hasSocial)
                <div class="card__value card__value-muted">-</div>
              @else
                <div class="d-flex flex-wrap gap-2">
                  @if($fb)<a class="btn-chip" href="{{ $fb }}" target="_blank" rel="noopener"><i class="fab fa-facebook me-1"></i>Facebook</a>@endif
                  @if($ig)<a class="btn-chip" href="{{ $ig }}" target="_blank" rel="noopener"><i class="fab fa-instagram me-1"></i>Instagram</a>@endif
                  @if($tt)<a class="btn-chip" href="{{ $tt }}" target="_blank" rel="noopener"><i class="fab fa-tiktok me-1"></i>TikTok</a>@endif
                  @if($xx)<a class="btn-chip" href="{{ $xx }}" target="_blank" rel="noopener"><i class="fab fa-x-twitter me-1"></i>X</a>@endif
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- RIGHT: Map --}}
    <div class="contact-right">
      @php
        $addr = trim($contact->alamat ?? '');
        $link = trim($contact->link_maps ?? '');
        $lat  = $contact->latitude ?? null;
        $lng  = $contact->longitude ?? null;

        // 1) buang shortlink (tak bisa di-embed)
        if ($link && str_contains($link, 'maps.app.goo.gl')) {
          $link = '';
        }

        $gmapsEmbed = null;

        // 2) jika sudah embed resmi → pakai apa adanya
        if ($link && preg_match('~^https?://(www\.)?google\.[^/]+/maps/embed\?~i', $link)) {
          $gmapsEmbed = $link;
        }

        // 3) jika link berformat /maps/place|/maps/search → tambah output=embed (agar kartu tempat muncul)
        if (!$gmapsEmbed && $link && preg_match('~^https?://(www\.)?google\.[^/]+/maps/(place|search)/~i', $link)) {
          $gmapsEmbed = $link . (str_contains($link,'?') ? '&' : '?') . 'output=embed';
          if (!str_contains($gmapsEmbed, 'hl=')) $gmapsEmbed .= '&hl=id';
        }

        // 4) kalau belum ada link valid, pakai ALAMAT sebagai query (sering resolve ke Place → tampilkan nama)
        if (!$gmapsEmbed && $addr !== '') {
          $gmapsEmbed = 'https://www.google.com/maps?hl=id&q=' . urlencode($addr) . '&output=embed';
        }

        // 5) fallback terakhir: koordinat (biasanya tanpa nama tempat)
        if (!$gmapsEmbed && $lat && $lng) {
          $gmapsEmbed = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=16&hl=id&output=embed';
        }
      @endphp

      @if($gmapsEmbed)
        <div class="map-card">
          <div class="map-card__header">Lokasi Kami</div>
          <div class="map-embed">
            <iframe
              src="{{ $gmapsEmbed }}"
              class="map-iframe"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      @else
        <div class="map-card">
          <div class="map-card__header">Lokasi Kami</div>
          <div style="padding: 1rem; color: var(--c-muted);">Peta belum tersedia.</div>
        </div>
      @endif
    </div>

  </div>
</section>
@endsection
