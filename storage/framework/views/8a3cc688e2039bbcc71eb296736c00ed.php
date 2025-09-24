<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $__env->yieldContent('title', 'Dashboard • Learnify'); ?></title>

  
  <link rel="stylesheet" href="<?php echo e(asset('client/student-navbar.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="<?php echo e(asset('client/footer.css')); ?>">
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

  
  <?php echo $__env->make('components.navbar-student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


  <main class="page-container">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php echo $__env->yieldPushContent('scripts'); ?>
  <script>
    (function () {
      const body = document.body;
      const drawer = document.getElementById('studentDrawer');
      const overlay = document.getElementById('drawerOverlay');
      const btnOpen = document.getElementById('hamburgerBtn');
      const btnClose = document.getElementById('drawerCloseBtn');

      if (!drawer || !overlay || !btnOpen || !btnClose) return;

      function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
        overlay.hidden = false;
        body.classList.add('nav-open');
        btnOpen.setAttribute('aria-expanded', 'true');
        // Fokus elemen pertama di drawer
        const first = drawer.querySelector('a, button');
        first && first.focus();
      }

      function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        body.classList.remove('nav-open');
        btnOpen.setAttribute('aria-expanded', 'false');
        // Sembunyikan overlay setelah transisi
        setTimeout(() => { overlay.hidden = true; }, 220);
        // Kembalikan fokus ke tombol
        btnOpen.focus();
      }

      btnOpen.addEventListener('click', openDrawer);
      btnClose.addEventListener('click', closeDrawer);
      overlay.addEventListener('click', closeDrawer);

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer.classList.contains('open')) {
          e.preventDefault();
          closeDrawer();
        }
      });
    })();

  </script>

  <?php echo $__env->yieldPushContent('scripts'); ?>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      duration: 700,
      easing: 'ease-out'
    });
  </script>


</body>

</html><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/layouts/student.blade.php ENDPATH**/ ?>