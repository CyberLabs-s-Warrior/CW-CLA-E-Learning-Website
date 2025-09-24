@php

  $email = trim($contact->email ?? '');
  $tel = trim($contact->telepon ?? '');
  $addr = trim($contact->alamat ?? '');
  $lat = $contact->latitude ?? null;
  $lng = $contact->longitude ?? null;
  $link = trim($contact->link_maps ?? '');

  $fb = trim($contact->social_facebook ?? '');
  $ig = trim($contact->social_instagram ?? '');
  $tt = trim($contact->social_tiktok ?? '');
  $xx = trim($contact->social_x ?? '');
  $hasSocial = $fb || $ig || $tt || $xx;

  $telHref = $tel ? preg_replace('/[^0-9+]/', '', $tel) : null;

  if ($link && str_contains($link, 'maps.app.goo.gl')) {
    $link = '';
  }

  $gmapsLink = null;
  if ($link && preg_match('~^https?://(www\.)?google\.[^/]+/maps/~i', $link)) {
    $gmapsLink = $link;
  }
  if (!$gmapsLink && $addr !== '') {
    $gmapsLink = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($addr);
  }
  if (!$gmapsLink && $lat && $lng) {
    $gmapsLink = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=16';
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
    <div class="footer-brand">
      <a href="{{ route('home.index') }}" class="footer-logo" aria-label="{{ $appName }}">
        <span class="logo-dot"></span>{{ $appName }}
      </a>
      <p class="brand-copy">Belajar lebih mudah dan fleksibel di platform kami. Materi terstruktur, proyek nyata, dan
        komunitas suportif.</p>

      @if($hasSocial)
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
        </div>
      @endif
    </div>

    <nav class="footer-links" aria-label="Tautan utama">
      <div class="mnav" data-collapsible>
        <div class="mnav-head">
          <h4 class="mnav-title">Menu</h4>
          <button class="mnav-toggle" type="button" aria-expanded="false" aria-controls="footerMainMenu">
            <span class="mnav-toggle__label">Lihat Menu</span>
            <i class="fas fa-chevron-down" aria-hidden="true"></i>
          </button>
        </div>

        <ul id="footerMainMenu" class="mnav-list" role="list">
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('home.index') }}"><i class="fas fa-home"></i><span>Home</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('katalog.index') }}"><i
                class="fas fa-folder-open"></i><span>Katalog</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('testimoni.index') }}"><i
                class="fas fa-comments"></i><span>Testimoni</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('forum.index') }}"><i class="fas fa-message"></i><span>Forum</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('instruktur.index') }}"><i
                class="fas fa-chalkboard-teacher"></i><span>Instruktur</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('about.index') }}"><i
                class="fas fa-circle-info"></i><span>About</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('contact.index') }}"><i
                class="fas fa-envelope"></i><span>Contact</span></a>
          </li>
          <li class="mnav-item">
            <a class="mnav-link" href="{{ route('showcase.index') }}"><i
                class="fas fa-star"></i><span>Showcase</span></a>
          </li>

          @isset($extraLinks)
            @foreach($extraLinks as $text => $url)
              <li class="mnav-item">
                <a class="mnav-link" href="{{ $url }}"><i class="fas fa-link"></i><span>{{ $text }}</span></a>
              </li>
            @endforeach
          @endisset
        </ul>
      </div>
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
    document.querySelector('.backTop').addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    window.addEventListener('scroll', function () {
      const btn = document.querySelector('.backTop');
      if (window.scrollY > 300) {
        btn.classList.add('show');
      } else {
        btn.classList.remove('show');
      }
    });

    (function () {
      const mnav = document.querySelector('.footer-links .mnav[data-collapsible]');
      const btn = mnav?.querySelector('.mnav-toggle');
      if (!mnav || !btn) return;

      const setExpanded = (val) => {
        mnav.setAttribute('aria-expanded', val ? 'true' : 'false');
        btn.setAttribute('aria-expanded', val ? 'true' : 'false');
        btn.querySelector('.mnav-toggle__label').textContent = val ? 'Tutup Menu' : 'Lihat Menu';
      };
      setExpanded(false);

      btn.addEventListener('click', () => {
        const isOpen = mnav.getAttribute('aria-expanded') === 'true';
        setExpanded(!isOpen);
      });

      const mq = window.matchMedia('(min-width: 721px)');
      const sync = () => { if (mq.matches) setExpanded(true); else setExpanded(false); };
      mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync);
      sync();
    })();
  </script>

  <script>
    (function () {
      const toggle = document.getElementById('chatToggle');
      const close = document.getElementById('chatClose');
      const box = document.getElementById('chatBox');

      function closeChat() {
        box?.classList.remove('active');
        toggle?.setAttribute('aria-expanded', 'false');
      }

      toggle?.addEventListener('click', () => {
        const active = box?.classList.toggle('active');
        toggle?.setAttribute('aria-expanded', active ? 'true' : 'false');
      });
      close?.addEventListener('click', closeChat);
    })();
  </script>
@endpush