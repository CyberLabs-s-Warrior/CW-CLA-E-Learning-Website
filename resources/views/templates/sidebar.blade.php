{{-- link --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!-- Brand -->
  <div class="sidebar-brand">
    <a href="{{ url('/') }}" class="brand-link">
      <span class="brand-text fw-light">e-learning</span>
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
        <a href="{{ route('admin.about.index') }}" class="nav-link d-flex align-items-center">
          <i class="nav-icon fas fa-info-circle me-2"></i>
          <p class="m-0">About</p>
        </a>
      </li>

    </ul>
  </nav>
</div>

</aside>
