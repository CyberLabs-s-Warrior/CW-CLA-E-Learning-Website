@extends('templates.app')
@section('title','Kontak')

@section('content')
<div class="container-fluid py-4">
  <!-- Header -->
  <div class="d-flex align-items-center gap-2 mb-4">
    <h1 class="h4 mb-0">Informasi Kontak</h1>
    <div class="ms-auto d-flex gap-2">
      <a href="{{ route('admin.contact.edit') }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i> Edit
      </a>
    </div>
  </div>

  @if(session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success', title: 'Berhasil!', text: @json(session('success')),
          timer: 2200, showConfirmButton: false
        });
      });
    </script>
  @endif

  @php
    $alamat   = $contact->alamat ?? null;
    $email    = $contact->email ?? null;
    $telepon  = $contact->telepon ?? null;
    $lat      = $contact->latitude ?? null;
    $lng      = $contact->longitude ?? null;
    $linkMaps = $contact->link_maps ?? null;

    // Sosial media
    $fb = trim($contact->social_facebook ?? '');
    $ig = trim($contact->social_instagram ?? '');
    $tt = trim($contact->social_tiktok ?? '');
    $xx = trim($contact->social_x ?? '');
    $hasSocial = $fb || $ig || $tt || $xx;

    // Normalisasi nomor telp untuk link tel:
    $telHref = $telepon ? preg_replace('/[^0-9+]/','', $telepon) : null;

    // Link Google Maps (klik)
    $gmapsClick = null;
    if (!empty($alamat)) {
      $gmapsClick = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($alamat);
    } elseif (!empty($lat) && !empty($lng)) {
      $gmapsClick = 'https://www.google.com/maps?q=' . $lat . ',' . $lng;
    }

    // Sumber iframe Google Maps (embed)
    $gmapsEmbed = null;
    if (!empty($linkMaps)) {
      $gmapsEmbed = str_contains($linkMaps,'output=embed')
        ? $linkMaps
        : $linkMaps . (str_contains($linkMaps,'?') ? '&' : '?') . 'output=embed';
    } elseif (!empty($lat) && !empty($lng)) {
      $gmapsEmbed = "https://www.google.com/maps?q={$lat},{$lng}&z=16&hl=id&output=embed";
    }

    $hasAny = $alamat || $email || $telepon || ($lat && $lng) || $hasSocial;
  @endphp

  <div class="row g-4">
    <!-- KIRI: Detail -->
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
          @if(!$hasAny)
            <div class="p-4 text-center text-muted">
              <i class="fas fa-circle-info me-2"></i>Belum ada data kontak. Klik <strong>Edit</strong> untuk menambahkan.
            </div>
          @else
            <div class="list-group list-group-flush">

              <div class="list-group-item py-3">
                <div class="fw-semibold mb-1"><i class="fas fa-map-marker-alt me-2"></i>Alamat</div>
                <div class="{{ $alamat ? '' : 'text-muted' }}">{{ $alamat ?? '-' }}</div>
                @if($gmapsClick)
                  <div class="mt-2">
                    <a href="{{ $gmapsClick }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                      <i class="fab fa-google me-1"></i>Buka di Google Maps
                    </a>
                  </div>
                @endif
              </div>

              <div class="list-group-item py-3">
                <div class="fw-semibold mb-1"><i class="fas fa-envelope me-2"></i>Email</div>
                @if($email)
                  <a href="mailto:{{ $email }}">{{ $email }}</a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </div>

              <div class="list-group-item py-3">
                <div class="fw-semibold mb-1"><i class="fas fa-phone me-2"></i>Telepon</div>
                @if($telepon)
                  <a href="tel:{{ $telHref }}">{{ $telepon }}</a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </div>

              {{-- SOSIAL MEDIA --}}
              <div class="list-group-item py-3">
                <div class="fw-semibold mb-1"><i class="fas fa-share-alt me-2"></i>Sosial Media</div>
                @if(!$hasSocial)
                  <span class="text-muted">-</span>
                @else
                  <div class="d-flex flex-wrap gap-2">
                    @if($fb)
                      <a href="{{ $fb }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border">
                        <i class="fab fa-facebook me-1"></i>Facebook
                      </a>
                    @endif
                    @if($ig)
                      <a href="{{ $ig }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border">
                        <i class="fab fa-instagram me-1"></i>Instagram
                      </a>
                    @endif
                    @if($tt)
                      <a href="{{ $tt }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border">
                        <i class="fab fa-tiktok me-1"></i>TikTok
                      </a>
                    @endif
                    @if($xx)
                      <a href="{{ $xx }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border">
                        <i class="fab fa-x-twitter me-1"></i>X
                      </a>
                    @endif
                  </div>
                @endif
              </div>

              <div class="list-group-item py-3">
                <div class="fw-semibold mb-2"><i class="fas fa-location-crosshairs me-2"></i>Koordinat</div>
                @if($lat && $lng)
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="badge bg-light text-dark border">Lat: <span id="latVal">{{ number_format((float)$lat, 6, '.', '') }}</span></span>
                    <span class="badge bg-light text-dark border">Lng: <span id="lngVal">{{ number_format((float)$lng, 6, '.', '') }}</span></span>
                    <button class="btn btn-outline-secondary btn-sm" id="copyCoord" type="button">
                      <i class="fas fa-copy me-1"></i>Salin
                    </button>
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </div>

            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- KANAN: Peta -->
    <div class="col-12 col-lg-5">
      <div class="position-lg-sticky" style="top: 88px;">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-header bg-white border-0">
            <div class="fw-semibold"><i class="fas fa-map me-2"></i>Pratinjau Lokasi</div>
            <div class="small text-muted">Sumber: Google Maps</div>
          </div>
          <div class="card-body p-0">
            @if($gmapsEmbed)
              <div class="ratio ratio-16x9">
                <iframe src="{{ $gmapsEmbed }}" style="border:0" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            @else
              <div class="p-4 text-center text-muted">
                <i class="fas fa-map-pin me-2"></i>Belum ada lokasi untuk ditampilkan.
              </div>
            @endif
          </div>
          @if($gmapsClick)
            <div class="card-footer bg-white">
              <a href="{{ $gmapsClick }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                <i class="fab fa-google me-1"></i>Buka di Google Maps
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .rounded-4 { border-radius: 1rem; }
</style>
@endpush

@push('scripts')
<script>
  // Salin koordinat
  (function(){
    const btn = document.getElementById('copyCoord');
    if(!btn) return;
    btn.addEventListener('click', async () => {
      const lat = document.getElementById('latVal')?.textContent?.trim();
      const lng = document.getElementById('lngVal')?.textContent?.trim();
      if(!lat || !lng) return;
      const text = `${lat}, ${lng}`;
      try {
        await navigator.clipboard.writeText(text);
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Tersalin';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        setTimeout(() => {
          btn.innerHTML = '<i class="fas fa-copy me-1"></i>Salin';
          btn.classList.remove('btn-success');
          btn.classList.add('btn-outline-secondary');
        }, 1600);
      } catch {}
    });
  })();
</script>
@endpush
