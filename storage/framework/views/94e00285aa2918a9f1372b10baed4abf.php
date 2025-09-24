<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('guest/about.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php
  // Helper untuk ambil item pertama dari section tertentu
  $getFirst = function($key) use ($contents) {
      return $contents->has($key) && $contents->get($key)->isNotEmpty()
          ? $contents->get($key)->first()
          : null;
  };

  // Data HERO (opsional dari DB): section = hero_title (title), hero_image (image)
  $heroTitleItem = $getFirst('hero_title');
  $heroImageItem = $getFirst('hero_image');

  $heroTitle = $heroTitleItem?->title ?? 'ABOUT US';

  // Resolusi hero image aman (pakai placeholder jika kosong)
  $heroImagePath = $heroImageItem?->image ? 'storage/'.$heroImageItem->image : 'image/banner.jpg';
  $heroImage = asset($heroImagePath);
?>

<!-- ===== HERO ===== -->
<section class="about-hero" style="--hero-bg:url('<?php echo e($heroImage); ?>')">
  <div class="about-hero__overlay">
    <h1 class="about-hero__title"><?php echo e($heroTitle); ?></h1>
  </div>
</section>

<!-- ===== INTRO (opsional) | section: about_intro ===== -->
<?php
  $intro = $getFirst('about_intro');
?>
<?php if($intro): ?>
<section class="about-intro container">
  <div class="about-intro__text">
    <h2 class="section-title"><?php echo e($intro->title ?? 'Tentang E-Learning Kami'); ?></h2>
    <?php if(!empty($intro->description)): ?>
      <div class="rich-text"><?php echo $intro->description; ?></div>
    <?php endif; ?>
  </div>
  <div class="about-intro__media">
    <?php
      $introImg = $intro->image ? asset('storage/'.$intro->image) : asset('image/placeholder-landscape.jpg');
    ?>
    <div class="media">
      <img loading="lazy" src="<?php echo e($introImg); ?>" alt="<?php echo e($intro->title ?? 'Tentang Kami'); ?>">
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== VISI & MISI (opsional) | section: visi, misi ===== -->
<?php
  $visi = $getFirst('visi');
  $misi = $getFirst('misi');
?>
<?php if($visi || $misi): ?>
<section class="vm container">
  <?php if($visi): ?>
    <div class="vm__row">
      <div class="vm__media">
        <div class="media media--blob">
          <img loading="lazy" src="<?php echo e(asset('image/laptop1.png')); ?>" alt="Visi">
        </div>
      </div>
      <div class="vm__content">
        <h3 class="section-subtitle">VISI</h3>
        <?php if(!empty($visi->description)): ?> <div class="rich-text"><?php echo $visi->description; ?></div> <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if($misi): ?>
    <div class="vm__row vm__row--reverse">
      <div class="vm__media">
        <div class="media media--blob">
          <img loading="lazy" src="<?php echo e(asset('image/laptop2.png')); ?>" alt="Misi">
        </div>
      </div>
      <div class="vm__content">
        <h3 class="section-subtitle">MISI</h3>
        <?php if(!empty($misi->description)): ?> <div class="rich-text"><?php echo $misi->description; ?></div> <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php endif; ?>

<!-- ===== SEJARAH (opsional, bisa banyak item) | section: sejarah ===== -->
<?php if($contents->has('sejarah') && $contents->get('sejarah')->isNotEmpty()): ?>
<section class="history">
  <div class="container">
    <h3 class="section-title center">Sejarah Singkat</h3>
    <div class="cards cards--auto">
      <?php $__currentLoopData = $contents->get('sejarah'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="card" data-animate>
          <div class="card__media">
            <?php
              $img = !empty($row->image) ? asset('storage/'.$row->image) : asset('image/placeholder-landscape.jpg');
            ?>
            <div class="media media--ratio">
              <img loading="lazy" src="<?php echo e($img); ?>" alt="<?php echo e($row->title ?? 'Sejarah'); ?>">
            </div>
          </div>
          <div class="card__content">
            <?php if(!empty($row->title)): ?>
              <h4 class="card__title"><?php echo e($row->title); ?></h4>
            <?php endif; ?>
            <?php if(!empty($row->description)): ?>
              <div class="card__body rich-text"><?php echo $row->description; ?></div>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== GENERIC RENDER untuk SEMUA SECTION lain (otomatis) ===== -->
<?php
  $reserved = collect(['hero_title','hero_image','about_intro','visi','misi','sejarah']);
?>

<?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if($reserved->contains($section)) continue; ?>

  <?php
    // Judul section rapi
    $sectionTitle = \Illuminate\Support\Str::of($section)->replace('_',' ')->title();
  ?>

  <section class="generic">
    <div class="container">
      <h3 class="section-title center"><?php echo e($sectionTitle); ?></h3>

      <?php if($items->count() > 1): ?>
        <!-- Grid bila item banyak -->
        <div class="cards cards--auto">
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $img = !empty($item->image) ? asset('storage/'.$item->image) : asset('image/placeholder-landscape.jpg');
            ?>
            <article class="card" data-animate>
              <div class="card__media">
                <div class="media media--ratio">
                  <img loading="lazy" src="<?php echo e($img); ?>" alt="<?php echo e($item->title ?? $sectionTitle); ?>">
                </div>
              </div>
              <div class="card__content">
                <?php if(!empty($item->title)): ?>
                  <h4 class="card__title"><?php echo e($item->title); ?></h4>
                <?php endif; ?>
                <?php if(!empty($item->description)): ?>
                  <div class="card__body rich-text"><?php echo $item->description; ?></div>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php else: ?>
        <!-- Satu item: layout lebar -->
        <?php
          $item = $items->first();
          $img = !empty($item->image) ? asset('storage/'.$item->image) : asset('image/placeholder-landscape.jpg');
        ?>
        <article class="card card--wide" data-animate>
          <div class="card__media">
            <div class="media media--ratio">
              <img loading="lazy" src="<?php echo e($img); ?>" alt="<?php echo e($item->title ?? $sectionTitle); ?>">
            </div>
          </div>
          <div class="card__content">
            <?php if(!empty($item->title)): ?>
              <h4 class="card__title"><?php echo e($item->title); ?></h4>
            <?php endif; ?>
            <?php if(!empty($item->description)): ?>
              <div class="card__body rich-text"><?php echo $item->description; ?></div>
            <?php endif; ?>
          </div>
        </article>
      <?php endif; ?>
    </div>
  </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- ===== EMPTY STATE ===== -->
<?php if($contents->isEmpty()): ?>
<section class="empty">
  <div class="container">
    <div class="empty__box">
      <h3>Tidak ada konten About.</h3>
      <p>Silakan tambahkan konten dari panel Admin → About.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/about/index.blade.php ENDPATH**/ ?>