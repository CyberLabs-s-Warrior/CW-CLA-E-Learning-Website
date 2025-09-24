

<?php $__env->startSection('title','Forum - '.$category->name); ?>

<?php
  use Illuminate\Support\Str;
?>

<?php $__env->startPush('styles'); ?>
  
  <link rel="stylesheet" href="<?php echo e(asset('guest/forum-category.css')); ?>?v=<?php echo e(filemtime(public_path('guest/forum-category.css'))); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="fc-hero" aria-labelledby="fcHeroTitle">
  <div class="fc-hero__bg" aria-hidden="true"></div>
  <div class="fc-hero__container">
    <div class="fc-hero__left">
      <a href="<?php echo e(route('forum.index')); ?>" class="fc-crumb" aria-label="Kembali ke beranda forum">
        <i class="fa-solid fa-angle-left"></i> Forum
      </a>

      <div class="fc-hero__title-wrap">
        <div class="fc-hero__avatar" aria-hidden="true"><?php echo e(Str::substr($category->name,0,1)); ?></div>
        <h1 id="fcHeroTitle" class="fc-hero__title"><?php echo e($category->name); ?></h1>
      </div>

      <?php if($category->description): ?>
        <p class="fc-hero__desc"><?php echo e($category->description); ?></p>
      <?php endif; ?>
    </div>

    <div class="fc-hero__right">
      <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('forum.thread.create')); ?>" class="btn-cta btn-cta--primary">
          <i class="fa-solid fa-pen-to-square"></i> Buat Topik
        </a>
      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-cta btn-cta--ghost">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Buat Topik
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="fc-wrap">
  <div class="fc-container">

    
    <?php if($threads->count()): ?>
      <div class="fc-threads">
        <?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a class="fc-thread reveal-up"
             href="<?php echo e(route('forum.thread.show',['id'=>$t->id,'slug'=>Str::slug($t->title)])); ?>"
             aria-label="Buka topik: <?php echo e($t->title); ?>">
            <div class="fc-thread__row">
              <div class="fc-thread__left">

                
                <?php if(!empty($t->image_url)): ?>
                  <img class="thread-thumb"
                       src="<?php echo e($t->image_url); ?>"
                       alt="Gambar topik: <?php echo e($t->title); ?>"
                       loading="lazy">
                <?php else: ?>
                  <div class="avatar" aria-hidden="true">
                    <?php echo e(isset($t->user->name) ? Str::upper(Str::substr($t->user->name,0,1)) : 'U'); ?>

                  </div>
                <?php endif; ?>

              </div>

              <div class="fc-thread__main">
                <div class="fc-thread__line">
                  <div class="badges">
                    <?php if($t->pinned_at): ?>
                      <span class="chip chip--pinned"><i class="fa-solid fa-thumbtack"></i> Pinned</span>
                    <?php endif; ?>
                    <?php if($t->is_locked): ?>
                      <span class="chip chip--locked"><i class="fa-solid fa-lock"></i> Locked</span>
                    <?php endif; ?>
                  </div>
                  <div class="fc-thread__title"><?php echo e($t->title); ?></div>
                </div>
                <div class="fc-thread__meta">
                  <span class="meta-item"><i class="fa-regular fa-user"></i> <?php echo e($t->user->name ?? 'Pengguna'); ?></span>
                  <span class="meta-dot" aria-hidden="true">•</span>
                  <time class="meta-item" title="<?php echo e($t->updated_at->format('d M Y H:i')); ?>">
                    <i class="fa-regular fa-clock"></i> <?php echo e($t->updated_at->diffForHumans()); ?>

                  </time>
                </div>
              </div>

              <div class="fc-thread__right">
                <span class="chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
              </div>
            </div>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      
      <div class="fc-pagination">
        <?php echo e($threads->links()); ?>

      </div>
    <?php else: ?>
      <div class="fc-empty reveal-up" role="status">
        <div class="empty-illus" aria-hidden="true">📂</div>
        <div class="empty-text">Belum ada topik di kategori ini.</div>
        <?php if(auth()->guard()->check()): ?>
          <a href="<?php echo e(route('forum.thread.create')); ?>" class="btn-cta btn-cta--mini btn-cta--primary mt-8">
            Mulai Diskusi
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/forum/category.blade.php ENDPATH**/ ?>