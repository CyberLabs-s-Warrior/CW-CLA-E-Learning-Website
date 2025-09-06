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
    padding: 0.55rem 1rem;
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
    font-weight: 400;
    box-shadow: 0 2px 2px rgba(0, 123, 255, 0.4);
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

  .icon-collapsed,
  .icon-expanded {
    transition: 0.3s ease;
    color: #aaa;
  }

  .icon-expanded {
    display: none;
  }

  .nav-item.active .icon-expanded {
    display: inline;
    color: #fff;
  }

  .nav-item.active .icon-collapsed {
    display: none;
  }

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
    to   { opacity: 1; transform: translateY(0); }
  }
</style>

<aside class="app-sidebar" data-bs-theme="dark">
  <div class="sidebar-brand p-3">
    <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-graduation-cap me-2 text-primary"></i>
      <span class="fw-semibold">e-Learning</span>
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
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
          </a>
        </li>

        {{-- User Management --}}
        @role('superadmin')
        <li class="nav-item">
          <a href="{{ route('admin.users.index') }}"
             class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users me-2"></i> User Management
          </a>
        </li>
        @endrole

{{-- Landing Page (CRUD) --}}
@canany(['kelola_about','kelola_contact','kelola_showcase','kelola_testimoni'])
<li class="nav-item has-treeview
    {{ request()->routeIs('admin.about.*')
    || request()->routeIs('admin.contact.*')
    || request()->routeIs('admin.showcase.*')   /* perbaiki dari showcases -> showcase */
    || request()->routeIs('admin.testimoni.*')  /* perbaiki active check */
      ? 'active' : '' }}">
  <a href="#" class="nav-link" aria-expanded="{{ request()->routeIs('admin.about.*') || request()->routeIs('admin.contact.*') || request()->routeIs('admin.showcase.*') || request()->routeIs('admin.testimoni.*') ? 'true' : 'false' }}">
    <i class="fa-solid fa-layer-group me-2"></i>
    Landing Page
    <i class="fa-solid fa-caret-right ms-auto icon-collapsed"></i>
    <i class="fa-solid fa-caret-down ms-auto icon-expanded"></i>
  </a>

  <ul class="nav nav-treeview">
    @can('kelola_about')
    <li class="nav-item">
      <a href="{{ route('admin.about.index') }}"
         class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
        <i class="fa-solid fa-circle-info me-2 text-secondary"></i> About
      </a>
    </li>
    @endcan

    @can('kelola_contact')
    <li class="nav-item">
      <a href="{{ route('admin.contact.index') }}"
         class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
        <i class="fa-solid fa-envelope me-2 text-secondary"></i> Contact
      </a>
    </li>
    @endcan

    @can('kelola_showcase')
    <li class="nav-item">
      <a href="{{ route('admin.showcase.index') }}"
         class="nav-link {{ request()->routeIs('admin.showcase.*') ? 'active' : '' }}">
        <i class="fa-solid fa-lightbulb me-2 text-secondary"></i> Showcase
      </a>
    </li>
    @endcan

    @can('kelola_testimoni')
    <li class="nav-item">
      <a href="{{ route('admin.testimoni.index') }}"
         class="nav-link {{ request()->routeIs('admin.testimoni.*') ? 'active' : '' }}">
        <i class="fa-solid fa-comment me-2 text-secondary"></i> Testimoni
      </a>
    </li>
    @endcan
  </ul>
</li>
@endcanany


        {{-- Course (treeview) --}}
        @can('kelola_course')
        <li class="nav-item has-treeview
            {{ request()->routeIs('admin.course.*')
            || request()->routeIs('admin.course-categories.*')
            || request()->routeIs('admin.detail.*')
            || request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-book-open-reader me-2"></i> Course
            <i class="fa-solid fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fa-solid fa-caret-down ms-auto icon-expanded"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.course-categories.index') }}"
                 class="nav-link {{ request()->routeIs('admin.course-categories.index') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group me-2 text-secondary"></i> Category
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.course.index') }}"
                 class="nav-link {{ request()->routeIs('admin.course.index') ? 'active' : '' }}">
                <i class="fa-solid fa-list-ul me-2 text-secondary"></i> List
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.detail.index') }}"
                 class="nav-link {{ request()->routeIs('admin.detail.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines me-2 text-secondary"></i> Detail Course
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.lessons.index') }}"
                 class="nav-link {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user me-2 text-secondary"></i> Lessons
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
