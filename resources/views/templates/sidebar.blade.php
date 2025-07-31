{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
{{-- Inter Font --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<!-- Custom Style -->
<style>
  body {
    font-family: 'Inter', sans-serif;
  }

  .app-sidebar {
    background: linear-gradient(135deg, #1f1f2e, #2d2d44);
    color: #ffffff;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(6px);
    transition: all 0.3s ease;
    min-height: 100vh;
  }

  .sidebar-brand {
    background-color: rgba(255, 255, 255, 0.04);
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
  }

  .sidebar-brand a {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    transition: 0.3s ease;
  }

  .sidebar-brand a:hover {
    color: #4fc3f7;
    transform: scale(1.02);
  }

  .nav-sidebar .nav-link {
    color: #cfd8dc;
    border-radius: 8px;
    padding: 0.65rem 1rem;
    transition: all 0.25s ease;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .nav-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.08);
    color: #ffffff;
  }

  .nav-sidebar .nav-link.active {
    background-color: #007bff;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.4);
  }

  .nav-treeview {
    display: none;
    margin-left: 0.5rem;
  }

  .nav-item.active > .nav-treeview {
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
    background-color: rgba(0, 123, 255, 0.15);
    color: #ffffff;
    font-weight: 500;
  }

  .icon-collapsed, .icon-expanded {
    transition: 0.3s ease;
    color: #aaa;
  }

  .icon-expanded { display: none; }
  .nav-item.active .icon-expanded { display: inline; color: #fff; }
  .nav-item.active .icon-collapsed { display: none; }

  .nav-icon.dot-toggle::before {
    content: '\f111';
    font-family: 'Font Awesome 6 Free';
    font-weight: 400;
    color: #999;
  }

  .nav-link.active .nav-icon.dot-toggle::before {
    content: '\f192';
    font-weight: 900;
    color: #ffffff;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<aside class="app-sidebar" data-bs-theme="dark">
  <!-- Brand -->
  <div class="sidebar-brand p-3">
    <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center">
      <i class="fas fa-graduation-cap me-2 text-primary"></i>
      <span class="fw-semibold">e‑Larning</span>
    </a>
  </div>

  <!-- Sidebar Menu -->
  <div class="sidebar-wrapper p-3">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ route('admin.dashboard.index') }}"
             class="nav-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
          </a>
        </li>

        {{-- User Management --}}
        @role('superadmin')
        <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'active' : '' }}">
          <a href="#" class="nav-link">
            <i class="fas fa-users me-2"></i> User Management
            <i class="fas fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fas fa-caret-down ms-auto icon-expanded"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}"
                 class="nav-link {{ request()->routeIs('admin.users.index') && !request('role') ? 'active' : '' }}">
                <i class="nav-icon dot-toggle me-2"></i> Semua User
              </a>
            </li>
            @foreach(['superadmin', 'admin', 'student'] as $role)
              <li class="nav-item">
                <a href="{{ route('admin.users.index', ['role' => $role]) }}"
                   class="nav-link {{ request()->fullUrlIs(route('admin.users.index', ['role' => $role])) ? 'active' : '' }}">
                  <i class="nav-icon dot-toggle me-2"></i> {{ ucfirst($role) }}
                </a>
              </li>
            @endforeach
          </ul>
        </li>
        @endrole

        {{-- About --}}
        @can('kelola_about')
        <li class="nav-item">
          <a href="{{ route('admin.about.index') }}"
             class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
            <i class="fas fa-info-circle me-2"></i> About
          </a>
        </li>
        @endcan

        {{-- Contact --}}
        @can('kelola_contact')
        <li class="nav-item">
          <a href="{{ route('admin.contact.index') }}"
             class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="fas fa-envelope me-2"></i> Contact
          </a>
        </li>
        @endcan

        {{-- Course --}}
        @can('kelola_course')
        <li class="nav-item has-treeview {{ request()->is('admin/course*') ? 'active' : '' }}">
          <a href="#" class="nav-link">
            <i class="fas fa-book-reader me-2"></i> Course
            <i class="fas fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fas fa-caret-down ms-auto icon-expanded"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.course-categories.index') }}"
                 class="nav-link {{ request()->routeIs('admin.course-categories.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group me-2 text-secondary"></i> Category
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.course.index') }}"
                 class="nav-link {{ request()->routeIs('admin.course.index') ? 'active' : '' }}">
                <i class="fas fa-list-ul me-2 text-secondary"></i> List
              </a>
            </li>
          </ul>
        </li>
        @endcan

      </ul>
    </nav>
  </div>
</aside>

<!-- Treeview Toggle Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-item.has-treeview > .nav-link').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const parent = link.closest('.nav-item');
        parent.classList.toggle('active');
      });
    });
  });
</script>
