<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title', 'E-Learning')</title>

  {{-- CSS Global --}}
  <link rel="stylesheet" href="{{ asset('client/header.css') }}"/>
  <link rel="stylesheet" href="{{ asset('client/footer.css') }}"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @stack('styles')
</head>
<body>
<a href="#main" class="skip-link">Lewati ke konten</a>

<header class="header">
  <div class="container header-container">
    <a href="{{ route('home.index') }}" class="logo" aria-label="Home">LandPage</a>

    {{-- Desktop Nav --}}
    <nav class="nav-center" aria-label="Primary">
      <a href="{{ route('home.index') }}"
         class="{{ request()->routeIs('home.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('home.*')) aria-current="page" @endif>Home</a>

      <a href="{{ route('about.index')}}"
         class="{{ request()->routeIs('about.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('about.*')) aria-current="page" @endif>About</a>

      <a href="{{ route('contact.index') }}"
         class="{{ request()->routeIs('contact.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('contact.*')) aria-current="page" @endif>Kontak kami</a>

      <a href="{{ route('showcase.index') }}"
         class="{{ request()->routeIs('showcase.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('showcase.*')) aria-current="page" @endif>karya member</a>

      <a href="{{ route('testimoni.index') }}"
         class="{{ request()->routeIs('testimoni.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('testimoni.*')) aria-current="page" @endif>testimoni</a>

      <a href="{{ route('katalog.index') }}"
         class="{{ request()->routeIs('katalog.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('katalog.*')) aria-current="page" @endif>katalog</a>

      <a href="{{ route('instruktur.index') }}"
         class="{{ request()->routeIs('instruktur.*') ? 'is-active' : '' }}"
         @if(request()->routeIs('instruktur.*')) aria-current="page" @endif>instruktur</a>
    </nav>

    <div class="nav-right">
  @guest
    <a href="{{ route('login') }}" class="btn-login">Log in</a>
  @else
    @hasanyrole('superadmin|admin|instructor')
      <a href="{{ route('admin.dashboard.index') }}" class="link-dashboard">Dashboard</a>
    @else
      <a href="{{ route('dashboard.index') }}" class="link-dashboard">Dashboard</a>
    @endhasanyrole
  @endguest

  <button class="hamburger" id="hamburger"
          aria-label="Buka menu"
          aria-controls="mobile-menu"
          aria-expanded="false">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
  </button>
</div>

  </div>

  {{-- Overlay --}}
  <div class="mobile-overlay" id="mobile-overlay" aria-hidden="true" hidden></div>

  {{-- Mobile Drawer --}}
  <nav class="mobile-drawer" id="mobile-menu" aria-label="Mobile"
       aria-hidden="true" aria-modal="true">
    <div class="drawer-header">
      <span class="drawer-logo">LandPage</span>
      <button class="drawer-close" id="drawer-close" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="drawer-links">
      {{-- sama seperti desktop --}}
      <a href="{{ route('home.index') }}"><i class="fa-solid fa-house"></i> Home</a>
      <a href="{{ route('about.index')}}"><i class="fa-solid fa-circle-info"></i> About</a>
      <a href="{{ route('contact.index') }}"><i class="fa-solid fa-envelope"></i> Kontak kami</a>
      <a href="{{ route('showcase.index') }}"><i class="fa-solid fa-images"></i> karya member</a>
      <a href="{{ route('testimoni.index') }}"><i class="fa-solid fa-comments"></i> testimoni</a>
      <a href="{{ route('katalog.index') }}"><i class="fa-solid fa-list"></i> katalog</a>
      <a href="{{ route('instruktur.index') }}"><i class="fa-solid fa-chalkboard-user"></i> instruktur</a>
    </div>

    <div class="drawer-actions">
  @guest
    <a href="{{ route('login') }}" class="btn-login block">Log in</a>
  @else
    @hasanyrole('superadmin|admin|instructor')
      <a href="{{ route('admin.dashboard.index') }}" class="btn-dashboard block">Dashboard</a>
    @else
      <a href="{{ route('dashboard.index') }}" class="btn-dashboard block">Dashboard</a>
    @endhasanyrole
  @endguest
</div>

  </nav>
</header>

<main id="main">
  @yield('content')
</main>

{{-- Opsional: tampilkan footer global kalau ada --}}
@includeIf('client.footer')

@stack('scripts')

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 700, easing: 'ease-out' });

  // Mobile drawer toggle + ARIA + focus trap (tanpa efek scroll header)
  (function(){
    const btn = document.getElementById('hamburger');
    const drawer = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');
    const closeBtn = document.getElementById('drawer-close');
    let lastFocus = null;

    const focusablesSel = 'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])';

    function setOverlay(open){
      overlay.hidden = !open;
      overlay.dataset.open = open ? 'true' : 'false';
      overlay.setAttribute('aria-hidden', String(!open));
    }

    function openMenu(){
  lastFocus = document.activeElement;
  drawer.classList.add('open');
  drawer.setAttribute('aria-hidden','false');
  setOverlay(true);
  document.body.style.overflow = 'hidden';
  btn.setAttribute('aria-expanded','true');
  btn.setAttribute('aria-label','Tutup menu');
  btn.classList.add('is-open'); // <-- TAMBAHKAN

  const focusables = drawer.querySelectorAll(focusablesSel);
  focusables[0]?.focus();

  function trap(e){
    if(e.key !== 'Tab') return;
    const list = Array.from(drawer.querySelectorAll(focusablesSel)).filter(el=>el.offsetParent !== null);
    const first = list[0], last = list[list.length-1];
    if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
    if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
  }
  drawer.addEventListener('keydown', trap, { once:false, passive:false });
  drawer._trap = trap;
}

function closeMenu(){
  drawer.classList.remove('open');
  drawer.setAttribute('aria-hidden','true');
  setOverlay(false);
  document.body.style.overflow = '';
  btn.setAttribute('aria-expanded','false');
  btn.setAttribute('aria-label','Buka menu');
  btn.classList.remove('is-open'); // <-- TAMBAHKAN
  if(drawer._trap) drawer.removeEventListener('keydown', drawer._trap);
  lastFocus?.focus();
}


    btn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);
    window.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeMenu(); });
  })();
</script>
</body>
</html>
