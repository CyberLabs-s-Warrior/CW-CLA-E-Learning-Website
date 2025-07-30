<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Learnify')</title>
    <link rel="stylesheet" href="{{ asset('client/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <header data-aos="fade-down" data-aos-duration="500">
        <div class="container header-container"
            style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
            <div class="logo">e-learning</div>
            <div class="nav-center" style="display: flex; gap: 30px;">
                <a href="{{ route('home.index') }}"
                    class="{{ request()->routeIs('home.index') ? 'active' : '' }}">Home</a>
                <a href="{{ route('course.index') }}"
                    class="{{ request()->routeIs('course.index') ? 'active' : '' }}">Course</a>
                <a href="#" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
            </div>

            @guest
                <div class="nav-right">
                    <a href="{{ route('login.index') }}">Log In</a>
                </div>
            @endguest

            @auth
                <div class="nav-right" style="position: relative;">
                    <div id="profile-btn" style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                        <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="avatar" style="width: 32px; height: 32px; border-radius: 50%;" />
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-caret-down"></i>
                    </div>

                    <!-- Dropdown -->
                    <div id="dropdown-menu"
                        style="display: none; position: absolute; top: 110%; right: 0; background: #fff; border: 1px solid #ddd; padding: 8px 0; border-radius: 8px; width: 180px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; transition: all 0.2s ease-in-out;">
                        <a href="{{ route('profile.index') }}"
                            style="display: flex; align-items: center; padding: 10px 16px; text-decoration: none; color: #333; font-size: 14px;">
                            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                <path d="M4.5 20.25a8.25 8.25 0 0115 0" />
                            </svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                style="display: flex; align-items: center; padding: 10px 16px; background: none; border: none; color: #e63946; width: 100%; font-size: 14px; cursor: pointer;">
                                <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none"
                                    stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75a2.25 2.25 0 002.25-2.25V15" />
                                    <path d="M18 15l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
    </header>

    <section>
        @yield('content')
    </section>

    @include('components.footer')


    @push('scripts')
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true,
                duration: 700,
                easing: 'ease-out'
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profileBtn = document.getElementById('profile-btn');
                const dropdown = document.getElementById('dropdown-menu');

                profileBtn?.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.style.display = 'none';
                    }
                });

                const settingBtn = document.getElementById('setting-btn');
                const settingModal = document.getElementById('setting-modal');
                const settingContent = document.getElementById('setting-content');
                const cancelBtn = document.getElementById('cancel-btn');

                settingBtn?.addEventListener('click', () => {
                    settingModal.style.display = 'flex';
                    setTimeout(() => {
                        settingContent.style.transform = 'scale(1)';
                        settingContent.style.opacity = '1';
                    }, 100);
                });

                cancelBtn?.addEventListener('click', () => {
                    settingContent.style.transform = 'scale(0.9)';
                    settingContent.style.opacity = '0';
                    setTimeout(() => settingModal.style.display = 'none', 300);
                });
            });
        </script>

        <!-- Tawk.to Live Chat -->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/686c8a4a0f70621913af115a/1ivjvodsr';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endpush
    @stack('scripts')
</body>

</html>
