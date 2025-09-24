<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('guest/testimoni.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="testimoni-section">
  <div class="testimoni-header">
    <h1 class="testimoni-title">Apa Kata Mereka</h1>
    <p class="testimoni-subtitle">
      Ulasan jujur dari member yang telah mengikuti kursus dan belajar bersama kami.
    </p>
  </div>

  <div class="testimoni-grid">
    <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $name = $t->user->name ?? 'Student';
        $parts = preg_split('/\s+/', trim($name));
        $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
        $hue = crc32($name) % 360;
      ?>

      <div class="testimoni-card <?php echo e($loop->index >= 6 ? 'is-hidden' : ''); ?>" data-card>
        <div class="testimoni-profile">
          <div class="avatar" style="--hue: <?php echo e($hue); ?>"><?php echo e($initials); ?></div>
          <div class="testimoni-user">
            <h3><?php echo e($name); ?></h3>
            <span class="testimoni-role">Student</span>
          </div>
        </div>
        <div class="testimoni-text">
          <p>"<?php echo e($t->content); ?>"</p>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p style="text-align:center;color:#64748b">Belum ada testimoni.</p>
    <?php endif; ?>
  </div>

  <?php if($testimonials->count() > 6): ?>
    <div class="testimoni-actions">
      <button id="btn-more" class="btn-more" type="button" aria-expanded="false">
        Lihat lainnya
      </button>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if($testimonials->count() > 6): ?>
<script>
  (function () {
    const btn = document.getElementById('btn-more');
    if (!btn) return;
    btn.addEventListener('click', function(){
      document.querySelectorAll('.testimoni-card.is-hidden').forEach(el => el.classList.remove('is-hidden'));
      this.setAttribute('aria-expanded', 'true');
      this.remove(); // hilangkan tombol setelah tampil semua
    });
  })();
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/testimoni/index.blade.php ENDPATH**/ ?>