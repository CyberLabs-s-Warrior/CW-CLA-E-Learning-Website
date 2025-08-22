<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'Dashboard • Learnify')</title>

  {{-- CSS global student --}}
  <link rel="stylesheet" href="{{ asset('client/student-navbar.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="{{ asset('client/header.css') }}">
<link rel="stylesheet" href="{{ asset('client/footer.css') }}">
@stack('styles')

  @stack('styles')
</head>
<body>

  {{-- Default: tanpa courseName --}}
  @include('components.navbar-student')

 
  <main class="page-container">
    @yield('content')
  </main>

  @include('components.footer')

  @stack('scripts')
 <script>
    (function () {
  const body = document.body;
  const drawer = document.getElementById('studentDrawer');
  const overlay = document.getElementById('drawerOverlay');
  const btnOpen = document.getElementById('hamburgerBtn');
  const btnClose = document.getElementById('drawerCloseBtn');

  if (!drawer || !overlay || !btnOpen || !btnClose) return;

  function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('open');
    overlay.hidden = false;
    body.classList.add('nav-open');
    btnOpen.setAttribute('aria-expanded', 'true');
    // Fokus elemen pertama di drawer
    const first = drawer.querySelector('a, button');
    first && first.focus();
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('open');
    body.classList.remove('nav-open');
    btnOpen.setAttribute('aria-expanded', 'false');
    // Sembunyikan overlay setelah transisi
    setTimeout(() => { overlay.hidden = true; }, 220);
    // Kembalikan fokus ke tombol
    btnOpen.focus();
  }

  btnOpen.addEventListener('click', openDrawer);
  btnClose.addEventListener('click', closeDrawer);
  overlay.addEventListener('click', closeDrawer);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('open')) {
      e.preventDefault();
      closeDrawer();
    }
  });
})();

 </script>

     @stack('scripts')
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out'
        });
    </script>

 
</body>
</html>
