<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('guest/home.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('client/footer.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Learnify - Home'); ?>

<?php $__env->startSection('content'); ?>
  
  <main class="hero hero--accent">
    <div class="container hero-content">
      <div class="text-content">
        <h1>
          Learn and grow <br />
          your skills
        </h1>
        <p>
          Take your learning to the next level. Join our platform and explore a variety of online courses.
        </p>
        <a href="<?php echo e(route('katalog.index')); ?>" class="btn">Get Started</a>

        <div class="hero-trust">
          <span>⭐ 4.8/5 Reviews</span>
          <span>👥 120K+ Students</span>
          <span>🧑‍🏫 50+ Mentors</span>
        </div>
      </div>

      <div class="image">
        <img
          src="<?php echo e(asset('image/iconpage.png')); ?>"
          onerror="this.src='https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1200&auto=format&fit=crop'"
          alt="Hero Image" class="main-img" />
      </div>
    </div>

    <div class="stats-bar">
      <div class="container stats">
        <div class="stat"><span class="num">120K+</span><span class="lbl">Students</span></div>
        <div class="stat"><span class="num">350+</span><span class="lbl">Courses</span></div>
        <div class="stat"><span class="num">50+</span><span class="lbl">Mentors</span></div>
        <div class="stat"><span class="num">900+</span><span class="lbl">Lessons</span></div>
      </div>
    </div>
  </main>


<section class="why-section soft-1">
  <div class="container why-split">
    <div class="why-text">
      <span class="why-eyebrow">Learning Path</span>
      <h2 class="section-title section-title--left">Belajar Terarah, Nggak Bingung Mulai</h2>
      <p class="section-sub left">
        Pilih jalur (Web, Mobile, Data/AI) → ikuti modul berurutan → praktik proyek mini. Semua dirancang bertahap.
      </p>

      <ol class="why-steps" role="list">
        <li class="step">
          <span class="step__num" aria-hidden="true">01</span>
          <div class="step__txt">
            <div class="step__title">Roadmap jelas</div>
            <div class="step__desc">Materi dari pondasi → intermediate → advanced dengan target skill spesifik.</div>
          </div>
        </li>
        <li class="step">
          <span class="step__num" aria-hidden="true">02</span>
          <div class="step__txt">
            <div class="step__title">Modul singkat & fokus</div>
            <div class="step__desc">Video padat + kuis cepat supaya ritme belajar tetap konsisten.</div>
          </div>
        </li>
        <li class="step">
          <span class="step__num" aria-hidden="true">03</span>
          <div class="step__txt">
            <div class="step__title">Proyek mini</div>
            <div class="step__desc">Langsung praktik; hasilnya bisa kamu simpan ke portfolio.</div>
          </div>
        </li>
      </ol>

      <div class="chips mt-12">
        <a href="<?php echo e(route('katalog.index', ['category' => 'web'])); ?>" class="chip chip--link">
          <i class="fa-solid fa-code"></i> Web Development
        </a>
        <a href="<?php echo e(route('katalog.index', ['category' => 'aplikasi'])); ?>" class="chip chip--link">
          <i class="fa-solid fa-mobile-screen"></i> Mobile
        </a>
        <a href="<?php echo e(route('katalog.index')); ?>" class="chip chip--link">
          <i class="fa-solid fa-brain"></i> Data &amp; AI
        </a>
      </div>

      <div class="why-metrics">
        <div class="metric">
          <div class="metric__num">120+</div>
          <div class="metric__lbl">Modul terstruktur</div>
        </div>
        <div class="metric">
          <div class="metric__num">30+</div>
          <div class="metric__lbl">Proyek mini</div>
        </div>
        <div class="metric">
          <div class="metric__num">97%</div>
          <div class="metric__lbl">Progress terselesaikan</div>
        </div>
      </div>
    </div>

    <div class="why-media">
      <div class="media-card">
        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1200&auto=format&fit=crop" alt="Learning Path">
        <div class="media-hint">
          <i class="fa-solid fa-route"></i> Jalur belajar bertahap
        </div>
      </div>
    </div>
  </div>
</section>


<section class="why-section soft-2">
  <div class="container why-split reverse">
    <div class="why-media">
      <div class="media-card tilt">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop" alt="Project Based">
        <div class="media-hint">
          <i class="fa-solid fa-briefcase"></i> Proyek ala industri
        </div>
      </div>
    </div>

    <div class="why-text">
      <span class="why-eyebrow">Industry Ready</span>
      <h2 class="section-title section-title--left">Relevan dengan Industri &amp; Project-Based</h2>
      <p class="section-sub left">
        Materi mengikuti kebutuhan pasar. Output-mu: portfolio yang bisa dipamerkan di CV/LinkedIn.
      </p>

      <div class="pill-grid pill-grid--cards">
        <div class="pill-card">
          <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
          <div>
            <div class="pill-title">Best-practice coding</div>
            <div class="pill-desc">Pattern yang dipakai di perusahaan.</div>
          </div>
        </div>
        <div class="pill-card">
          <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
          <div>
            <div class="pill-title">Studi kasus nyata</div>
            <div class="pill-desc">Simulasi requirement ala real project.</div>
          </div>
        </div>
        <div class="pill-card">
          <i class="fa-solid fa-list-check" aria-hidden="true"></i>
          <div>
            <div class="pill-title">Checklist skill</div>
            <div class="pill-desc">Pantau skill gap dan progresmu.</div>
          </div>
        </div>
        <div class="pill-card">
          <i class="fa-solid fa-file-code" aria-hidden="true"></i>
          <div>
            <div class="pill-title">Template proyek</div>
            <div class="pill-desc">Mulai cepat tanpa setup ribet.</div>
          </div>
        </div>
      </div>

      <div class="mini-note">
        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
        Semua proyek bisa di-export jadi repositori publik untuk portfolio.
      </div>
    </div>
  </div>
</section>


<section class="why-section soft-3">
  <div class="container why-split">
    <div class="why-text">
      <span class="why-eyebrow">Mentoring &amp; Community</span>
      <h2 class="section-title section-title--left">Ada yang Bimbing &amp; Komunitas yang Aktif</h2>
      <p class="section-sub left">
        Belajar bareng, dapat feedback mentor, dan akses sumber karier seperti resume review &amp; mock interview.
      </p>

      <ul class="why-bullets">
        <li>
          <span class="icon-circle"><i class="fa-regular fa-comments"></i></span>
          Forum/Group diskusi &amp; live Q&amp;A.
        </li>
        <li>
          <span class="icon-circle"><i class="fa-solid fa-clipboard-check"></i></span>
          Review tugas/portfolio setiap pekan.
        </li>
        <li>
          <span class="icon-circle"><i class="fa-solid fa-user-tie"></i></span>
          Tips karier, job board internal, dan mock interview.
        </li>
      </ul>

      <div class="cta-inline">
        <a href="<?php echo e(route('forum.index')); ?>" class="btn btn--light">
          <i class="fa-solid fa-handshake-angle"></i> Gabung Komunitas
        </a>
        <a href="<?php echo e(route('about.index')); ?>" class="btn">
          <i class="fa-solid fa-circle-play"></i> Lihat Cara Kerja
        </a>
      </div>
    </div>

    <div class="why-media">
      <div class="media-card">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop" alt="Community">
        <div class="media-hint">
          <i class="fa-solid fa-users"></i> Komunitas suportif
        </div>
      </div>
    </div>
  </div>
</section>


  
<section class="instructors-pro">
  <div class="container">
    <h2 class="section-title" style="text-align:center">Instruktur Terverifikasi</h2>
    <p class="section-sub">Foto besar, jabatan jelas, dan ringkasan pengalaman yang relevan.</p>

    <?php if($topInstructors->isNotEmpty()): ?>
      <div class="mentor-grid mentor-grid--3">
        <?php $__currentLoopData = $topInstructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $name = $p->user->name ?? 'Instruktur';
            $img  = $p->avatar_path
                      ? asset('storage/'.$p->avatar_path)
                      : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=EAF2FF&color=0D6EFD&bold=true';
          ?>

          <article class="mentor-card">
            <div class="mentor-photo">
              <img src="<?php echo e($img); ?>" alt="<?php echo e($name); ?>" loading="lazy">
            </div>
            <div class="mentor-body">
              <h3 class="mentor-name"><?php echo e($name); ?></h3>
              <div class="mentor-role"><?php echo e($p->primary_skill); ?></div>
              <p class="mentor-desc"><?php echo e($p->short_bio); ?></p>

              <?php if($p->github_url || $p->linkedin_url): ?>
                <div class="mentor-social">
                  <?php if($p->github_url): ?>
                    <a class="social-btn" href="<?php echo e($p->github_url); ?>" target="_blank" rel="noopener" aria-label="GitHub <?php echo e($name); ?>">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 .5a12 12 0 0 0-3.79 23.4c.6.11.82-.26.82-.58 0-.29-.01-1.06-.02-2.07-3.34.73-4.05-1.61-4.05-1.61-.55-1.41-1.34-1.79-1.34-1.79-1.09-.75.08-.74.08-.74 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.81 1.3 3.5.99.11-.78.42-1.3.76-1.6-2.67-.31-5.48-1.34-5.48-5.95 0-1.31.47-2.38 1.23-3.22-.12-.31-.54-1.55.12-3.23 0 0 1.01-.32 3.3 1.23A11.5 11.5 0 0 1 12 6.84c1.02.01 2.05.14 3.01.41 2.29-1.55 3.3-1.23 3.3-1.23.66 1.68.24 2.92.12 3.23.77.84 1.23 1.91 1.23 3.22 0 4.62-2.81 5.63-5.49 5.94.43.37.81 1.1.81 2.22 0 1.6-.01 2.89-.01 3.29 0 .32.22.7.83.58A12 12 0 0 0 12 .5Z"/>
                      </svg>
                    </a>
                  <?php endif; ?>
                  <?php if($p->linkedin_url): ?>
                    <a class="social-btn" href="<?php echo e($p->linkedin_url); ?>" target="_blank" rel="noopener" aria-label="LinkedIn <?php echo e($name); ?>">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM14.5 9c-2.33 0-3.5 1.27-3.5 2.73V21h4v-6.2c0-1.07.74-1.8 1.8-1.8 1.02 0 1.7.69 1.7 1.8V21h4v-7.06C22.5 10.55 20.7 9 18.2 9c-1.24 0-2.38.54-3 1.41V9h-.7z"/>
                      </svg>
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div class="center" style="margin-top:16px;">
        <a href="<?php echo e(route('instruktur.index')); ?>" class="btn btn--light">Lihat semua instruktur</a>
      </div>
    <?php else: ?>
      <p class="muted-center">Belum ada instruktur yang ditampilkan.</p>
    <?php endif; ?>
  </div>
</section>


  
  <section class="cta-join">
    <div class="container cta-wrap">
      <div class="cta-text">
        <h2>Jangan Belajar Sendiri. Gabung & Naik Level Bareng!</h2>
        <p>Akses materi lengkap, proyek nyata, dan komunitas suportif. Mulai gratis, upgrade kapan pun.</p>
        <div class="cta-actions">
          <a href="<?php echo e(route('register')); ?>" class="btn">Daftar Sekarang</a>
          <a href="<?php echo e(route('login')); ?>" class="btn btn--light">Saya Sudah Punya Akun</a>
        </div>
      </div>
      <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1200&auto=format&fit=crop" alt="">
    </div>
  </section>

 
<section id="reviews" class="rv-section">
  <div class="container">
    <div class="rv-head">
      <h2 class="rv-title">Apa Kata Mereka</h2>
      <p class="rv-sub">Ulasan dari member yang telah mengikuti kursus di Learnify.</p>
    </div>

    <div class="rv-grid">
      <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $name = $t->user->name ?? 'Student';
          $parts = preg_split('/\s+/', trim($name));
          $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
          $hue = crc32($name) % 360;
        ?>

        <article class="rv-card">
          <div class="rv-card-head">
            <div class="rv-avatar" style="--hue: <?php echo e($hue); ?>"><?php echo e($initials); ?></div>
            <div class="rv-id">
              <h3 class="rv-name"><?php echo e($name); ?></h3>
              <span class="rv-role">Student</span>
            </div>
          </div>

          <p class="rv-text"><?php echo e($t->content); ?></p>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="rv-empty">Belum ada testimoni.</p>
      <?php endif; ?>
    </div>

    <?php if(!empty($testiHasMore) && $testiHasMore): ?>
      <div class="rv-foot">
        <a href="<?php echo e(route('testimoni.index')); ?>" class="rv-btn">Lihat semua testimoni</a>
      </div>
    <?php endif; ?>
  </div>
</section>

  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/home/index.blade.php ENDPATH**/ ?>