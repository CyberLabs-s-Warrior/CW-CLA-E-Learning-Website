<!-- CSS -->
<link rel="preload" href="{{ asset('dist/css/adminlte.css') }}" as="style">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
.dropdown-item.logout-button {
  color: #dc3545 !important;               
  font-weight: 500;
  border-left: 4px solid #dc3545;          
  transition: background-color 0.3s ease;
  padding-left: 1rem !important;
}

.dropdown-item.logout-button:hover {
  background-color: #f8d7da !important;     
  color: #a71d2a !important;
}

.dropdown-item.logout-button i {
  color: #dc3545 !important;
}


</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Navbar -->
<nav class="app-header navbar navbar-expand bg-body border-bottom shadow-sm">
  <div class="container-fluid">

    <!-- Sidebar Toggle -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list fs-4"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto align-items-center">

      <li class="nav-item me-2">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen fs-5"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit fs-5 d-none"></i>
        </a>
      </li>

      <li class="nav-item dropdown me-2">
        <a class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6c757d&color=fff&size=32"
               alt="User Avatar" class="rounded-circle me-2" width="32" height="32">
          <span class="fw-semibold">{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" style="min-width: 200px;">
          <li><hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.show') }}">
              <i class="bi bi-person-circle"></i> Profile
            </a>

          </li>
          <li>
            <a class="dropdown-item logout-button d-flex align-items-center gap-2" href="#" id="logout-link">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        </ul>
      </li>

      <!-- Logout Form (Hidden) -->
      <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
        @csrf
      </form>
    </ul>
  </div>
</nav>

<!-- Logout SweetAlert Script -->
<script>
  document.getElementById('logout-link').addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Keluar dari sistem?',
      text: 'Kamu akan logout dan kembali ke halaman login.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  });
</script>
