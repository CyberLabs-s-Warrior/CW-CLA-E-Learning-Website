{{-- link --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

{{-- Inter Font --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<!-- Sidebar Custom Style -->
<style>
  body {
    font-family: 'Inter', sans-serif;
  }

  .app-sidebar {
    background: linear-gradient(135deg, #1f1f2e, #2d2d44);
    color: #ffffff;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(6px);
    border-right: none !important;
    transition: all 0.3s ease;
  }

  .sidebar-brand {
    background-color: rgba(255, 255, 255, 0.04);
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
  }

  .sidebar-brand a {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .sidebar-brand a:hover {
    color: #4fc3f7;
    transform: scale(1.02);
  }

  .sidebar-wrapper {
    padding: 1rem;
  }

  .nav-sidebar .nav-link {
    background-color: transparent;
    color: #cfd8dc;
    border-radius: 8px;
    padding: 0.65rem 1rem;
    transition: all 0.25s ease;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
  }

  .nav-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    transform: translateX(3px);
  }

  .nav-sidebar .nav-link i {
    transition: transform 0.3s ease, color 0.3s ease;
  }

  .nav-sidebar .nav-link:hover i {
    transform: rotate(5deg) scale(1.1);
    color: #4fc3f7;
  }

  .nav-sidebar .nav-link.active {
    background-color: #007bff !important;
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.4);
  }

  .nav-treeview {
    display: none;
    margin-left: 0.25rem;
  }

  .nav-item.active .nav-treeview {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
  }

  .nav-treeview .nav-link {
    font-size: 0.95rem;
    color: #b0bec5;
    padding-left: 2rem;
    border-radius: 6px;
    transition: all 0.2s;
  }

  .nav-treeview .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    transform: translateX(4px);
  }

  .nav-treeview .nav-link.active {
    color: #ffffff;
    font-weight: 500;
    background-color: rgba(0, 123, 255, 0.15);
  }

  /* Collapse Icons (click only) */
  .icon-collapsed,
  .icon-expanded {
    transition: transform 0.3s ease;
    color: #aaa;
  }

  .icon-expanded {
    display: none;
  }

  .nav-item.active .icon-expanded {
    display: inline-block;
    transform: rotate(0);
    color: #fff;
  }

  .nav-item.active .icon-collapsed {
    display: none;
  }

  /* Dot Icon */
  .nav-icon.dot-toggle::before {
    content: '\f111';
    font-family: 'Font Awesome 6 Free';
    font-weight: 400;
    display: inline-block;
    width: 1.25rem;
    transition: all 0.3s ease;
    color: #999;
  }

  .nav-link.active .nav-icon.dot-toggle::before {
    content: '\f192';
    font-weight: 900;
    color: #ffffff;
  }

  /* Fade animation */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-5px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Animated icon on hover */
  .animated-icon {
    transition: transform 0.4s ease;
  }

  .nav-link:hover .animated-icon {
    transform: rotate(-5deg) scale(1.1);
    color: #8bc34a;
  }

  .nav-treeview .nav-link i {
    transition: all 0.2s ease;
  }

  .nav-treeview .nav-link:hover i {
    color: #66bb6a;
    transform: scale(1.15);
  }
</style>

<aside class="app-sidebar bg-body shadow-sm border-end" style="min-height: 100vh;" data-bs-theme="dark">
  <!-- Brand -->
  <div class="sidebar-brand p-3 border-bottom">
    <a href="{{ url('/') }}" class="text-decoration-none text-white d-flex align-items-center">
      <i class="fas fa-graduation-cap me-2 text-primary"></i>
      <span class="fw-semibold fs-5">e‑Larning</span>
    </a>
  </div>

<!-- Sidebar Menu -->
<div class="sidebar-wrapper">
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

      <li class="nav-item">
        <a href="{{ route('admin.dashboard.index') }}" class="nav-link d-flex align-items-center">
          <i class="nav-icon fas fa-tachometer-alt me-2"></i>
          <p class="m-0">Dashboard</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link d-flex align-items-center">
          <i class="nav-icon fas fa-users me-2"></i>
          <p class="m-0">Users</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.role.index') }}" class="nav-link d-flex align-items-center">
          <i class="nav-icon fas fa-user-shield me-2"></i>
          <p class="m-0">Role</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.about.index') }}" class="nav-link d-flex align-items-center">
          <i class="nav-icon fas fa-info-circle me-2"></i>
          <p class="m-0">About</p>
        </a>
      </li>

    </ul>
  </nav>
</div>
  <!-- Sidebar Menu -->
  <div class="sidebar-wrapper p-3">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column gap-1" data-lte-toggle="treeview" role="menu"
        data-accordion="false">

        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ route('admin.dashboard.index') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt me-2"></i>
            <span>Dashboard</span>
          </a>
        </li>

        {{-- User Management --}}
        @role('superadmin')
        <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'active' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users me-2"></i>
            <span>User Management</span>
            <i class="fas fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fas fa-caret-down ms-auto icon-expanded"></i>
          </a>
          <ul class="nav nav-treeview ms-3 mt-1">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index')) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i> Semua User
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'superadmin']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'superadmin'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i> Superadmin
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'admin'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i> Admin
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'student']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'student'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i> Student
              </a>
            </li>
          </ul>
        </li>
        @endrole

        {{-- About --}}
        @can('kelola_about')
        <li class="nav-item">
          <a href="{{ route('admin.about.index') }}"
            class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-info-circle me-2"></i>
            <span>About</span>
          </a>
        </li>
        @endcan

        {{-- Contact --}}
        @can('kelola_contact')
        <li class="nav-item">
          <a href="{{ route('admin.contact.index') }}"
            class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-envelope me-2"></i>
            <span>Contact</span>
          </a>
        </li>
        @endcan

        @can('kelola_course')
        {{-- Course Management --}}
          
        {{-- Course --}}
        <li class="nav-item has-treeview {{ request()->is('admin/course*') ? 'active' : '' }}">
          <a class="nav-link d-flex align-items-center" href="#courseSubmenu" data-bs-toggle="collapse"
            aria-expanded="{{ request()->is('admin/course*') ? 'true' : 'false' }}">
            <i class="fas fa-book-reader me-2 animated-icon"></i>
            <span>Course</span>
            <i class="fas fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fas fa-caret-down ms-auto icon-expanded"></i>
          </a>
          <ul id="courseSubmenu" class="collapse list-unstyled ps-3 {{ request()->is('admin/course*') ? 'show' : '' }}">
            <li>
              <a class="nav-link" href="{{ route('admin.course-categories.index') }}">
                <i class="fas fa-layer-group me-2 text-secondary"></i>
                Category
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('admin.course.index') }}">
                <i class="fas fa-list-ul me-2 text-secondary"></i>
                List
              </a>
            </li>
          </ul>
        </li>
        @endcan

      </ul>
    </nav>
  </div>
</aside>

<!-- Sidebar Toggle Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const treeviews = document.querySelectorAll('.nav-item.has-treeview > .nav-link');

    treeviews.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = this.closest('.nav-item');
        parent.classList.toggle('active');
      });
    });
  });
</script>
