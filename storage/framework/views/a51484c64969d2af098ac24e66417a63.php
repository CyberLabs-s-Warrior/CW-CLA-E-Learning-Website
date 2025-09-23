
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  crossorigin="anonymous" />

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

    .nav-item.active>.nav-treeview {
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
    from {
      opacity: 0;
      transform: translateY(-5px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  /* === PATCH: sidebar scroll mandiri, tanpa ubah tampilan === */
.app-sidebar{
  height: 100vh;            /* kunci setinggi viewport */
  display: flex;            /* jadikan kolom */
  flex-direction: column;
  overflow: hidden;         /* scroll terjadi di child, bukan di sini */
}

.sidebar-brand{
  flex: 0 0 auto;           /* header tetap di atas, tidak ikut scroll */
}

.sidebar-wrapper{
  flex: 1 1 auto;           /* isi mengambil sisa ruang */
  min-height: 0;            /* penting agar overflow bisa bekerja di elemen flex */
  overflow-y: auto;         /* aktifkan scroll vertikal untuk isi */
  -webkit-overflow-scrolling: touch; /* smooth di iOS */
  overscroll-behavior: contain;      /* cegah scroll “tembus” ke body */
}

</style>

<aside class="app-sidebar" data-bs-theme="dark">
  <div class="sidebar-brand p-3">
    <a href="<?php echo e(url('/')); ?>" class="text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-graduation-cap me-2 text-primary"></i>
      <span class="fw-semibold">e-Learning</span>
    </a>
  </div>

  <!-- Sidebar Menu -->
  <div class="sidebar-wrapper p-3">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="<?php echo e(route('admin.dashboard.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.dashboard.index') ? 'active' : ''); ?>">
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
          </a>
        </li>

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'superadmin')): ?>
        <li class="nav-item">
          <a href="<?php echo e(route('admin.users.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="fa-solid fa-users me-2"></i> User Management
          </a>
        </li>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['kelola_about', 'kelola_contact', 'kelola_showcase', 'kelola_testimoni'])): ?>
              <li class="nav-item has-treeview
              <?php echo e(request()->routeIs('admin.about.*')
          || request()->routeIs('admin.contact.*')
          || request()->routeIs('admin.showcase.*')   /* perbaiki dari showcases -> showcase */
          || request()->routeIs('admin.testimoni.*')  /* perbaiki active check */
          ? 'active' : ''); ?>">
                <a href="#" class="nav-link"
                  aria-expanded="<?php echo e(request()->routeIs('admin.about.*') || request()->routeIs('admin.contact.*') || request()->routeIs('admin.showcase.*') || request()->routeIs('admin.testimoni.*') ? 'true' : 'false'); ?>">
                  <i class="fa-solid fa-layer-group me-2"></i>
                  Landing Page
                  <i class="fa-solid fa-caret-right ms-auto icon-collapsed"></i>
                  <i class="fa-solid fa-caret-down ms-auto icon-expanded"></i>
                </a>

                <ul class="nav nav-treeview">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_about')): ?>
                    <li class="nav-item">
                      <a href="<?php echo e(route('admin.about.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.about.*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-circle-info me-2 text-secondary"></i> About
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_contact')): ?>
                    <li class="nav-item">
                      <a href="<?php echo e(route('admin.contact.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.contact.*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-envelope me-2 text-secondary"></i> Contact
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_showcase')): ?>
                    <li class="nav-item">
                      <a href="<?php echo e(route('admin.showcase.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.showcase.*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-lightbulb me-2 text-secondary"></i> Showcase
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_testimoni')): ?>
                    <li class="nav-item">
                      <a href="<?php echo e(route('admin.testimoni.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.testimoni.*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-comment me-2 text-secondary"></i> Testimoni
                      </a>
                    </li>
                  <?php endif; ?>

                  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_instructor')): ?>
                    <li class="nav-item">
                      <a href="<?php echo e(route('admin.instruktur.index')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.instruktur.*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-chalkboard-user me-2"></i> Instructors
                      </a>
                    </li>
                  <?php endif; ?>

                </ul>
              </li>
        <?php endif; ?>


        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_course')): ?>
              <li class="nav-item has-treeview
                  <?php echo e(request()->routeIs('admin.course.*')
          || request()->routeIs('admin.course-categories.*')
          || request()->routeIs('admin.detail.*')
          || request()->routeIs('admin.lessons.*') ? 'active' : ''); ?>">
                <a href="#" class="nav-link">
                  <i class="fa-solid fa-book-open-reader me-2"></i> Course
                  <i class="fa-solid fa-caret-right ms-auto icon-collapsed"></i>
                  <i class="fa-solid fa-caret-down ms-auto icon-expanded"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo e(route('admin.course-categories.index')); ?>"
                      class="nav-link <?php echo e(request()->routeIs('admin.course-categories.index') ? 'active' : ''); ?>">
                      <i class="fa-solid fa-layer-group me-2 text-secondary"></i> Category
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo e(route('admin.course.index')); ?>"
                      class="nav-link <?php echo e(request()->routeIs('admin.course.index') ? 'active' : ''); ?>">
                      <i class="fa-solid fa-list-ul me-2 text-secondary"></i> List
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo e(route('admin.lessons.index')); ?>"
                      class="nav-link <?php echo e(request()->routeIs('admin.lessons.*') ? 'active' : ''); ?>">
                      <i class="fa-solid fa-chalkboard-user me-2 text-secondary"></i> Lessons
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo e(route('admin.detail.index')); ?>"
                      class="nav-link <?php echo e(request()->routeIs('admin.detail.*') ? 'active' : ''); ?>">
                      <i class="fa-solid fa-file-lines me-2 text-secondary"></i> Detail Course
                    </a>
                  </li>
                </ul>
              </li>
        <?php endif; ?>

      
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola_forum')): ?>
        <li class="nav-item has-treeview <?php echo e(request()->routeIs('admin.forum.*') ? 'active' : ''); ?>">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-comments me-2"></i> Forum
            <i class="fa-solid fa-caret-right ms-auto icon-collapsed"></i>
            <i class="fa-solid fa-caret-down ms-auto icon-expanded"></i>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo e(route('admin.forum.categories.index')); ?>"
                class="nav-link <?php echo e(request()->routeIs('admin.forum.categories.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-folder-tree me-2 text-secondary"></i> Kategori
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('admin.forum.threads.index')); ?>"
                class="nav-link <?php echo e(request()->routeIs('admin.forum.threads.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-comments me-2 text-secondary"></i> Threads
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('admin.forum.posts.index')); ?>"
                class="nav-link <?php echo e(request()->routeIs('admin.forum.posts.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-reply me-2 text-secondary"></i> Posts
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('forum.index')); ?>" class="nav-link" target="_blank">
                <i class="fa-solid fa-up-right-from-square me-2 text-secondary"></i> Buka Forum Publik
              </a>
            </li>
          </ul>
        </li>
      <?php endif; ?>


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
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/templates/sidebar.blade.php ENDPATH**/ ?>