{{-- Footer Modern + Kontak Dinamis --}}
@php
  // Ambil data kontak yang sudah kamu kirim dari controller (mis. $contact)
  // Fallback aman bila null
  $email = trim($contact->email ?? '');
  $tel   = trim($contact->telepon ?? '');
  $addr  = trim($contact->alamat ?? '');
  $lat   = $contact->latitude ?? null;
  $lng   = $contact->longitude ?? null;
  $link  = trim($contact->link_maps ?? '');

  // Normalisasi tel untuk href
  $telHref = $tel ? preg_replace('/[^0-9+]/','',$tel) : null;

  // Buat tautan Google Maps (tanpa embed) — metode alamat
  $gmapsLink = null;
  // buang shortlink app (biasanya tak bisa di-embed / dibuka konsisten)
  if ($link && str_contains($link, 'maps.app.goo.gl')) { $link = ''; }

  if ($link && preg_match('~^https?://(www\.)?google\.[^/]+/maps/~i', $link)) {
    $gmapsLink = $link;
  }
  if (!$gmapsLink && $addr !== '') {
    $gmapsLink = 'https://www.google.com/maps/search/?api=1&query='.urlencode($addr);
  }
  if (!$gmapsLink && $lat && $lng) {
    $gmapsLink = 'https://www.google.com/maps?q='.$lat.','.$lng.'&z=16';
  }

  // ====== METODE SAMA DITERAPKAN KE SOSIAL MEDIA ======
  // Ambil dari CRUD Contact (kolom social_facebook, social_instagram, social_tiktok, social_x)
  $rawFb = trim($contact->social_facebook ?? '');
  $rawIg = trim($contact->social_instagram ?? '');
  $rawTt = trim($contact->social_tiktok ?? '');
  $rawX  = trim($contact->social_x ?? '');

  // Normalisasi URL: kalau tidak ada skema, tambah https:// ; kalau kosong / "#" → null
  $normalizeUrl = function ($url) {
    if (!$url) return null;
    $u = trim($url);
    if ($u === '#' || $u === '-') return null;
    if (!preg_match('~^https?://~i', $u)) {
      $u = 'https://' . ltrim($u, '/');
    }
    return $u;
  };

  $fb = $normalizeUrl($rawFb);
  $ig = $normalizeUrl($rawIg);
  $tt = $normalizeUrl($rawTt);
  $xx = $normalizeUrl($rawX);

  $appName = config('app.name', 'LandPage');
@endphp

<footer class="site-footer" data-aos="fade-up" data-aos-duration="500">
  <div class="footer__top-accent" aria-hidden="true"></div>

  <div class="footer-container">
    {{-- Brand / Deskripsi --}}
    <div class="footer-brand">
      <a href="{{ route('home.index') }}" class="footer-logo" aria-label="{{ $appName }}">
        <span class="logo-dot"></span>{{ $appName }}
      </a>
      <p class="brand-copy">Belajar lebih mudah dan fleksibel di platform kami. Materi terstruktur, proyek nyata, dan komunitas suportif.</p>

      <div class="social-icons" aria-label="Sosial media">
        @if($fb)
          <a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook" class="soc">
            <i class="fab fa-facebook"></i>
          </a>
        @endif
        @if($ig)
          <a href="{{ $ig }}" target="_blank" rel="noopener" aria-label="Instagram" class="soc">
            <i class="fab fa-instagram"></i>
          </a>
        @endif
        @if($tt)
          <a href="{{ $tt }}" target="_blank" rel="noopener" aria-label="TikTok" class="soc">
            <i class="fab fa-tiktok"></i>
          </a>
        @endif
        @if($xx)
          <a href="{{ $xx }}" target="_blank" rel="noopener" aria-label="X (Twitter)" class="soc">
            <i class="fab fa-x-twitter"></i>
          </a>
        @endif
        {{-- Jika semua kosong, bisa tampilkan placeholder atau biarkan kosong --}}
        @if(!$fb && !$ig && !$tt && !$xx)
          {{-- <span class="ci-muted">Sosial media belum ditambahkan.</span> --}}
        @endif
      </div>
    </div>

    {{-- Menu cepat --}}
    <nav class="footer-links" aria-label="Tautan utama">
      <h4>Menu</h4>
      <ul>
        <li><a href="{{ route('home.index') }}">Home</a></li>
        <li><a href="{{ route('course.index') }}">about</a></li>
        <li><a href="{{ route('katalog.index') }}">katalog</a></li>
                <li><a href="{{ route('instruktur.index') }}">instruktur</a></li>
        <li><a href="{{ route('showcase.index') }}">karya member</a></li>
        <li><a href="{{ route('testimoni.index') }}">testimoni</a></li>
        @isset($extraLinks)
          @foreach($extraLinks as $text => $url)
            <li><a href="{{ $url }}">{{ $text }}</a></li>
          @endforeach
        @endisset
      </ul>
    </nav>

    {{-- Kontak dinamis --}}
    <div class="footer-contact">
      <h4>Contact</h4>
      <ul class="contact-list">
        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
          <div class="ci-text">
            <span class="ci-label">Email</span>
            @if($email)
              <a class="ci-value" href="mailto:{{ $email }}">{{ $email }}</a>
            @else
              <span class="ci-muted">-</span>
            @endif
          </div>
        </li>

        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
          <div class="ci-text">
            <span class="ci-label">Telepon</span>
            @if($tel && $telHref)
              <a class="ci-value" href="tel:{{ $telHref }}">{{ $tel }}</a>
            @else
              <span class="ci-muted">-</span>
            @endif
          </div>
        </li>

        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></span>
          <div class="ci-text">
            <span class="ci-label">Alamat</span>
            <span class="ci-value">{{ $addr ?: '-' }}</span>
            @if($gmapsLink)
              <a class="ci-action" href="{{ $gmapsLink }}" target="_blank" rel="noopener">
                Buka di Google Maps <i class="fas fa-external-link-alt ml-2"></i>
              </a>
            @endif
          </div>
        </li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
    <a href="#top" class="backTop" aria-label="Kembali ke atas"><i class="fas fa-arrow-up"></i></a>
  </div>
</footer>

@push('scripts')
<script>
  (function(){
    const toggle = document.getElementById('chatToggle');
    const close  = document.getElementById('chatClose');
    const box    = document.getElementById('chatBox');

    function openChat(){
      box.classList.add('active');
      toggle.setAttribute('aria-expanded','true');
    }
    function closeChat(){
      box.classList.remove('active');
      toggle.setAttribute('aria-expanded','false');
    }

    toggle?.addEventListener('click', () => {
      box.classList.toggle('active');
      toggle.setAttribute('aria-expanded', box.classList.contains('active') ? 'true' : 'false');
    });
    close?.addEventListener('click', closeChat);
  })();
</script>
@endpush
