<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $__env->yieldContent('title', 'E-Learning'); ?></title>

  
  <link rel="stylesheet" href="<?php echo e(asset('client/header.css')); ?>?v=<?php echo e(filemtime(public_path('client/header.css'))); ?>"/>
  <link rel="stylesheet" href="<?php echo e(asset('client/footer.css')); ?>?v=<?php echo e(filemtime(public_path('client/footer.css'))); ?>"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<a href="#main" class="skip-link">Lewati ke konten</a>

<header class="header" role="banner">
  <div class="header-container">
    <a href="<?php echo e(route('home.index')); ?>" class="logo" aria-label="Home">LandPage</a>

    
    <nav class="nav-center" id="desktopNav" aria-label="Primary">
      
      <a href="<?php echo e(route('home.index')); ?>"
         class="<?php echo e(request()->routeIs('home.*') ? 'is-active' : ''); ?>"
         <?php if(request()->routeIs('home.*')): ?> aria-current="page" <?php endif; ?>>Home</a>

      
      <div class="dropdown" data-priority="1">
        <button class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
          Explore <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu">
          <a href="<?php echo e(route('katalog.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('katalog.*') ? 'is-active' : ''); ?>">Katalog</a>
          <a href="<?php echo e(route('instruktur.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('instruktur.*') ? 'is-active' : ''); ?>">Instruktur</a>
        </div>
      </div>

      
      <div class="dropdown" data-priority="2">
        <button class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
          Community <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu">
          <a href="<?php echo e(route('showcase.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('showcase.*') ? 'is-active' : ''); ?>">Karya member</a>
          <a href="<?php echo e(route('testimoni.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('testimoni.*') ? 'is-active' : ''); ?>">Testimoni</a>
             <a href="<?php echo e(route('forum.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('forum.*') ? 'is-active' : ''); ?>">forum</a>
        </div>
      </div>

      
      <div class="dropdown" data-priority="3">
        <button class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
          About <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu">
          <a href="<?php echo e(route('about.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('about.*') ? 'is-active' : ''); ?>">About</a>
          <a href="<?php echo e(route('contact.index')); ?>" role="menuitem"
            class="<?php echo e(request()->routeIs('contact.*') ? 'is-active' : ''); ?>">Kontak</a>
        </div>
      </div>
    </nav>

    
    <div class="nav-right">
      <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-login">Log in</a>
      <?php else: ?>
        <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'superadmin|admin|instructor')): ?>
          <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="link-dashboard">Dashboard</a>
        <?php else: ?>
          <a href="<?php echo e(route('dashboard.index')); ?>" class="link-dashboard">Dashboard</a>
        <?php endif; ?>
      <?php endif; ?>

      
      <div class="dropdown more-wrap" id="moreWrap" hidden>
        <button class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
          More <i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu" id="moreMenu"></div>
      </div>

      <button class="hamburger" id="hamburger"
              aria-label="Buka menu"
              aria-controls="mobile-menu"
              aria-expanded="false">
        <span class="hamburger-box"><span class="hamburger-inner"></span></span>
      </button>
    </div>
  </div>

  
  <div class="mobile-overlay" id="mobile-overlay" aria-hidden="true" hidden></div>

  
  <nav class="mobile-drawer" id="mobile-menu" aria-label="Mobile"
       aria-hidden="true" aria-modal="true">
    <div class="drawer-header">
      <span class="drawer-logo">LandPage</span>
      <button class="drawer-close" id="drawer-close" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="drawer-group">
      <div class="drawer-title">Explore</div>
      <div class="drawer-links">
        <a href="<?php echo e(route('katalog.index')); ?>"><i class="fa-solid fa-list"></i> Katalog</a>
        <a href="<?php echo e(route('instruktur.index')); ?>"><i class="fa-solid fa-chalkboard-user"></i> Instruktur</a>
      </div>
    </div>

    <div class="drawer-group">
      <div class="drawer-title">Community</div>
      <div class="drawer-links">
        <a href="<?php echo e(route('showcase.index')); ?>"><i class="fa-solid fa-images"></i> Karya member</a>
        <a href="<?php echo e(route('testimoni.index')); ?>"><i class="fa-solid fa-comments"></i> Testimoni</a>
      </div>
    </div>

    <div class="drawer-group">
      <div class="drawer-title">About</div>
      <div class="drawer-links">
        <a href="<?php echo e(route('about.index')); ?>"><i class="fa-solid fa-circle-info"></i> About</a>
        <a href="<?php echo e(route('contact.index')); ?>"><i class="fa-solid fa-envelope"></i> Kontak kami</a>
      </div>
    </div>

    <div class="drawer-actions">
      <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-login block">Log in</a>
      <?php else: ?>
        <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'superadmin|admin|instructor')): ?>
          <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="btn-dashboard block">Dashboard</a>
        <?php else: ?>
          <a href="<?php echo e(route('dashboard.index')); ?>" class="btn-dashboard block">Dashboard</a>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </nav>
</header>


<main id="main">
  <?php echo $__env->yieldContent('content'); ?>
</main>

<?php if ($__env->exists('client.footer')) echo $__env->make('client.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 700, easing: 'ease-out' });

  // Mobile drawer + focus trap
  (function(){
    const btn = document.getElementById('hamburger');
    const drawer = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');
    const closeBtn = document.getElementById('drawer-close');
    let lastFocus = null;

    const focusablesSel = 'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])';

    function setOverlay(open){
      overlay.hidden = !open;
      overlay.dataset.open = open ? 'true' : 'false';
      overlay.setAttribute('aria-hidden', String(!open));
    }

    function openMenu(){
      lastFocus = document.activeElement;
      drawer.classList.add('open');
      drawer.setAttribute('aria-hidden','false');
      setOverlay(true);
      document.body.style.overflow = 'hidden';
      btn.setAttribute('aria-expanded','true');
      btn.setAttribute('aria-label','Tutup menu');
      btn.classList.add('is-open');

      const focusables = drawer.querySelectorAll(focusablesSel);
      focusables[0]?.focus();

      function trap(e){
        if(e.key !== 'Tab') return;
        const list = Array.from(drawer.querySelectorAll(focusablesSel)).filter(el=>el.offsetParent !== null);
        const first = list[0], last = list[list.length-1];
        if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
        if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
      }
      drawer.addEventListener('keydown', trap);
      drawer._trap = trap;
    }

    function closeMenu(){
      drawer.classList.remove('open');
      drawer.setAttribute('aria-hidden','true');
      setOverlay(false);
      document.body.style.overflow = '';
      btn.setAttribute('aria-expanded','false');
      btn.setAttribute('aria-label','Buka menu');
      btn.classList.remove('is-open');
      if(drawer._trap) drawer.removeEventListener('keydown', drawer._trap);
      lastFocus?.focus();
    }

    btn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);
    window.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeMenu(); });
  })();
</script>
<script>
  // Dropdown (desktop)
  (function(){
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dd=>{
      const btn = dd.querySelector('.dropdown-toggle');
      const menu = dd.querySelector('.dropdown-menu');
      if(!btn || !menu) return;
      btn.addEventListener('click', (e)=>{
        e.stopPropagation();
        const open = dd.classList.contains('open');
        document.querySelectorAll('.dropdown.open').forEach(x=>{
          x.classList.remove('open');
          x.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded','false');
        });
        if(!open){
          dd.classList.add('open');
          btn.setAttribute('aria-expanded','true');
        }
      });
    });
    document.addEventListener('click', ()=>{
      document.querySelectorAll('.dropdown.open').forEach(x=>{
        x.classList.remove('open');
        x.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded','false');
      });
    });
  })();

  // Priority+ : pindahkan item yang tidak muat ke "More"
  (function(){
    const nav = document.getElementById('desktopNav');
    const right = document.querySelector('.nav-right');
    const moreWrap = document.getElementById('moreWrap');
    const moreMenu = document.getElementById('moreMenu');

    if(!nav || !right || !moreWrap || !moreMenu) return;

    function items(){
      // Ambil semua anak nav (anchor atau .dropdown), selain yang disembunyikan
      return Array.from(nav.children).filter(el => !el.classList.contains('measure-ignore'));
    }

    function toMore(el){
      const clone = el.cloneNode(true);
      // Hilangkan chevron di dropdown
      const icon = clone.querySelector('.fa-chevron-down'); if(icon) icon.remove();
      clone.classList.remove('dropdown');
      // Buka sublink dropdown menjadi link biasa
      if (clone.querySelector('.dropdown-menu')) {
        const links = clone.querySelectorAll('.dropdown-menu a');
        const frag = document.createDocumentFragment();
        links.forEach(a=>{
          const item = document.createElement('a');
          item.href = a.getAttribute('href');
          item.textContent = a.textContent;
          item.setAttribute('role','menuitem');
          frag.appendChild(item);
        });
        moreMenu.appendChild(frag);
      } else {
        // anchor biasa
        clone.classList.remove('is-active');
        clone.removeAttribute('aria-current');
        clone.setAttribute('role','menuitem');
        moreMenu.appendChild(clone);
      }
      el.classList.add('hidden-priority');
      el.style.display = 'none';
    }

    function fromMore(el){
      el.style.display = '';
      el.classList.remove('hidden-priority');
      // hapus link terkait di moreMenu
      const labels = [];
      if (el.classList.contains('dropdown')){
        el.querySelectorAll('.dropdown-menu a').forEach(a=>labels.push(a.textContent.trim()));
      } else {
        labels.push(el.textContent.trim());
      }
      Array.from(moreMenu.querySelectorAll('a')).forEach(a=>{
        if (labels.includes(a.textContent.trim())) a.remove();
      });
    }

    function layout(){
      // Reset dulu
      items().forEach(el=>{
        if (el.classList.contains('hidden-priority')) fromMore(el);
      });
      moreWrap.hidden = true;

      const headerContainer = document.querySelector('.header-container');
      if(!headerContainer) return;

      // Berapa ruang tersisa antara nav-center & nav-right?
      const maxWidth = headerContainer.clientWidth
        - right.getBoundingClientRect().width
        - 40; // buffer

      // Hitung lebar kumulatif nav
      let width = 0;
      const navItems = items();

      // Urutkan berdasar priority (angka kecil = prioritas tinggi)
      navItems.sort((a,b)=>{
        const pa = Number(a.dataset.priority || 99);
        const pb = Number(b.dataset.priority || 99);
        return pa - pb;
      });

      for (const el of navItems){
        el.style.display = ''; // pastikan terlihat untuk pengukuran
        width += el.getBoundingClientRect().width + 24; // gap
        if (width > maxWidth){
          toMore(el);
          moreWrap.hidden = false;
        }
      }

      // Jika More kosong → sembunyikan
      if (!moreMenu.children.length) moreWrap.hidden = true;
    }

    window.addEventListener('resize', ()=> requestAnimationFrame(layout));
    window.addEventListener('load', layout);
    layout();
  })();
</script>

</body>
</html>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/components/navbar-guest.blade.php ENDPATH**/ ?>