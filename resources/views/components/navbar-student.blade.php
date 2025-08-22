<style>
    
</style>
<nav class="navbar navbar-student" aria-label="Student navigation">
  <div class="container">
    {{-- Hamburger --}}
    <button
      id="hamburgerBtn"
      class="hamburger"
      aria-label="Open menu"
      aria-controls="studentDrawer"
      aria-expanded="false"
      type="button">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>

    {{-- Brand / Title --}}
    <a href="{{ route('dashboard.index') }}" class="brand">Learnify</a>

 
  </div>
</nav>

{{-- Overlay --}}
<div id="drawerOverlay" class="drawer-overlay" hidden></div>

{{-- Drawer / Slide-in kiri --}}
<aside
  id="studentDrawer"
  class="drawer"
  role="dialog"
  aria-modal="true"
  aria-label="Main menu"
  tabindex="-1">

  <div class="drawer-header">
    <span class="brand">Menu</span>
    <button id="drawerCloseBtn" class="drawer-close" aria-label="Close menu" type="button">×</button>
  </div>

  <nav class="drawer-body" aria-label="Primary">
    <ul class="menu">
      <li>
        <a class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
           href="{{ route('dashboard.index') }}">
          Dashboard
        </a>
      </li>

      <li>
        <a class="{{ request()->routeIs('course.*') || request()->routeIs('detail.*') ? 'active' : '' }}"
           href="{{ route('course.index') }}">
          Courses
        </a>
      </li>

      {{-- Lessons butuh parameter courseName; tampilkan hanya jika disediakan opsional --}}
      @isset($courseName)
        <li>
          <a class="{{ request()->routeIs('lesson.*') ? 'active' : '' }}"
             href="{{ route('lesson.index', ['courseName' => $courseName]) }}">
            Lessons
          </a>
        </li>
      @endisset

      <li>
        <a class="{{ request()->routeIs('payment.*') ? 'active' : '' }}"
           href="{{ route('payment.index') }}">
          Payments
        </a>
      </li>

      {{-- Logout di dalam drawer (POST) --}}
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="link-like" type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
</aside>
