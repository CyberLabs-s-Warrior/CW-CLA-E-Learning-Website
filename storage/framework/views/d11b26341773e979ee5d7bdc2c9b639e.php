
<?php
  // Ambil data kontak dari composer (AppServiceProvider)
  $email = trim($contact->email ?? '');
  $tel   = trim($contact->telepon ?? '');
  $addr  = trim($contact->alamat ?? '');
  $lat   = $contact->latitude ?? null;
  $lng   = $contact->longitude ?? null;
  $link  = trim($contact->link_maps ?? '');

  // Sosial media (dinamis)
  $fb = trim($contact->social_facebook ?? '');
  $ig = trim($contact->social_instagram ?? '');
  $tt = trim($contact->social_tiktok ?? '');
  $xx = trim($contact->social_x ?? '');
  $hasSocial = $fb || $ig || $tt || $xx;

  // Normalisasi tel untuk href
  $telHref = $tel ? preg_replace('/[^0-9+]/','',$tel) : null;

  // Buang shortlink app (tak konsisten untuk klik/embed)
  if ($link && str_contains($link, 'maps.app.goo.gl')) { $link = ''; }

  // Buat tautan Google Maps (klik biasa, bukan embed)
  $gmapsLink = null;
  if ($link && preg_match('~^https?://(www\.)?google\.[^/]+/maps/~i', $link)) {
    $gmapsLink = $link;
  }
  if (!$gmapsLink && $addr !== '') {
    $gmapsLink = 'https://www.google.com/maps/search/?api=1&query='.urlencode($addr);
  }
  if (!$gmapsLink && $lat && $lng) {
    $gmapsLink = 'https://www.google.com/maps?q='.$lat.','.$lng.'&z=16';
  }

  $appName = config('app.name', 'LandPage');
?>

<footer class="site-footer" data-aos="fade-up" data-aos-duration="500">
  <div class="footer__top-accent" aria-hidden="true"></div>

  <div class="footer-container">
    
    <div class="footer-brand">
      <a href="<?php echo e(route('home.index')); ?>" class="footer-logo" aria-label="<?php echo e($appName); ?>">
        <span class="logo-dot"></span><?php echo e($appName); ?>

      </a>
      <p class="brand-copy">Belajar lebih mudah dan fleksibel di platform kami. Materi terstruktur, proyek nyata, dan komunitas suportif.</p>

      
      <?php if($hasSocial): ?>
        <div class="social-icons" aria-label="Sosial media">
          <?php if($fb): ?>
            <a href="<?php echo e($fb); ?>" target="_blank" rel="noopener" aria-label="Facebook" class="soc">
              <i class="fab fa-facebook"></i>
            </a>
          <?php endif; ?>
          <?php if($ig): ?>
            <a href="<?php echo e($ig); ?>" target="_blank" rel="noopener" aria-label="Instagram" class="soc">
              <i class="fab fa-instagram"></i>
            </a>
          <?php endif; ?>
          <?php if($tt): ?>
            <a href="<?php echo e($tt); ?>" target="_blank" rel="noopener" aria-label="TikTok" class="soc">
              <i class="fab fa-tiktok"></i>
            </a>
          <?php endif; ?>
          <?php if($xx): ?>
            
            <a href="<?php echo e($xx); ?>" target="_blank" rel="noopener" aria-label="X (Twitter)" class="soc">
              <i class="fab fa-x-twitter"></i>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    
<nav class="footer-links" aria-label="Tautan utama">
  <div class="mnav" data-collapsible>
    <div class="mnav-head">
      <h4 class="mnav-title">Menu</h4>
      <button class="mnav-toggle" type="button" aria-expanded="false" aria-controls="footerMainMenu">
        <span class="mnav-toggle__label">Lihat Menu</span>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </button>
    </div>

    <ul id="footerMainMenu" class="mnav-list" role="list">
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('home.index')); ?>"><i class="fas fa-home"></i><span>Home</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('katalog.index')); ?>"><i class="fas fa-folder-open"></i><span>Katalog</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('testimoni.index')); ?>"><i class="fas fa-comments"></i><span>Testimoni</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('forum.index')); ?>"><i class="fas fa-message"></i><span>Forum</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('instruktur.index')); ?>"><i class="fas fa-chalkboard-teacher"></i><span>Instruktur</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('about.index')); ?>"><i class="fas fa-circle-info"></i><span>About</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('contact.index')); ?>"><i class="fas fa-envelope"></i><span>Contact</span></a>
      </li>
      <li class="mnav-item">
        <a class="mnav-link" href="<?php echo e(route('showcase.index')); ?>"><i class="fas fa-star"></i><span>Showcase</span></a>
      </li>

      <?php if(isset($extraLinks)): ?>
        <?php $__currentLoopData = $extraLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $text => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="mnav-item">
            <a class="mnav-link" href="<?php echo e($url); ?>"><i class="fas fa-link"></i><span><?php echo e($text); ?></span></a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
    </ul>
  </div>
</nav>



    
    <div class="footer-contact">
      <h4>Contact</h4>
      <ul class="contact-list">
        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
          <div class="ci-text">
            <span class="ci-label">Email</span>
            <?php if($email): ?>
              <a class="ci-value" href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a>
            <?php else: ?>
              <span class="ci-muted">-</span>
            <?php endif; ?>
          </div>
        </li>

        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
          <div class="ci-text">
            <span class="ci-label">Telepon</span>
            <?php if($tel && $telHref): ?>
              <a class="ci-value" href="tel:<?php echo e($telHref); ?>"><?php echo e($tel); ?></a>
            <?php else: ?>
              <span class="ci-muted">-</span>
            <?php endif; ?>
          </div>
        </li>

        <li class="contact-item">
          <span class="ci-icon" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></span>
          <div class="ci-text">
            <span class="ci-label">Alamat</span>
            <span class="ci-value"><?php echo e($addr ?: '-'); ?></span>
            <?php if($gmapsLink): ?>
              <a class="ci-action" href="<?php echo e($gmapsLink); ?>" target="_blank" rel="noopener">
                Buka di Google Maps <i class="fas fa-external-link-alt ml-2"></i>
              </a>
            <?php endif; ?>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($appName); ?>. All rights reserved.</p>
    <a href="#top" class="backTop" aria-label="Kembali ke atas"><i class="fas fa-arrow-up"></i></a>
  </div>
</footer>

<?php $__env->startPush('scripts'); ?>

<script>
  (function(){
    const mnav = document.querySelector('.footer-links .mnav[data-collapsible]');
    const btn  = mnav?.querySelector('.mnav-toggle');
    if(!mnav || !btn) return;

    // default: tertutup di mobile
    const setExpanded = (val) => {
      mnav.setAttribute('aria-expanded', val ? 'true' : 'false');
      btn.setAttribute('aria-expanded', val ? 'true' : 'false');
      btn.querySelector('.mnav-toggle__label').textContent = val ? 'Tutup Menu' : 'Lihat Menu';
    };
    setExpanded(false);

    btn.addEventListener('click', () => {
      const isOpen = mnav.getAttribute('aria-expanded') === 'true';
      setExpanded(!isOpen);
    });

    // jika berpindah ke desktop, paksa open
    const mq = window.matchMedia('(min-width: 721px)');
    const sync = () => { if (mq.matches) setExpanded(true); else setExpanded(false); };
    mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync);
    sync();
  })();
</script>

<script>
  (function(){
    const toggle = document.getElementById('chatToggle');
    const close  = document.getElementById('chatClose');
    const box    = document.getElementById('chatBox');

    function closeChat(){
      box?.classList.remove('active');
      toggle?.setAttribute('aria-expanded','false');
    }

    toggle?.addEventListener('click', () => {
      const active = box?.classList.toggle('active');
      toggle?.setAttribute('aria-expanded', active ? 'true' : 'false');
    });
    close?.addEventListener('click', closeChat);
  })();
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/components/footer.blade.php ENDPATH**/ ?>