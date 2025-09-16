{{-- Navbar + Bottom Sheet (Soft Blue) --}}
@push('styles')
  <link rel="stylesheet" href="{{ asset('client/student-navbar.css') }}">
@endpush

<nav class="navbar navbar-student" aria-label="Student navigation">
  <div class="container">
    {{-- Left: Hamburger --}}
    <button
      id="hamburgerBtn"
      class="hamburger"
      aria-label="Open menu"
      aria-controls="studentBottomSheet"
      aria-expanded="false"
      type="button">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>

    {{-- Center: Brand --}}
    <a href="{{ route('dashboard.index') }}" class="brand">Learnify</a>

    {{-- Right: Avatar + dropdown --}}
    <div class="nav-right">
      <div class="profile-wrap">
        <button id="profileBtn" class="avatar-btn" aria-haspopup="menu" aria-expanded="false" aria-controls="profileMenu">
          @php
            $avatarUrl = auth()->user()->profile?->avatar_url
              ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode(auth()->user()->name ?? 'User');
          @endphp
          <img src="{{ $avatarUrl }}" alt="Profile" class="avatar-img">

        </button>

        <div id="profileMenu" class="profile-menu" role="menu" aria-labelledby="profileBtn">
         <li>
            <a class="bs-item {{ request()->routeIs('student.profile.*') ? 'active' : '' }}"
              href="{{ route('student.profile.show') }}">
              <span class="icon"><i class="fa-solid fa-user"></i></span> Profile
            </a>
          </li>

          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="link-like" type="submit" role="menuitem">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

{{-- Overlay (blur) --}}
<div id="bsOverlay" class="bs-overlay" hidden></div>

{{-- Bottom Sheet --}}
<aside
  id="studentBottomSheet"
  class="bottom-sheet"
  role="dialog"
  aria-modal="true"
  aria-label="Main menu"
  tabindex="-1">
  <div class="bs-header">
    <div class="bs-drag-indicator" aria-hidden="true"></div>
    <div class="bs-title">Menu</div>
    <button id="bsCloseBtn" class="bs-close" aria-label="Close menu" type="button">×</button>
  </div>

  <nav class="bs-body" aria-label="Primary">
    <ul class="bs-menu">
      <li>
        <a class="bs-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
          <span class="icon"><i class="fa-solid fa-gauge"></i></span> Dashboard
        </a>
      </li>
      <li>
        <a class="bs-item {{ request()->routeIs('course.*') || request()->routeIs('detail.*') ? 'active' : '' }}" href="{{ route('course.index') }}">
          <span class="icon"><i class="fa-solid fa-book"></i></span> Courses
        </a>
      </li>

      @isset($courseName)
      <li>
        <a class="bs-item {{ request()->routeIs('lesson.*') ? 'active' : '' }}" href="{{ route('lesson.index', ['courseName' => $courseName]) }}">
          <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span> Lessons
        </a>
      </li>
      @endisset

      <li>
        <a class="bs-item {{ request()->routeIs('payment.*') ? 'active' : '' }}" href="{{ route('payment.index') }}">
          <span class="icon"><i class="fa-solid fa-credit-card"></i></span> Payments
        </a>
      </li>


    </ul>
  </nav>
</aside>

<script>
  (function(){
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const bottomSheet  = document.getElementById('studentBottomSheet');
    const bsOverlay    = document.getElementById('bsOverlay');
    const bsCloseBtn   = document.getElementById('bsCloseBtn');

    const profileBtn   = document.getElementById('profileBtn');
    const profileMenu  = document.getElementById('profileMenu');

    let lastFocus = null;
    const focusablesSel = 'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])';

    function openSheet(){
      lastFocus = document.activeElement;
      bottomSheet.classList.add('open');
      bsOverlay.hidden = false;
      bsOverlay.classList.add('open');
      document.body.classList.add('nav-open');
      hamburgerBtn.setAttribute('aria-expanded','true');

      const focusables = bottomSheet.querySelectorAll(focusablesSel);
      focusables[0]?.focus();

      function trap(e){
        if(e.key !== 'Tab') return;
        const list = Array.from(bottomSheet.querySelectorAll(focusablesSel)).filter(el=>el.offsetParent !== null);
        const first = list[0], last = list[list.length-1];
        if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
        if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
      }
      bottomSheet.addEventListener('keydown', trap);
      bottomSheet._trap = trap;
    }

    function closeSheet(){
      bottomSheet.classList.remove('open');
      bsOverlay.classList.remove('open');
      document.body.classList.remove('nav-open');
      hamburgerBtn.setAttribute('aria-expanded','false');
      if(bottomSheet._trap) bottomSheet.removeEventListener('keydown', bottomSheet._trap);
      setTimeout(()=>{ bsOverlay.hidden = true; }, 240);
      lastFocus?.focus();
    }

    hamburgerBtn?.addEventListener('click', openSheet);
    bsCloseBtn?.addEventListener('click', closeSheet);
    bsOverlay?.addEventListener('click', closeSheet);

    window.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') {
      if (bottomSheet.classList.contains('open')) closeSheet();
      if (profileMenu.classList.contains('open')) closeProfileMenu();
    }});

    function openProfileMenu(){
      profileMenu.classList.add('open');
      profileBtn.setAttribute('aria-expanded','true');
    }
    function closeProfileMenu(){
      profileMenu.classList.remove('open');
      profileBtn.setAttribute('aria-expanded','false');
    }

    profileBtn?.addEventListener('click', (e)=>{
      e.stopPropagation();
      if(profileMenu.classList.contains('open')) closeProfileMenu();
      else openProfileMenu();
    });

    document.addEventListener('click', (e)=>{
      const inside = profileMenu.contains(e.target) || profileBtn.contains(e.target);
      if(!inside && profileMenu.classList.contains('open')) closeProfileMenu();
    });

    bottomSheet?.addEventListener('click', (e)=>{
      const target = e.target.closest('a,button');
      if (target) closeSheet();
    });
  })();
</script>
