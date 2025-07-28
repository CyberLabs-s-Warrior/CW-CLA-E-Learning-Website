{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  crossorigin="anonymous" />

<!-- Sidebar Custom Style -->
<style>
  .nav-treeview {
    display: none;
  }

  .nav-item.active .nav-treeview {
    display: block;
  }

  /* Panah toggle: hanya satu tampil sesuai kondisi */
  .icon-expanded,
  .icon-collapsed {
    transition: transform 0.3s ease;
  }

  .icon-expanded {
    display: none;
  }

  .nav-item.active .icon-expanded {
    display: inline-block;
  }

  .nav-item.active .icon-collapsed {
    display: none;
  }

  /* Dot icon toggle */
  .nav-icon.dot-toggle::before {
    content: '\f111';
    /* fa-circle */
    font-family: 'Font Awesome 6 Free';
    font-weight: 400;
    display: inline-block;
    width: 1.25rem;
    transition: all 0.3s ease;
  }

  .nav-link.active .nav-icon.dot-toggle::before {
    content: '\f192';
    /* fa-dot-circle */
    font-weight: 900;
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
  <div class="sidebar-wrapper p-3">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column gap-1" data-lte-toggle="treeview" role="menu"
        data-accordion="false">

        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ route('admin.dashboard.index') }}"
            class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard.index') ? 'active bg-primary text-white' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt me-2"></i>
            <span>Dashboard</span>
          </a>
        </li>



        {{-- User Management (only for superadmin) --}}
        @role('superadmin')
        <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'active' : '' }}">
          <a href="#" class="nav-link d-flex align-items-center">
            <i class="nav-icon fas fa-users me-2"></i>
            <span>User Management</span>
            <i class="right fas fa-angle-right ms-auto icon-collapsed"></i>
            <i class="right fas fa-angle-down ms-auto icon-expanded"></i>
          </a>
          <ul class="nav nav-treeview ms-3 mt-1">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index')) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i>
                <span>Semua User</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'superadmin']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'superadmin'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i>
                <span>Superadmin</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'admin'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i>
                <span>Admin</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index', ['role' => 'student']) }}"
                class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => 'student'])) ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i>
                <span>Student</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        {{-- About --}}
        @can('kelola_about')
      <li class="nav-item">
        <a href="{{ route('admin.about.index') }}"
        class="nav-link d-flex align-items-center {{ request()->routeIs('admin.about.*') ? 'active bg-primary text-white' : '' }}">
        <i class="nav-icon fas fa-info-circle me-2"></i>
        <span>About</span>
        </a>
      </li>
    @endcan

        {{-- Contact --}}
        @can('kelola_contact')
      <li class="nav-item">
        <a href="{{ route('admin.contact.index') }}"
        class="nav-link d-flex align-items-center {{ request()->routeIs('admin.contact.*') ? 'active bg-primary text-white' : '' }}">
        <i class="nav-icon fas fa-envelope me-2"></i>
        <span>Contact</span>
        </a>
      </li>
    @endcan

      </ul>
    </nav>
  </div>
</aside>

<!-- Sidebar Custom Script -->
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