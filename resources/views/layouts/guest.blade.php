<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'E-Learning')</title>

  {{-- CSS Global --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('client/header.css') }}">
  <link rel="stylesheet" href="{{ asset('client/footer.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

  @stack('styles')
</head>
<body>
  {{-- Navbar untuk pengunjung (guest) --}}
  @include('components.navbar-guest')

  <main>
  </main>

  {{-- Footer bersama --}}
  @include('components.footer')

  {{-- Scripts global --}}
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    if (window.AOS) {
      AOS.init({ once: true, duration: 200, easing: 'ease-out' });
    }
  </script>

  @stack('scripts')
</body>
</html>
