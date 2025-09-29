<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/dashboard.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Dashboard - Learnify'); ?>

<?php $__env->startSection('content'); ?>
<main class="dashboard-container">

    
    <section class="profile-header">
        <img
            src="<?php echo e(Auth::user()->profile && Auth::user()->profile->foto
                ? asset('storage/' . Auth::user()->profile->foto)
                : asset('image/avatar.jpg')); ?>"
            alt="Foto profil <?php echo e(Auth::user()->profile->nama_lengkap ?? Auth::user()->name); ?>"
            class="avatar"
        >
        <div class="user-info">
            <h1 class="page-title">Hi, <?php echo e(Auth::user()->profile->nama_lengkap ?? Auth::user()->name); ?> 👋</h1>
            <p class="page-subtitle">Selamat datang kembali! Ayo lanjutkan belajar.</p>
        </div>
    </section>

    
    <?php
      // Fallback agar kompatibel dengan controller lama/baru
      $progressPercent = $overviewPercent
          ?? $overallProgressPercent
          ?? 0;

      $progressLabel = $overviewLabel
          ?? 'Progress Belajar';

      // Dropdown data: gunakan $activeCourses jika tersedia; kalau tidak, ambil dari $continueLearning
      $activeList = (isset($activeCourses) && $activeCourses instanceof \Illuminate\Support\Collection)
          ? $activeCourses
          : collect($continueLearning ?? [])->map(fn($it)=>$it['course'] ?? null)->filter()->unique('id')->values();

      $selectedId = (int) ($selectedCourseId ?? request()->integer('course'));
    ?>

    <section class="progress-wide card">
        <div class="pw-left">
            <div class="pw-head">
                <h2 class="pw-title"><i class="fas fa-chart-line"></i> <?php echo e($progressLabel); ?></h2>

                
                <?php if($activeList->count() > 0): ?>
                <form method="GET" action="<?php echo e(route('dashboard.index')); ?>" class="progress-filter" aria-label="Filter course untuk progress">
                  <label for="course" class="sr-only">Pilih course</label>
                  <div class="select-wrap">
                    <select id="course" name="course" onchange="this.form.submit()" aria-label="Pilih course untuk menghitung progress">
                      <option value="">— Semua course aktif —</option>
                      <?php $__currentLoopData = $activeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ac->id); ?>" <?php echo e($selectedId === (int)$ac->id ? 'selected' : ''); ?>>
                          <?php echo e($ac->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </form>
                <?php endif; ?>
            </div>

            <div class="pw-meter">
                <div class="pw-track" aria-label="Progress belajar">
                    <span class="pw-fill" style="width: <?php echo e(max(0, min(100, (int)$progressPercent))); ?>%"></span>
                </div>
                <div class="pw-meta">
                    <span class="pw-percent"><?php echo e((int)$progressPercent); ?>%</span>
                    <?php if((int)$progressPercent >= 100): ?>
                        <span class="pw-note done">Selesai semua 🎉</span>
                    <?php else: ?>
                        <span class="pw-note">Tetap semangat! Sedikit lagi 💪</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="pw-stat">
            <p class="stat-label"><i class="fa-solid fa-book-open"></i> Active Courses</p>
            <p class="stat-value"><?php echo e($activeCoursesCount ?? $activeList->count()); ?></p>
        </div>
    </section>

    
    <div class="below-grid">
        
        <section class="card acard">
            <div class="card-head">
                <h3 class="card-title"><i class="fa-solid fa-layer-group"></i> Active Courses</h3>
            </div>

            <?php
              // Sumber data active courses: prefer $continueLearning (ada progress & nextLesson)
              $activeItems = collect($continueLearning ?? [])->map(function($it){
                  $c = $it['course'] ?? null;
                  if(!$c) return null;
                  return [
                      'course' => $c,
                      'progress' => (int)($it['progress'] ?? 0),
                      'nextLesson' => $it['nextLesson'] ?? null,
                      'lessons_count' => (int)($it['lessons_count'] ?? ($c->lessons()->count() ?? 0)),
                  ];
              })->filter()->values();

              $doneCount = $activeItems->filter(fn($i) => ((int)$i['progress']) >= 100)->count();
              $todoCount = max(0, $activeItems->count() - $doneCount);
            ?>

            <?php if($activeItems->isEmpty()): ?>
              <p class="muted">Belum ada kursus aktif.</p>
            <?php else: ?>
              
              <div class="ac-stat-row">
                <span class="pill pill-todo"><i class="fa-regular fa-clock"></i> In progress: <?php echo e($todoCount); ?></span>
                <span class="pill pill-done"><i class="fa-solid fa-circle-check"></i> Completed: <?php echo e($doneCount); ?></span>
              </div>

              <ul class="a-list">
                <?php $__currentLoopData = $activeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    $c = $item['course'];
                    $p = (int) $item['progress'];
                    $done = $p >= 100;
                  ?>
                  <li class="a-item">
                    <div class="a-info">
                      <h4 class="a-name"><?php echo e($c->name); ?></h4>
                      <div class="a-line">
                        <div class="a-track"><span style="width: <?php echo e($p); ?>%"></span></div>
                        <small class="a-caption"><?php echo e($p); ?>%</small>
                      </div>
                      <span class="badge <?php echo e($done ? 'bdone' : 'bprog'); ?>">
                        <?php echo e($done ? 'Completed' : 'In progress'); ?>

                      </span>
                    </div>
                    <div class="a-cta">
                      <?php if($done): ?>
                        <a class="btn ghost" href="<?php echo e(route('detail.index', $c->slug)); ?>">Review</a>
                      <?php else: ?>
                        <?php $next = $item['nextLesson']; ?>
                        <?php if($next): ?>
                          <a class="btn primary" href="<?php echo e(route('lesson.index', [$c->slug, 'lesson' => $next->id])); ?>">Continue</a>
                        <?php else: ?>
                          <a class="btn primary" href="<?php echo e(route('detail.index', $c->slug)); ?>">Lihat</a>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php endif; ?>
        </section>

        
        <section class="cl-wrap">
            <div class="cl-head">
                <h2 class="section-title">Continue Learning</h2>
            </div>

            <?php
              $cl = collect($continueLearning ?? []);
              $isSlider = $cl->count() > 3;
            ?>

            <?php if(!$isSlider): ?>
              
              <div class="course-grid">
                <?php $__empty_1 = true; $__currentLoopData = $cl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <?php
                    $c     = $it['course'];
                    $next  = $it['nextLesson'] ?? null;
                    $p     = (int)($it['progress'] ?? 0);
                    $count = (int)($it['lessons_count'] ?? 0);
                    $done  = $p >= 100;
                  ?>
                  <article class="course-card">
                    <div>
                      <div class="icon" aria-hidden="true"><i class="fas fa-book"></i></div>
                      <h3 class="course-title"><?php echo e($c->name); ?></h3>
                      <p class="course-meta">
                        <?php if($done): ?>
                          <?php echo e($p); ?>% selesai • Selesai 🎉
                        <?php else: ?>
                          <?php echo e($p); ?>% selesai
                          <?php if($next): ?>
                            • Next: <?php echo e($next->module_name ? $next->module_name.' · ' : ''); ?><?php echo e($next->title); ?>

                          <?php endif; ?>
                        <?php endif; ?>
                      </p>
                      <span class="badge <?php echo e($done ? 'bdone' : 'bprog'); ?>"><?php echo e($done ? 'Completed' : 'In progress'); ?></span>

                      <div class="mini-line">
                        <div class="mini-track"><span style="width: <?php echo e($p); ?>%"></span></div>
                        <small class="mini-caption"><?php echo e($p); ?>% • <?php echo e($count); ?> modul</small>
                      </div>
                    </div>

                    <?php if($done): ?>
                      <a class="btn-primary" href="<?php echo e(route('detail.index', $c->slug)); ?>">Review</a>
                    <?php else: ?>
                      <?php if($next): ?>
                        <a class="btn-primary" href="<?php echo e(route('lesson.index', [$c->slug, 'lesson' => $next->id])); ?>">Continue</a>
                      <?php else: ?>
                        <a class="btn-primary" href="<?php echo e(route('detail.index', $c->slug)); ?>">Lihat</a>
                      <?php endif; ?>
                    <?php endif; ?>
                  </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <p class="muted">Belum ada kursus untuk dilanjut.</p>
                <?php endif; ?>
              </div>
            <?php else: ?>
              
              <div class="cl-slider" id="cl-slider" aria-roledescription="carousel" aria-label="Continue Learning">
                <div class="cl-track" id="cl-track">
                  <?php $__currentLoopData = $cl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                      $c     = $it['course'];
                      $next  = $it['nextLesson'] ?? null;
                      $p     = (int)($it['progress'] ?? 0);
                      $count = (int)($it['lessons_count'] ?? 0);
                      $done  = $p >= 100;
                    ?>
                    <article class="course-card cl-item" role="group">
                      <div>
                        <div class="icon" aria-hidden="true"><i class="fas fa-book"></i></div>
                        <h3 class="course-title"><?php echo e($c->name); ?></h3>
                        <p class="course-meta">
                          <?php if($done): ?>
                            <?php echo e($p); ?>% selesai • Selesai 🎉
                          <?php else: ?>
                            <?php echo e($p); ?>% selesai
                            <?php if($next): ?>
                              • Next: <?php echo e($next->module_name ? $next->module_name.' · ' : ''); ?><?php echo e($next->title); ?>

                            <?php endif; ?>
                          <?php endif; ?>
                        </p>
                        <span class="badge <?php echo e($done ? 'bdone' : 'bprog'); ?>"><?php echo e($done ? 'Completed' : 'In progress'); ?></span>

                        <div class="mini-line">
                          <div class="mini-track"><span style="width: <?php echo e($p); ?>%"></span></div>
                          <small class="mini-caption"><?php echo e($p); ?>% • <?php echo e($count); ?> modul</small>
                        </div>
                      </div>

                      <?php if($done): ?>
                        <a class="btn-primary" href="<?php echo e(route('detail.index', $c->slug)); ?>">Review</a>
                      <?php else: ?>
                        <?php if($next): ?>
                          <a class="btn-primary" href="<?php echo e(route('lesson.index', [$c->slug, 'lesson' => $next->id])); ?>">Continue</a>
                        <?php else: ?>
                          <a class="btn-primary" href="<?php echo e(route('detail.index', $c->slug)); ?>">Lihat</a>
                        <?php endif; ?>
                      <?php endif; ?>
                    </article>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="cl-nav">
                  <button class="cl-btn" id="cl-prev" aria-label="Sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
                  <button class="cl-btn" id="cl-next" aria-label="Berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
              </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
  // Auto slider Continue Learning bila ada track
  const track = document.getElementById('cl-track');
  if(!track) return;

  const prevBtn = document.getElementById('cl-prev');
  const nextBtn = document.getElementById('cl-next');
  const slider  = document.getElementById('cl-slider');

  // Scroll snap per kartu
  const CARD_GAP = 16; // match CSS gap
  const step = () => {
    const card = track.querySelector('.cl-item');
    if(!card) return 300;
    return card.getBoundingClientRect().width + CARD_GAP;
  }

  function scrollByStep(dir = 1){
    track.scrollBy({ left: dir * step(), behavior: 'smooth' });
  }

  prevBtn?.addEventListener('click', ()=>scrollByStep(-1));
  nextBtn?.addEventListener('click', ()=>scrollByStep(+1));

  // Auto slide tiap 5 detik (pause saat hover)
  let auto = setInterval(()=>scrollByStep(+1), 5000);
  slider?.addEventListener('mouseenter', ()=>clearInterval(auto));
  slider?.addEventListener('mouseleave', ()=>{
    clearInterval(auto);
    auto = setInterval(()=>scrollByStep(+1), 5000);
  });
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/dashboard/index.blade.php ENDPATH**/ ?>