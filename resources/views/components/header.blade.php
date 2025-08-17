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
            </nav>

            <div class="nav-right">
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
                @auth
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
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

    <x-footer />
</body>
</html>
