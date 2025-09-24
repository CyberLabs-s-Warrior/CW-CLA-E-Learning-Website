@extends('templates.app')
@section('title','Edit Kontak')

@section('content')
<div class="container-fluid py-4">
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
    <div>
      <h1 class="h4 mb-1 fw-semibold">Edit Kontak</h1>
      <div class="text-muted small">Perbarui alamat, kontak, dan lokasi Anda pada peta dengan akurat.</div>
    </div>
    <a href="{{ route('admin.contact.index') }}" class="btn btn-light border rounded-pill px-3">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger rounded-3 shadow-sm">
      <div class="fw-semibold mb-1">
        <i class="fas fa-exclamation-triangle me-2"></i>Periksa kembali isian Anda
      </div>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row g-4 align-items-start">
    <!-- KANAN: MAP + PREVIEW (sticky) -->
    <div class="col-12 col-lg-6 order-1 order-lg-2">
      <div class="position-lg-sticky" style="top: 88px;">
        @php
          // ==== PRIORITAS PREVIEW: link embed/place → alamat → koordinat ====
          $embedInit = null;
          $addr     = old('alamat', $contact->alamat ?? '');
          $oldLink  = trim(old('link_maps', $contact->link_maps ?? ''));
          $lat0     = old('latitude',  $contact->latitude  ?? null);
          $lng0     = old('longitude', $contact->longitude ?? null);

          // Abaikan shortlink share app (tidak bisa di-embed langsung)
          if ($oldLink && str_contains($oldLink, 'maps.app.goo.gl')) {
            $oldLink = '';
          }

          if ($oldLink) {
            if (preg_match('~^https?://(www\.)?google\.[^/]+/maps/embed\?~i', $oldLink)) {
              // Sudah embed resmi
              $embedInit = $oldLink;
            } elseif (preg_match('~^https?://(www\.)?google\.[^/]+/maps/(place|search)/~i', $oldLink)) {
              // Place / Search → tambahkan output=embed
              $embedInit = $oldLink.(str_contains($oldLink,'?')?'&':'?').'output=embed';
            } else {
              // Link Google biasa → coba paksa embed
              $embedInit = $oldLink.(str_contains($oldLink,'?')?'&':'?').'output=embed';
            }
          } elseif (!empty($addr)) {
            // Alamat → sering resolve ke Place (menampilkan kartu nama)
            $embedInit = 'https://www.google.com/maps?hl=id&q='.urlencode($addr).'&output=embed';
          } elseif (!empty($lat0) && !empty($lng0)) {
            // Fallback terakhir: koordinat (biasanya tanpa nama tempat)
            $embedInit = 'https://www.google.com/maps?q='.$lat0.','.$lng0.'&z=16&hl=id&output=embed';
          }
        @endphp

        <div class="card card-elev border-0 rounded-4">
          <!-- Tabs -->
          <div class="card-header bg-white border-0 px-3 px-md-4">
            <ul class="nav nav-tabs card-header-tabs" id="mapTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="osm-tab" data-bs-toggle="tab" data-bs-target="#osm-pane" type="button" role="tab" aria-controls="osm-pane" aria-selected="true">
                  <i class="fas fa-map-marked-alt me-2"></i>Peta (OpenStreetMap)
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="gmaps-tab" data-bs-toggle="tab" data-bs-target="#gmaps-pane" type="button" role="tab" aria-controls="gmaps-pane" aria-selected="false">
                  <i class="fab fa-google me-2"></i>Pratinjau Google Maps
                </button>
              </li>
            </ul>
          </div>

          <div class="card-body p-0">
            <div class="tab-content">
              <!-- OSM PANEL -->
              <div class="tab-pane fade show active" id="osm-pane" role="tabpanel" aria-labelledby="osm-tab" tabindex="0">
                <div class="position-relative">
                  <!-- Toolbar kecil di atas peta -->
                  <div class="map-toolbar">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                      <button type="button" id="useMyLocation" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-location-arrow me-1"></i>Lokasiku
                      </button>
                      <div class="d-flex align-items-center small text-muted">
                        <span class="badge bg-light text-dark border me-2">
                          Lat: <span id="latBadge">—</span>
                        </span>
                        <span class="badge bg-light text-dark border">
                          Lng: <span id="lngBadge">—</span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div id="map" class="rounded-top-4" style="height: 440px;"></div>
                </div>
                <div class="px-3 py-2 border-top small text-muted">
                  Klik peta untuk menetapkan titik. Koordinat <em>tidak</em> akan menimpa Link Maps.
                </div>
              </div>

              <!-- GMAPS PANEL -->
              <div class="tab-pane fade" id="gmaps-pane" role="tabpanel" aria-labelledby="gmaps-tab" tabindex="0">
                <div class="ratio ratio-16x9">
                  <iframe id="gmapsPreview"
                          src="{{ $embedInit ?? '' }}"
                          style="border:0;width:100%;height:100%"
                          allowfullscreen loading="lazy"
                          referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="px-3 py-2 border-top small text-muted">
                  Pratinjau ini menggunakan <code>Link Maps</code> di bawah (disarankan format <code>/maps/embed?pb=...</code> dari “Sematkan peta”).
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- KIRI: FORM -->
    <div class="col-12 col-lg-6 order-2 order-lg-1">
      <div class="card card-elev border-0 rounded-4 h-100">
        <div class="card-body p-4">
          <form action="{{ route('admin.contact.update') }}" method="POST" id="editContactForm" novalidate>
            @csrf

            <!-- BLOK: LOKASI -->
            <div class="mb-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <label for="searchBox" class="form-label fw-semibold mb-0">
                  <i class="fas fa-location-dot me-2"></i>Lokasi (Cari & Pilih)
                </label>
                <small class="text-muted">Nominatim / OpenStreetMap</small>
              </div>

              <div class="position-relative autocomplete">
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                  <input
                    type="text"
                    id="searchBox"
                    class="form-control"
                    placeholder="Contoh: Gedung Sate, Bandung"
                    autocomplete="off"
                    role="combobox"
                    aria-expanded="false"
                    aria-controls="suggestions"
                    aria-autocomplete="list"
                  >
                </div>
                <ul id="suggestions"
                    class="dropdown-menu w-100 shadow-sm mt-1"
                    style="max-height: 280px; overflow-y: auto;"
                    role="listbox">
                </ul>
              </div>

              <div class="row g-2 mt-2">
                <div class="col-6">
                  <div class="form-control form-control-sm bg-light">
                    <span class="text-muted small">Latitude</span>
                    <div class="fw-semibold" id="latText">—</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-control form-control-sm bg-light">
                    <span class="text-muted small">Longitude</span>
                    <div class="fw-semibold" id="lngText">—</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- BLOK: ALAMAT -->
            <div class="mb-4">
              <label for="alamat" class="form-label fw-semibold">
                <i class="fas fa-map me-2"></i>Alamat
              </label>
              <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Nama jalan, nomor, kelurahan, kecamatan, kota">{{ old('alamat', $contact->alamat ?? '') }}</textarea>
            </div>

            <!-- BLOK: KONTAK -->
            <div class="mb-4">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="email" class="form-label fw-semibold">
                    <i class="fas fa-envelope me-2"></i>Email
                  </label>
                  <input type="email" name="email" id="email" class="form-control"
                         placeholder="nama@domain.com"
                         value="{{ old('email', $contact->email ?? '') }}">
                </div>
                <div class="col-md-6">
                  <label for="telepon" class="form-label fw-semibold">
                    <i class="fas fa-phone me-2"></i>Telepon
                  </label>
                  <input type="text" name="telepon" id="telepon" class="form-control"
                         inputmode="tel" placeholder="+62 ..."
                         value="{{ old('telepon', $contact->telepon ?? '') }}">
                </div>
              </div>
            </div>
            {{-- BLOK: SOSIAL MEDIA --}}
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="fas fa-share-alt me-2"></i>Sosial Media
              </label>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="social_facebook" class="form-label small"><i class="fab fa-facebook me-1"></i>Facebook (URL)</label>
                  <input type="url" name="social_facebook" id="social_facebook" class="form-control"
                        placeholder="https://www.facebook.com/yourpage"
                        value="{{ old('social_facebook', $contact->social_facebook ?? '') }}">
                </div>

                <div class="col-md-6">
                  <label for="social_instagram" class="form-label small"><i class="fab fa-instagram me-1"></i>Instagram (URL)</label>
                  <input type="url" name="social_instagram" id="social_instagram" class="form-control"
                        placeholder="https://www.instagram.com/yourhandle"
                        value="{{ old('social_instagram', $contact->social_instagram ?? '') }}">
                </div>

                <div class="col-md-6">
                  <label for="social_tiktok" class="form-label small"><i class="fab fa-tiktok me-1"></i>TikTok (URL)</label>
                  <input type="url" name="social_tiktok" id="social_tiktok" class="form-control"
                        placeholder="https://www.tiktok.com/@yourhandle"
                        value="{{ old('social_tiktok', $contact->social_tiktok ?? '') }}">
                </div>

                <div class="col-md-6">
                  <label for="social_x" class="form-label small"><i class="fab fa-x-twitter me-1"></i>X / Twitter (URL)</label>
                  <input type="url" name="social_x" id="social_x" class="form-control"
                        placeholder="https://x.com/yourhandle"
                        value="{{ old('social_x', $contact->social_x ?? '') }}">
                </div>
              </div>

              <div class="form-text mt-1">
                Masukkan URL penuh (diawali <code>https://</code>). Kosongkan jika tidak ingin ditampilkan.
              </div>
            </div>


            <!-- HIDDEN KOORDINAT -->
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $contact->latitude ?? '') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $contact->longitude ?? '') }}">
            {{-- BLOK: SOSIAL MEDIA --}}
<div class="mb-4">
  <label class="form-label fw-semibold">
    <i class="fas fa-share-alt me-2"></i>Sosial Media
  </label>

  <div class="row g-3">
    <div class="col-md-6">
      <label for="social_facebook" class="form-label small"><i class="fab fa-facebook me-1"></i>Facebook (URL)</label>
      <input type="url" name="social_facebook" id="social_facebook" class="form-control"
             placeholder="https://www.facebook.com/yourpage"
             value="{{ old('social_facebook', $contact->social_facebook ?? '') }}">
    </div>

    <div class="col-md-6">
      <label for="social_instagram" class="form-label small"><i class="fab fa-instagram me-1"></i>Instagram (URL)</label>
      <input type="url" name="social_instagram" id="social_instagram" class="form-control"
             placeholder="https://www.instagram.com/yourhandle"
             value="{{ old('social_instagram', $contact->social_instagram ?? '') }}">
    </div>

    <div class="col-md-6">
      <label for="social_tiktok" class="form-label small"><i class="fab fa-tiktok me-1"></i>TikTok (URL)</label>
      <input type="url" name="social_tiktok" id="social_tiktok" class="form-control"
             placeholder="https://www.tiktok.com/@yourhandle"
             value="{{ old('social_tiktok', $contact->social_tiktok ?? '') }}">
    </div>

    <div class="col-md-6">
      <label for="social_x" class="form-label small"><i class="fab fa-x-twitter me-1"></i>X / Twitter (URL)</label>
      <input type="url" name="social_x" id="social_x" class="form-control"
             placeholder="https://x.com/yourhandle"
             value="{{ old('social_x', $contact->social_x ?? '') }}">
    </div>
  </div>

  <div class="form-text mt-1">
    Masukkan URL penuh (diawali <code>https://</code>). Kosongkan jika tidak ingin ditampilkan.
  </div>
</div>

            <!-- BLOK: LINK GMAPS -->
            <div class="mb-3">
              <label for="link_maps" class="form-label fw-semibold">
                <i class="fab fa-google me-2"></i>Link Maps (Google) <span class="text-muted">— untuk iframe</span>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-link"></i></span>
                <input type="url" name="link_maps" id="link_maps" class="form-control"
                       placeholder="Tempel URL embed / place Google Maps (disarankan: /maps/embed?pb=...)"
                       value="{{ old('link_maps', $contact->link_maps ?? '') }}">
              </div>
              <div class="form-text">
                Disarankan: Google Maps → <b>Bagikan</b> → <b>Sematkan peta</b> → salin <i>src</i> (format <code>/maps/embed?pb=...</code>) dan tempel di sini.
              </div>
              <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="rebuildEmbed">
                  Bangun dari Koordinat
                </button>
                <div class="form-text mb-0">
                  Catatan: embed dari koordinat biasanya <em>tanpa</em> nama tempat.
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end pt-2">
              <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4">
                <span id="btnText"><i class="fas fa-save me-2"></i>Simpan Perubahan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
  :root{
    --radius-xl: 1rem;
    --shadow-soft: 0 10px 30px rgba(0,0,0,.06), 0 2px 10px rgba(0,0,0,.04);
  }
  .card-elev{ box-shadow: var(--shadow-soft); }

  /* Map & toolbar */
  .map-toolbar{
    position:absolute; z-index: 1000; top: .75rem; left: .75rem;
    background: rgba(255,255,255,.92);
    border: 1px solid rgba(0,0,0,.06);
    backdrop-filter: blur(4px);
    border-radius: .75rem;
    padding: .5rem .6rem;
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
  }

  /* Leaflet image max-width fix */
  .leaflet-container img,
  .leaflet-pane img,
  .leaflet-marker-icon,
  .leaflet-tile { max-width: none !important; }

  /* Autocomplete */
  .autocomplete .dropdown-menu { display:none; z-index:1060; border-radius:.75rem; }
  .autocomplete .dropdown-menu.show { display:block; }
  .autocomplete .dropdown-item{ padding:.6rem .9rem; }
  .autocomplete .dropdown-item.active,
  .autocomplete .dropdown-item:active{ background-color:#0d6efd; color:#fff; }

  /* Fokus input */
  .form-control:focus, .input-group .form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 .25rem rgba(13,110,253,.15);
    border-color: #95b9ff;
  }

  /* Map height small screens */
  @media (max-width: 575.98px){
    #map{ height:380px !important; }
  }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
(() => {
  // Elemen
  const latInput    = document.getElementById('latitude');
  const lngInput    = document.getElementById('longitude');
  const linkMaps    = document.getElementById('link_maps');
  const alamatEl    = document.getElementById('alamat');
  const searchBox   = document.getElementById('searchBox');
  const suggestions = document.getElementById('suggestions');
  const iframe      = document.getElementById('gmapsPreview');
  const useMyLocBtn = document.getElementById('useMyLocation');
  const rebuildBtn  = document.getElementById('rebuildEmbed');
  const latBadge    = document.getElementById('latBadge');
  const lngBadge    = document.getElementById('lngBadge');
  const latText     = document.getElementById('latText');
  const lngText     = document.getElementById('lngText');

  // ==== Helper baru: bangun embed dari QUERY teks (nama tempat / alamat) ====
  const buildEmbedFromQuery = (q) =>
    q ? `https://www.google.com/maps?hl=id&q=${encodeURIComponent(q)}&output=embed` : '';

  const normalizeEmbed = (url) => {
    if (!url) return '';
    const hasQuery = url.includes('?');
    return url.includes('output=embed') ? url : url + (hasQuery ? '&' : '?') + 'output=embed';
  };

  const updatePreview = () => {
    const src = (linkMaps.value || '').trim();
    if (!iframe) return;
    iframe.setAttribute('src', src ? normalizeEmbed(src) : 'about:blank');
  };

  const syncCoordBadges = (lat, lng) => {
    const plat = lat ? Number(lat).toFixed(6) : '—';
    const plng = lng ? Number(lng).toFixed(6) : '—';
    if (latBadge) latBadge.textContent = plat;
    if (lngBadge) lngBadge.textContent = plng;
    if (latText)  latText.textContent  = plat;
    if (lngText)  lngText.textContent  = plng;
  };

  // Map init
  const lat0 = latInput.value ? parseFloat(latInput.value) : -6.914744;  // Bandung default
  const lng0 = lngInput.value ? parseFloat(lngInput.value) : 107.609810;
  const map  = L.map('map', { zoomControl: true, scrollWheelZoom: true }).setView([lat0, lng0], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  let marker = null;
  const placeMarker = (lat, lng) => {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng]).addTo(map);
  };

  if (latInput.value && lngInput.value) {
    const plat = parseFloat(latInput.value), plng = parseFloat(lngInput.value);
    placeMarker(plat, plng);
    syncCoordBadges(plat, plng);
    setTimeout(() => map.panTo([plat, plng]), 0);
  } else {
    syncCoordBadges(null, null);
  }

  // Jangan menimpa Link Maps ke koordinat—kecuali saat datang dari autocomplete (address)
  const setMarkerAndState = (lat, lng, address) => {
    const plat = Number(lat).toFixed(6);
    const plng = Number(lng).toFixed(6);
    placeMarker(plat, plng);
    map.setView([plat, plng], 16);
    latInput.value = plat;
    lngInput.value = plng;
    syncCoordBadges(plat, plng);

    if (address && address.trim()) {
      alamatEl.value  = address;
      searchBox.value = address;
      linkMaps.value  = buildEmbedFromQuery(address); // ← dari ALAMAT/NAMA
      updatePreview();
    }
  };

  // Resize/first render
  setTimeout(() => { map.invalidateSize(); }, 0);
  window.addEventListener('resize', () => map.invalidateSize());

  // Klik peta → hanya ubah koordinat (tidak menimpa link maps)
  map.on('click', e => setMarkerAndState(e.latlng.lat, e.latlng.lng));

  // AUTOCOMPLETE (Nominatim) with debounce + abort + keyboard nav
  let typingTimer = null;
  let abortCtrl   = null;
  let activeIndex = -1;

  const hideSuggestions = () => {
    suggestions.classList.remove('show');
    searchBox.setAttribute('aria-expanded', 'false');
    activeIndex = -1;
  };

  const showSuggestions = () => {
    suggestions.classList.add('show');
    searchBox.setAttribute('aria-expanded', 'true');
  };

  const renderSuggestions = (items) => {
    suggestions.innerHTML = '';
    items.slice(0, 10).forEach((item) => {
      const li = document.createElement('li');
      li.role = 'option';
      li.className = 'dropdown-item';
      li.textContent = item.display_name;
      li.dataset.lat = item.lat;
      li.dataset.lng = item.lon;
      li.onclick = () => { setMarkerAndState(item.lat, item.lon, item.display_name); hideSuggestions(); };
      suggestions.appendChild(li);
    });
    items.length ? showSuggestions() : hideSuggestions();
  };

  searchBox.addEventListener('input', function() {
    clearTimeout(typingTimer);
    const q = this.value.trim();
    suggestions.innerHTML = '';
    hideSuggestions();
    if (q.length < 3) return;

    typingTimer = setTimeout(() => {
      if (abortCtrl) abortCtrl.abort();
      abortCtrl = new AbortController();

      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}`, {
        signal: abortCtrl.signal,
        headers: { 'Accept-Language': 'id' }
      })
      .then(r => r.ok ? r.json() : [])
      .then(list => renderSuggestions(list))
      .catch(() => { /* abaikan error jaringan */ });
    }, 300);
  });

  // Keyboard navigation dropdown
  searchBox.addEventListener('keydown', function(e) {
    const items = Array.from(suggestions.querySelectorAll('.dropdown-item'));
    if (!items.length) return;

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      activeIndex = (activeIndex + 1) % items.length;
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      activeIndex = (activeIndex - 1 + items.length) % items.length;
    } else if (e.key === 'Enter') {
      if (activeIndex >= 0) {
        e.preventDefault();
        items[activeIndex].click();
      }
    } else if (e.key === 'Escape') {
      hideSuggestions();
      return;
    } else {
      return;
    }

    items.forEach((el, i) => el.classList.toggle('active', i === activeIndex));
    const activeEl = items[activeIndex];
    if (activeEl) activeEl.scrollIntoView({ block: 'nearest' });
  });

  // Klik di luar → tutup dropdown
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.autocomplete')) hideSuggestions();
  });

  // Alamat diketik manual → bangun embed dari ALAMAT (bukan koordinat)
  let addrTimer = null;
  alamatEl.addEventListener('input', function() {
    clearTimeout(addrTimer);
    addrTimer = setTimeout(() => {
      const q = (this.value || '').trim();
      if (q) {
        linkMaps.value = buildEmbedFromQuery(q);
        updatePreview();
      }
    }, 350);
  });

  // Link diubah manual → preview
  linkMaps.addEventListener('input', updatePreview);

  // Tombol "Bangun dari Koordinat" (opsional; biasanya tanpa nama tempat)
  rebuildBtn?.addEventListener('click', () => {
    if (latInput.value && lngInput.value) {
      const lat = Number(latInput.value).toFixed(6);
      const lng = Number(lngInput.value).toFixed(6);
      linkMaps.value = `https://www.google.com/maps?q=${lat},${lng}&z=16&hl=id&output=embed`;
      updatePreview();
      const tabTrigger = document.querySelector('#gmaps-tab');
      if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
    }
  });

  // Gunakan lokasi perangkat
  useMyLocBtn?.addEventListener('click', () => {
    if (!navigator.geolocation) return;
    useMyLocBtn.disabled = true;
    useMyLocBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengambil...';
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const { latitude, longitude } = pos.coords;
        setMarkerAndState(latitude, longitude);
        useMyLocBtn.disabled = false;
        useMyLocBtn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Lokasiku';
      },
      () => {
        useMyLocBtn.disabled = false;
        useMyLocBtn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Lokasiku';
      },
      { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
    );
  });

  // Submit UX
  document.getElementById('editContactForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    const txt = document.getElementById('btnText');
    if (btn && txt) {
      btn.disabled = true;
      txt.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    }
  });

  // Preview awal sinkron + state koordinat
  updatePreview();
  if (latInput.value && lngInput.value) syncCoordBadges(latInput.value, lngInput.value);
})();
</script>
@endpush
