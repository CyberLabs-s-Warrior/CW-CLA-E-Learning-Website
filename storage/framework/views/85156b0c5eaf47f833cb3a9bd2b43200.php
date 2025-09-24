<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('guest/katalog.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="katalog-section">

  
  <header class="katalog-head">
    <h1 class="katalog-title">Katalog Kursus</h1>
    <p class="katalog-subtitle">Pilih kursus favoritmu dan mulai belajar sekarang</p>
  </header>

  
  <form action="<?php echo e(route('katalog.index')); ?>" method="GET" class="katalog-toolbar" id="filterForm">
    <div class="toolbar-row">
      <div class="form-field">
        <label class="label">Kategori</label>
        <select name="category" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php if(request('category') == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->category); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      <div class="form-field">
        <label class="label">Harga</label>
        <select name="price" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="free" <?php if(request('price')==='free'): echo 'selected'; endif; ?>>Gratis</option>
          <?php $__currentLoopData = $priceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($pr->id); ?>" <?php if(request('price') == $pr->id): echo 'selected'; endif; ?>">
              $<?php echo e($pr->min_price); ?> - $<?php echo e($pr->max_price); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      <div class="form-field">
        <label class="label">Level</label>
        <select name="level" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($lv->id); ?>" <?php if(request('level') == $lv->id): echo 'selected'; endif; ?>><?php echo e($lv->level); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      <?php if(request('category') || request('price') || request('level')): ?>
        <a href="<?php echo e(route('katalog.index')); ?>" class="btn-reset">Reset</a>
      <?php endif; ?>
    </div>
  </form>

  
  <?php if($courses->count()): ?>
    <div class="katalog-grid">
      <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $rating = round($course->reviews_avg_rating ?? 0, 1);
          $priceLabel = ($course->price ?? 0) == 0
              ? 'Free'
              : '$'.number_format($course->price, 2);
          // tujuan redirect setelah login: ke detail course milik student area
          $afterLogin = route('detail.index', $course->slug);
          $loginUrl   = route('login') . '?redirect=' . urlencode($afterLogin);
        ?>

        <article class="katalog-card">
          <div class="katalog-media">
            <img src="<?php echo e(asset('storage/' . $course->img)); ?>" alt="<?php echo e($course->name); ?>">
            <?php if(($course->price ?? 0) == 0): ?>
              <span class="katalog-badge">Gratis</span>
            <?php endif; ?>
          </div>

          <div class="katalog-body">
            <h3 class="katalog-name"><?php echo e($course->name); ?></h3>

            <div class="katalog-meta">
              <span class="meta-item"><span class="meta-ico">⏱️</span><span><?php echo e($course->formatted_duration ?? '—'); ?></span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">📘</span><span><?php echo e($course->lessons_count ?? 0); ?> Modul</span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">👥</span><span><?php echo e($course->students_count ?? 0); ?></span></span>
            </div>

            
            <div class="stars" aria-label="Rating <?php echo e(number_format($rating,1)); ?> dari 5">
              <?php for($i=1;$i<=5;$i++): ?>
                <?php $full = $i <= floor($rating); ?>
                <span class="star <?php echo e($full ? 'is-full' : ''); ?>"><?php echo e($full ? '★' : '☆'); ?></span>
              <?php endfor; ?>
              <span class="stars-num"><?php echo e(number_format($rating,1)); ?></span>
            </div>

            <p class="katalog-desc">
              <?php echo e(Str::limit($course->short_description ?? $course->description ?? '-', 120)); ?>

            </p>

            <div class="katalog-row">
              <span class="katalog-level"><?php echo e($course->level->level ?? 'All Levels'); ?></span>
              <span class="katalog-price <?php echo e($priceLabel === 'Free' ? 'is-free' : ''); ?>">
                <?php echo e($priceLabel); ?>

              </span>
            </div>

            <div class="katalog-actions">
              
              <a href="<?php echo e($loginUrl); ?>" class="btn-join">Bergabung</a>
              <a href="<?php echo e($loginUrl); ?>" class="btn-outline">Detail</a>
            </div>
          </div>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="pagination">
      <?php echo e($courses->appends(request()->query())->links()); ?>

    </div>
  <?php else: ?>
    <div class="empty">
      <div class="empty-box">
        <div class="empty-ico">🔎</div>
        <p>Tidak ada kursus ditemukan sesuai filter.</p>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/katalog/index.blade.php ENDPATH**/ ?>