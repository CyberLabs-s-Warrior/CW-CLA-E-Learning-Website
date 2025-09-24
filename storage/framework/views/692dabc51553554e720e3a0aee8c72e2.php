<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo $__env->yieldContent('title', 'E-Learning'); ?></title>

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?php echo e(asset('client/header.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('client/footer.css')); ?>">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
  
  <?php echo $__env->make('components.navbar-guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main>
  </main>

  
  <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    if (window.AOS) {
      AOS.init({ once: true, duration: 200, easing: 'ease-out' });
    }
  </script>

  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/layouts/guest.blade.php ENDPATH**/ ?>