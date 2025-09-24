
<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('client/student-navbar.css')); ?>">
<?php $__env->stopPush(); ?>

<nav class="navbar navbar-student" aria-label="Student navigation">
  <div class="container">
    
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

    
    <a href="<?php echo e(route('dashboard.index')); ?>" class="brand">e-learning</a>

    
    <div class="nav-right">
      <div class="profile-wrap">
        <button id="profileBtn" class="avatar-btn" aria-haspopup="menu" aria-expanded="false" aria-controls="profileMenu">
          <?php
            $avatarUrl = auth()->user()->profile?->avatar_url
              ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode(auth()->user()->name ?? 'User');
          ?>
          <img src="<?php echo e($avatarUrl); ?>" alt="Profile" class="avatar-img">
        </button>

        <div id="profileMenu" class="profile-menu" role="menu" aria-labelledby="profileBtn">
          <li>
            <a class="bs-item <?php echo e(request()->routeIs('student.profile.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('student.profile.show')); ?>">
              <span class="icon"><i class="fa-solid fa-user"></i></span> Profile
            </a>
          </li>

          <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST" role="none">
            <?php echo csrf_field(); ?>
            <button class="link-like" type="submit" role="menuitem">
              <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>


<div id="bsOverlay" class="bs-overlay" hidden></div>


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
        <a class="bs-item <?php echo e(request()->routeIs('dashboard.*') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard.index')); ?>">
          <span class="icon"><i class="fa-solid fa-gauge"></i></span> Dashboard
        </a>
      </li>
      <li>
        <a class="bs-item <?php echo e(request()->routeIs('course.*') || request()->routeIs('detail.*') ? 'active' : ''); ?>" href="<?php echo e(route('course.index')); ?>">
          <span class="icon"><i class="fa-solid fa-book"></i></span> Courses
        </a>
      </li>

      <?php if(isset($courseName)): ?>
      <li>
        <a class="bs-item <?php echo e(request()->routeIs('lesson.*') ? 'active' : ''); ?>" href="<?php echo e(route('lesson.index', ['courseName' => $courseName])); ?>">
          <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span> Lessons
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a class="bs-item <?php echo e(request()->routeIs('forum.*') ? 'active' : ''); ?>" href="<?php echo e(route('forum.index')); ?>">
          <span class="icon"><i class="fa-solid fa-comments"></i></span> forum
        </a>
      </li>

    </ul>
  </nav>
</aside>


<div id="confirmLogoutOverlay" class="confirm-overlay" hidden></div>
<div id="confirmLogout" class="confirm-modal" role="dialog" aria-modal="true"
     aria-labelledby="confirmLogoutTitle" aria-describedby="confirmLogoutDesc" hidden>
  <div class="confirm-card" role="document">
    <div class="confirm-title" id="confirmLogoutTitle">
      <i class="fa-solid fa-right-from-bracket"></i> Keluar?
    </div>
    <p class="confirm-desc" id="confirmLogoutDesc">
      Kamu akan keluar dari akun. Lanjutkan?
    </p>
    <div class="confirm-actions">
      <button type="button" class="btn btn-ghost" id="cancelLogoutBtn">Batal</button>
      <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
    </div>
  </div>
</div>

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
      if (confirmModal.classList.contains('open')) closeConfirm();
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

    // ====== NEW: Konfirmasi Logout ======
    const logoutForm   = document.getElementById('logoutForm');
    const logoutBtn    = logoutForm?.querySelector('button[type="submit"]');

    const confirmOverlay = document.getElementById('confirmLogoutOverlay');
    const confirmModal   = document.getElementById('confirmLogout');
    const btnCancel      = document.getElementById('cancelLogoutBtn');
    const btnConfirm     = document.getElementById('confirmLogoutBtn');

    let prevFocus = null;
    function openConfirm(){
      // tutup dropdown profile biar gak dobel layer
      closeProfileMenu();
      prevFocus = document.activeElement;
      confirmOverlay.hidden = false;
      confirmModal.hidden = false;
      // next frame biar transition jalan
      requestAnimationFrame(()=>{
        confirmOverlay.classList.add('open');
        confirmModal.classList.add('open');
        btnConfirm.focus();
      });
    }
    function closeConfirm(){
      confirmOverlay.classList.remove('open');
      confirmModal.classList.remove('open');
      setTimeout(()=>{
        confirmOverlay.hidden = true;
        confirmModal.hidden = true;
        prevFocus?.focus();
      }, 200);
    }

    // Trap tab dalam modal
    function trapKey(e){
      if(e.key !== 'Tab') return;
      const list = Array.from(confirmModal.querySelectorAll(focusablesSel));
      if(!list.length) return;
      const first = list[0], last = list[list.length-1];
      if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
      if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
    }

    confirmModal?.addEventListener('keydown', trapKey);
    confirmOverlay?.addEventListener('click', closeConfirm);
    btnCancel?.addEventListener('click', closeConfirm);
    btnConfirm?.addEventListener('click', ()=> {
      // submit beneran
      logoutForm?.submit();
    });

    logoutForm?.addEventListener('submit', (e)=>{
      e.preventDefault();
      openConfirm();
    });
  })();
</script>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/components/navbar-student.blade.php ENDPATH**/ ?>