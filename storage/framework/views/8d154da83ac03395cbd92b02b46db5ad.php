<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/lesson.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('title', 'Learnify - Lessons of ' . ($course->name ?? $course->title ?? 'Course')); ?>

<?php $__env->startSection('content'); ?>
<div class="lesson-page">
    
    <section class="lp-header container" aria-label="Course header">
        <nav class="crumbs" aria-label="Breadcrumb">
            <a href="<?php echo e(route('detail.index', $course->slug)); ?>" class="crumb">
                <i class="fa-solid fa-chevron-left"></i>
                Kembali ke Detail Kursus
            </a>
        </nav>

        <div class="course-head">
            <div class="head-text">
                <h1 class="course-name"><?php echo e($course->name ?? $course->title); ?></h1>
                <div class="sub">
                    <span class="badge-level"><i class="fa-solid fa-signal"></i> <?php echo e($course->level->level ?? 'Level'); ?></span>
                    <span class="dot">•</span>
                    <span><i class="fa-regular fa-clock"></i> <?php echo e($lesson?->duration ? gmdate('i:s', $lesson->duration) : '00:00'); ?></span>
                    <span class="dot">•</span>
                    <span>
                        <i class="fa-solid fa-user-tie"></i>
                        <?php if($course->instructors->isNotEmpty()): ?>
                            <?php echo e($course->instructors->pluck('name')->join(', ')); ?>

                        <?php else: ?>
                            Instruktur
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <div class="head-cta">
                <a class="btn ghost" href="<?php echo e(route('detail.index', $course->slug)); ?>">
                    <i class="fa-regular fa-circle-play"></i> Lihat Kursus
                </a>
                <a class="btn brand" href="#comments">
                    <i class="fa-regular fa-message"></i> Diskusi
                </a>
            </div>
        </div>
    </section>

    
    <main class="lesson-layout container">
        
        <section class="lp-left">
            
            <div class="media-shell" aria-label="Lesson media">
                <?php
                    $media = $lesson->media ?? null;
                    $ext = $media ? strtolower(pathinfo($media, PATHINFO_EXTENSION)) : null;
                    $isVideo = $ext && in_array($ext, ['mp4','mov','avi','mkv','webm']);
                    $isImage = $ext && in_array($ext, ['jpg','jpeg','png','gif','webp']);
                ?>

                <?php if($media && $isVideo): ?>
                    <video class="media" controls oncontextmenu="return false;" controlsList="nodownload" preload="metadata">
                        <source src="<?php echo e(asset('storage/' . $media)); ?>" type="video/<?php echo e($ext === 'mkv' ? 'mp4' : $ext); ?>" />
                        Browser tidak mendukung video.
                    </video>
                <?php elseif($media && $isImage): ?>
                    <img
                        class="media img-protected"
                        src="<?php echo e(asset('storage/' . $media)); ?>"
                        alt="Media untuk <?php echo e($lesson->title ?? 'Lesson'); ?>"
                        draggable="false"
                        oncontextmenu="return false;"
                    />
                <?php else: ?>
                    <div class="media-empty" role="img" aria-label="Tidak ada media">
                        <i class="fa-solid fa-photo-film"></i>
                        <p>Belum ada media untuk lesson ini.</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <h2 class="lesson-title"><?php echo e($lesson->title ?? 'Untitled Lesson'); ?></h2>

            
            <div class="lesson-meta">
                <span class="meta-item">
                    <i class="fa-solid fa-user-group"></i>
                    <?php if($course->instructors->isNotEmpty()): ?>
                        <?php echo e($course->instructors->pluck('name')->join(', ')); ?>

                    <?php else: ?>
                        Instruktur
                    <?php endif; ?>
                </span>
                <span class="dot">•</span>
                <span class="meta-item">
                    <i class="fa-regular fa-clock"></i>
                    <?php echo e($lesson?->duration ? gmdate('i:s', $lesson->duration) : '00:00'); ?>

                </span>
            </div>

            
            <article class="lesson-overview">
                <h3>Lesson Overview</h3>
                <div class="overview-body">
                    <?php echo $lesson->content ?? '<em>Belum ada deskripsi untuk lesson ini.</em>'; ?>

                </div>
            </article>

            
            <section id="comments" class="comment-card" aria-labelledby="comments-title">
                <div class="comment-head">
                    <h3 id="comments-title"><i class="fa-regular fa-message"></i> Komentar</h3>
                    <button id="toggle-comments" type="button" class="btn ghost-sm" aria-expanded="true" aria-controls="comment-wrap">
                        Sembunyikan
                    </button>
                </div>

                <div id="comment-wrap">
                    <form id="comment-form" class="comment-form" autocomplete="off">
                        <?php echo csrf_field(); ?>
                        <label for="comment-input" class="sr-only">Tambah komentar</label>
                        <textarea id="comment-input" placeholder="Tulis komentar publik..." required></textarea>
                        <div class="form-actions">
                            <button type="submit" class="btn brand-sm">Kirim</button>
                        </div>
                    </form>

                    <p class="judul">Semua Komentar</p>
                    <div id="comment-list" class="comment-list" aria-live="polite"></div>
                </div>
            </section>
        </section>

        
        <aside class="lp-right" aria-label="Daftar modul">
            <div class="playlist-head">
                <h3><i class="fa-regular fa-rectangle-list"></i> Course Modules</h3>
                <span class="count"><?php echo e($course->lessons->count()); ?> materi</span>
            </div>

            <ul class="playlist">
                <?php $__empty_1 = true; $__currentLoopData = $course->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $mext = $item->media ? strtolower(pathinfo($item->media, PATHINFO_EXTENSION)) : null;
                        $mIsVideo = $mext && in_array($mext, ['mp4','mov','avi','mkv','webm']);
                        $mIsImage = $mext && in_array($mext, ['jpg','jpeg','png','gif','webp']);
                        $isActive = $lesson && $item->id === $lesson->id;
                    ?>
                    <li class="pl-item <?php echo e($isActive ? 'active' : ''); ?>">
                        <a
                            href="<?php echo e(route('lesson.index', $course->slug)); ?>?lesson=<?php echo e($item->id); ?>"
                            class="pl-link"
                            aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>"
                        >
                            <div class="thumb" aria-hidden="true">
                                <?php if($item->media && $mIsVideo): ?>
                                    <video muted preload="metadata" oncontextmenu="return false;" controlsList="nodownload">
                                        <source src="<?php echo e(asset('storage/' . $item->media)); ?>" type="video/<?php echo e($mext === 'mkv' ? 'mp4' : $mext); ?>" />
                                    </video>
                                <?php elseif($item->media && $mIsImage): ?>
                                    <img
                                        src="<?php echo e(asset('storage/' . $item->media)); ?>"
                                        alt=""
                                        class="thumb-img img-protected"
                                        draggable="false"
                                        oncontextmenu="return false;"
                                    />
                                <?php else: ?>
                                    <div class="thumb-empty">🎬</div>
                                <?php endif; ?>
                                <?php if($isActive): ?>
                                    <span class="now">Sedang diputar</span>
                                <?php endif; ?>
                            </div>
                            <div class="info">
                                <p class="title"><?php echo e($item->title); ?></p>
                                <span class="duration"><?php echo e($item->duration ? gmdate('i:s', $item->duration) : '00:00'); ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="pl-item">
                        <div class="pl-link">
                            <div class="thumb-empty">—</div>
                            <div class="info">
                                <p class="title">Belum ada lesson di course ini.</p>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
    </main>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // ===== Media protections
  document.addEventListener('contextmenu', function(e) {
    if (e.target.closest('.img-protected, video')) e.preventDefault();
  });
  document.querySelectorAll('.img-protected').forEach(el => el.setAttribute('draggable','false'));

  // ===== Comments (localStorage demo)
  const form = document.getElementById('comment-form');
  const input = document.getElementById('comment-input');
  const list  = document.getElementById('comment-list');
  const wrap  = document.getElementById('comment-wrap');
  const toggle= document.getElementById('toggle-comments');

  function addComment(text, announce=false){
    const item = document.createElement('div');
    item.className = 'comment';
    item.innerHTML = `<p>${text}</p>`;
    list.prepend(item);
    if (announce) item.setAttribute('aria-live','polite');
  }
  function loadComments(){
    const saved = JSON.parse(localStorage.getItem('lesson_comments') || '[]');
    saved.forEach(t => addComment(t));
  }
  loadComments();

  form?.addEventListener('submit', (e)=>{
    e.preventDefault();
    const text = input.value.trim();
    if(!text) return;
    const saved = JSON.parse(localStorage.getItem('lesson_comments') || '[]');
    saved.unshift(text);
    localStorage.setItem('lesson_comments', JSON.stringify(saved));
    addComment(text, true);
    input.value = '';
  });

  // Toggle comments
  toggle?.addEventListener('click', ()=>{
    const open = wrap.style.display !== 'none';
    wrap.style.display = open ? 'none' : '';
    toggle.textContent = open ? 'Tampilkan' : 'Sembunyikan';
    toggle.setAttribute('aria-expanded', String(!open));
  });

  // Scroll active item into view (playlist)
  const active = document.querySelector('.pl-item.active');
  active?.scrollIntoView({ block: 'nearest', inline: 'nearest' });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/lesson/index.blade.php ENDPATH**/ ?>