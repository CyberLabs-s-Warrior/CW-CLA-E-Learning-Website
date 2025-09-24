<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="color-scheme" content="light dark">
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
  <meta name="title" content="AdminLTE v4 | Dashboard">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard">
  <meta name="keywords" content="admin dashboard, bootstrap 5, adminlte">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

  
  <?php echo $__env->yieldPushContent('styles'); ?>
  
  <?php echo $__env->yieldContent('head'); ?>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

  <div class="app-wrapper">
    <?php echo $__env->make('templates.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('templates.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="app-main">
      <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('templates.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>

  
  <?php echo $__env->yieldPushContent('scripts'); ?>
  
  <?php echo $__env->yieldContent('scripts'); ?>

  
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/templates/app.blade.php ENDPATH**/ ?>