<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'E-Learning')</title>

    {{-- CSS Global --}}
    <link rel="stylesheet" href="{{ asset('client/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <header data-aos="fade-down" data-aos-duration="500">
        <div class="container header-container">
            <div class="logo">LandPage</div>

            <nav class="nav-center">
                <a href="{{ route('home.index') }}">Home</a>
                <a href="{{ route('about.index')}}">About</a>
                <a href="{{ route('contact.index') }}">Kontak kami</a>
                <a href="{{ route('showcase.index') }}">karya member</a>

            </nav>

            <div class="nav-right">
            {{-- Tampilkan tombol Login untuk semua yang BUKAN student (termasuk guest & admin) --}}
            @guest
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
            @endguest

            @auth
                @role('student')
                <a href="{{ route('dashboard.index') }}">DASHBOARD</a>
                {{-- Logout student (kalau memang mau ditaruh di sini) --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                @else
                {{-- Auth tapi bukan student (admin/superadmin/instructor) -> tetap tampil Log in student --}}
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
                {{-- Hapus/abaikan form logout student agar tidak bentrok dengan admin --}}
                @endrole
            @endauth
            </div>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

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
