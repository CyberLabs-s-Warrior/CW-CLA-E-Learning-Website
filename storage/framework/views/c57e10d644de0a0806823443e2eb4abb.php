<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('guest/instruktur.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="instruktur-section">
  <div class="instruktur-header">
    <h1 class="instruktur-title">Instruktur Kami</h1>
    <p class="instruktur-subtitle">Kenalan dengan para mentor hebat yang siap membimbingmu.</p>
  </div>

  <?php if($profiles->isNotEmpty()): ?>
    <div id="instructorCarousel" class="splide instructor-splide" aria-label="Daftar Instruktur">
      <div class="splide__track">
        <ul class="splide__list">
          <?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $name = $p->user->name ?? 'Instruktur';
              $img  = $p->avatar_path
                        ? asset('storage/'.$p->avatar_path)
                        : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=EAF2FF&color=0D6EFD&bold=true';
            ?>

            <li class="splide__slide">
              <div class="instruktur-card">
                <div class="instruktur-img-wrapper">
                  <img src="<?php echo e($img); ?>" alt="<?php echo e($name); ?>" loading="lazy">
                </div>

                <div class="instruktur-info">
                  <h3 class="instruktur-name"><?php echo e($name); ?></h3>
                  <p class="instruktur-skill"><?php echo e($p->primary_skill); ?></p>

                  
                  <p class="instruktur-desc"><?php echo nl2br(e($p->short_bio)); ?></p>

                  <?php if($p->github_url || $p->linkedin_url): ?>
                    <div class="instruktur-social">
                      <?php if($p->github_url): ?>
                        <a class="social-btn" href="<?php echo e($p->github_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub <?php echo e($name); ?>">
                          <i class="fa-brands fa-github"></i>
                        </a>
                      <?php endif; ?>
                      <?php if($p->linkedin_url): ?>
                        <a class="social-btn" href="<?php echo e($p->linkedin_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn <?php echo e($name); ?>">
                          <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  <?php else: ?>
    <div class="empty" style="max-width:720px;margin:0 auto;">
      <div class="empty-box">
        <div class="empty-ico">👋</div>
        Belum ada instruktur yang ditampilkan.
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Splide('#instructorCarousel', {
      type: 'loop',
      rewind: true,
      perPage: 3,            // << 3 card per layar (desktop)
      perMove: 1,
      gap: '16px',
      arrows: true,
      pagination: false,
      speed: 650,
      drag: true,
      autoplay: true,        // auto-geser
      interval: 3500,        // tiap 3.5 detik
      pauseOnHover: true,    // berhenti saat hover
      pauseOnFocus: false,
      easing: 'cubic-bezier(.4,0,.2,1)',
      breakpoints: {
        1100: { perPage: 2, gap: '14px' },
        680:  { perPage: 1, gap: '12px' },
      },
      classes: {
        arrows: 'splide__arrows instruktur-arrows',
        pagination: 'splide__pagination instruktur-pagination',
      },
    }).mount();
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/instruktur/index.blade.php ENDPATH**/ ?>