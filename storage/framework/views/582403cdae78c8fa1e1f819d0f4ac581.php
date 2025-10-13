<?php $__env->startSection('title','Forum'); ?>

<?php
  use Illuminate\Support\Str;
?>

<?php $__env->startPush('styles'); ?>
  
  <link rel="stylesheet" href="<?php echo e(asset('guest/forum.css')); ?>?v=<?php echo e(filemtime(public_path('guest/forum.css'))); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="forum-hero" aria-labelledby="forumHeroTitle">
  <div class="forum-hero__bg" aria-hidden="true"></div>
  <div class="forum-hero__container">
    <div class="forum-hero__text">
      <h1 id="forumHeroTitle" class="forum-hero__title">Forum Diskusi</h1>
      <p class="forum-hero__subtitle">
        Tanya, berbagi, dan bantu sesama. Topik terstruktur, pengalaman mulus.
      </p>
    </div>
    <div class="forum-hero__cta">
      <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('forum.thread.create')); ?>" class="btn-cta btn-cta--primary" aria-label="Buat topik baru">
          <i class="fa-solid fa-pen-to-square"></i> Buat Topik
        </a>
      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-cta btn-cta--ghost" aria-label="Masuk untuk membuat topik">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Buat Topik
        </a>
      <?php endif; ?>
    </div>
  </div>
  <div class="forum-hero__wave" aria-hidden="true"></div>
</section>

<section class="forum-wrap">
  <div class="forum-container">

    
    <div class="section-head">
      <h2 class="section-title">Kategori</h2>
      <div class="section-actions">
        
      </div>
    </div>

    <div class="cat-grid" role="list">
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="cat-card reveal-up" role="listitem"
           href="<?php echo e(route('forum.category', $cat->slug)); ?>"
           aria-label="Kategori <?php echo e($cat->name); ?>">
          <div class="cat-card__head">
            <span class="cat-avatar" aria-hidden="true"><?php echo e(Str::substr($cat->name,0,1)); ?></span>
            <h3 class="cat-title"><?php echo e($cat->name); ?></h3>
          </div>
          <?php if(!empty($cat->description)): ?>
            <p class="cat-desc"><?php echo e($cat->description); ?></p>
          <?php else: ?>
            <p class="cat-desc cat-desc--muted">Tidak ada deskripsi.</p>
          <?php endif; ?>
          
          <?php if(isset($cat->threads_count)): ?>
            <div class="cat-meta">
              <span class="meta-chip"><i class="fa-regular fa-message"></i> <?php echo e(number_format($cat->threads_count)); ?> topik</span>
            </div>
          <?php endif; ?>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <hr class="forum-divider" aria-hidden="true"/>

    
    <div class="section-head">
      <h2 class="section-title">Topik Terbaru</h2>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <a class="thread-item reveal-up"
         href="<?php echo e(route('forum.thread.show', ['id'=>$t->id, 'slug'=>Str::slug($t->title)])); ?>"
         aria-label="Buka topik: <?php echo e($t->title); ?>">
        <div class="thread-row">
          <div class="thread-left">

            
            <?php if(!empty($t->image_url)): ?>
              <img class="thread-thumb" src="<?php echo e($t->image_url); ?>"
                   alt="Gambar topik: <?php echo e($t->title); ?>" loading="lazy">
            <?php else: ?>
              <div class="avatar" aria-hidden="true">
                <?php echo e(isset($t->user->name) ? Str::upper(Str::substr($t->user->name,0,1)) : 'U'); ?>

              </div>
            <?php endif; ?>

          </div>

          <div class="thread-main">
            <div class="thread-line">
              <div class="thread-badges">
                <?php if($t->pinned_at): ?>
                  <span class="chip chip--pinned" aria-label="Topik dipasang">
                    <i class="fa-solid fa-thumbtack"></i> Pinned
                  </span>
                <?php endif; ?>
                <?php if($t->is_locked): ?>
                  <span class="chip chip--locked" aria-label="Topik dikunci">
                    <i class="fa-solid fa-lock"></i> Locked
                  </span>
                <?php endif; ?>
              </div>
              <div class="thread-title"><?php echo e($t->title); ?></div>
            </div>
            <div class="thread-meta">
              <span class="meta-item">
                <i class="fa-regular fa-folder-open"></i> <?php echo e($t->category->name ?? 'Umum'); ?>

              </span>
              <span class="meta-dot" aria-hidden="true">•</span>
              <span class="meta-item">
                <i class="fa-regular fa-user"></i> <?php echo e($t->user->name ?? 'Pengguna'); ?>

              </span>
            </div>
          </div>

          <div class="thread-right">
            <time class="thread-time" title="<?php echo e($t->updated_at->format('d M Y H:i')); ?>">
              <?php echo e($t->updated_at->diffForHumans()); ?>

            </time>
            <span class="thread-arrow" aria-hidden="true">
              <i class="fa-solid fa-chevron-right"></i>
            </span>
          </div>
        </div>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="forum-empty reveal-up" role="status">
        <div class="empty-illus" aria-hidden="true">💬</div>
        <div class="empty-text">Belum ada topik.</div>
        <?php if(auth()->guard()->check()): ?>
          <a href="<?php echo e(route('forum.thread.create')); ?>" class="btn-cta btn-cta--mini btn-cta--primary mt-8">Mulai Diskusi</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if(method_exists($threads, 'links')): ?>
      <div class="forum-pagination">
        <?php echo e($threads->links()); ?>

      </div>
    <?php endif; ?>

  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/forum/index.blade.php ENDPATH**/ ?>