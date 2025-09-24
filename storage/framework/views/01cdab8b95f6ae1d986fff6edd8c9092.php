<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('guest/showcase.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  
  <section class="sc-hero">
    <div class="sc-wrap">
      <h1 class="sc-hero__title">Galeri Karya Member</h1>
      <p class="sc-hero__subtitle">
        Di e-learning, kami percaya semua orang bisa memulai dari nol dan berkarya.
        Berikut adalah hasil karya member, mulai dari project kecil hingga aplikasi profesional.
      </p>
    </div>
  </section>


<section class="sc-grid-section" id="gallery">
  <div class="sc-wrap">
    <?php if($showcases->count()): ?>
      <div class="sc-grid" id="sc-grid">
        <?php $__currentLoopData = $showcases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="sc-card <?php echo e($index >= 6 ? 'hidden-card' : ''); ?>"
                   data-id="<?php echo e($s->id); ?>"
                   data-title="<?php echo e($s->title); ?>"
                   data-desc="<?php echo e($s->description); ?>"
                   data-image="<?php echo e($s->image_path ? asset('storage/'.$s->image_path) : asset('images/default.png')); ?>"
                   data-user="<?php echo e($s->user->name ?? 'Anonymous'); ?>"
                   data-date="<?php echo e($s->created_at?->format('d M Y')); ?>">
            <div class="sc-card__media">
              <img src="<?php echo e($s->image_path ? asset('storage/'.$s->image_path) : asset('images/default.png')); ?>"
                   alt="<?php echo e($s->title); ?>">
            </div>
            <div class="sc-card__body">
              <h3 class="sc-card__title"><?php echo e($s->title); ?></h3>
              <p class="sc-card__desc">
                <?php echo e(\Illuminate\Support\Str::limit(strip_tags($s->description), 120)); ?>

              </p>
            </div>
            <div class="sc-card__footer">
              <span class="sc-meta">Oleh <strong><?php echo e($s->user->name ?? 'Anonymous'); ?></strong></span>
              <span class="sc-dot">•</span>
              <time class="sc-date"><?php echo e($s->created_at?->format('d M Y')); ?></time>
            </div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      
      <?php if($showcases->count() > 6): ?>
        <div class="sc-showmore">
          <button id="show-all-btn" class="sc-btn sc-btn--primary">Lihat Semua</button>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div class="sc-empty">
        <div class="sc-empty__box">
          <div class="sc-empty__icon">📁</div>
          <div class="sc-empty__text">Belum ada karya yang ditambahkan.</div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>


<div id="sc-modal" class="sc-modal">
  <div class="sc-modal__overlay"></div>
  <div class="sc-modal__content">
    <button class="sc-modal__close" aria-label="Tutup Modal">&times;</button>
    <div class="sc-modal__img">
      <img id="modal-image" src="" alt="">
    </div>
    <div class="sc-modal__info">
      <h2 id="modal-title"></h2>
      <p id="modal-desc"></p>
      <div class="sc-modal__meta">
        <span id="modal-user"></span> • <span id="modal-date"></span>
      </div>
    </div>
  </div>
</div>



<section class="sc-band-modern">
  <div class="sc-wrap">
    <div class="sc-band__content">
      <h2 class="sc-band__title">🚀 Mulai Dari Nol, Raih Portofolio Profesional</h2>
      <p class="sc-band__subtitle">
        Banyak member kami awalnya bukan dari IT.  
        Dengan latihan, studi kasus, dan bimbingan mentor,  
        mereka berhasil membuat project profesional yang layak dipamerkan.
      </p>
    </div>
  </div>
</section>


<section class="sc-cta-modern">
  <div class="sc-wrap sc-cta__inner">
    <div class="sc-cta__text">
      <h3>Ingin Hasilkan Karya Seperti Mereka?</h3>
      <p>
        Mulai belajar dari materi dasar, kerjakan studi kasus nyata,  
        dan tampilkan karyamu di sini bersama ratusan member lainnya.
      </p>
    </div>
    <a href="<?php echo e(route('login')); ?>" class="sc-btn-modern">
      <span>✨ Daftar Sekarang</span>
    </a>
  </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.sc-card');
  const modal = document.getElementById('sc-modal');
  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDesc  = document.getElementById('modal-desc');
  const modalUser  = document.getElementById('modal-user');
  const modalDate  = document.getElementById('modal-date');
  const closeBtn   = document.querySelector('.sc-modal__close');
  const overlay    = document.querySelector('.sc-modal__overlay');

  const open = () => { modal.classList.add('show'); document.body.style.overflow = 'hidden'; }
  const close = () => { modal.classList.remove('show'); document.body.style.overflow = ''; }

  cards.forEach(card => {
    card.addEventListener('click', () => {
      modalImage.src   = card.dataset.image;
      modalTitle.textContent = card.dataset.title;
      modalDesc.textContent  = card.dataset.desc;
      modalUser.textContent  = card.dataset.user;
      modalDate.textContent  = card.dataset.date;
      open();
    });
  });

  closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', close);
  window.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const showAllBtn = document.getElementById('show-all-btn');
  if (showAllBtn) {
    showAllBtn.addEventListener('click', () => {
      document.querySelectorAll('.hidden-card').forEach(card => {
        card.style.display = 'flex';
      });
      showAllBtn.style.display = 'none';
    });
  }
});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/showcase/index.blade.php ENDPATH**/ ?>