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
<header class="header" data-aos="fade-down" data-aos-duration="500">
  <div class="container header-container">
    <a href="{{ route('home.index') }}" class="logo" aria-label="Home">LandPage</a>

    {{-- Desktop Nav --}}
    <nav class="nav-center" aria-label="Primary">
      <a href="{{ route('home.index') }}">Home</a>
      <a href="{{ route('about.index')}}">About</a>
      <a href="{{ route('contact.index') }}">Kontak kami</a>
      <a href="{{ route('showcase.index') }}">karya member</a>
      <a href="{{ route('testimoni.index') }}">testimoni</a>
      <a href="{{ route('katalog.index') }}">katalog</a>
      <a href="{{ route('instruktur.index') }}">instruktur</a>
    </nav>

    {{-- Right --}}
    <div class="nav-right">
      @guest
        <a href="{{ route('login') }}" class="btn-login">Log in</a>
      @endguest

      @auth
        @role('student')
          <a href="{{ route('dashboard.index') }}" class="link-dashboard">DASHBOARD</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        @else
          <a href="{{ route('login') }}" class="btn-login">Log in</a>
        @endrole
      @endauth

      {{-- Hamburger (Mobile) --}}
      <button class="hamburger" id="hamburger"
              aria-label="Buka menu"
              aria-controls="mobile-menu"
              aria-expanded="false">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
      </button>
    </div>
  </div>

  {{-- Overlay --}}
  <div class="mobile-overlay" id="mobile-overlay" hidden></div>

  {{-- Mobile Drawer --}}
  <nav class="mobile-drawer" id="mobile-menu" aria-label="Mobile">
    <div class="drawer-header">
      <span class="drawer-logo">LandPage</span>
      <button class="drawer-close" id="drawer-close" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="drawer-links">
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
      @endguest

      @auth
        @role('student')
          <a href="{{ route('dashboard.index') }}" class="btn-dashboard block">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn-login block">Log in</a>
        @endrole
      @endauth
    </div>
  </nav>
</header>

<main>
  @yield('content')
</main>

@stack('scripts')

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 700, easing: 'ease-out' });

  // Mobile drawer toggle
  (function(){
    const btn = document.getElementById('hamburger');
    const drawer = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');
    const closeBtn = document.getElementById('drawer-close');

    function openMenu(){
      drawer.classList.add('open');
      overlay.hidden = false;
      document.body.style.overflow = 'hidden';
      btn.setAttribute('aria-expanded', 'true');
    }
    function closeMenu(){
      drawer.classList.remove('open');
      overlay.hidden = true;
      document.body.style.overflow = '';
      btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', openMenu);
    closeBtn.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);
    window.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeMenu(); });
  })();
</script>
</body>
</html>
