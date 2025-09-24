<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/detail.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $avgFloat = (float) ($course->reviews_avg_rating ?? 0);
        $avgRounded = round($avgFloat);
        $avgLabel = number_format($avgFloat, 1);
        $students = (int) ($course->students_count ?? 0);
    ?>

    <div class="detail-page">
        <!-- HERO -->
        <header class="hero container" aria-labelledby="course-title">
            <div class="hero-media" aria-hidden="true">
                <div class="img-protected"
                    style="background-image: url('<?php echo e($course->img ? asset('storage/' . $course->img) : 'https://via.placeholder.com/1200x600?text=Course+Cover'); ?>');">
                </div>
            </div>

            <div class="hero-info">
                <h1 id="course-title" class="course-title"><?php echo e($course->name); ?></h1>

                <div class="rating-line" aria-label="Rating rata-rata <?php echo e($avgLabel); ?> dari 5">
                    <div class="stars" aria-hidden="true">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="<?php echo e($i <= $avgRounded ? 'fa-solid fa-star' : 'fa-regular fa-star'); ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-number"><?php echo e($avgLabel); ?></span>
                    <span class="divider">•</span>
                    <span class="reviews">(<?php echo e($course->reviews->count()); ?> ulasan)</span>
                </div>

                <div class="meta-line">
                    <i class="fa-solid fa-user-group" aria-hidden="true"></i>
                    <span><?php echo e($students); ?> orang sudah ikut</span>
                </div>

                <?php
                    $transaction = \App\Models\Transaction::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->where('status', 'paid')
                        ->first();
                ?>

                <?php if($transaction): ?>
                    <a href="<?php echo e(route('lesson.index', $course->slug)); ?>" class="btn pay-btn"
                        aria-label="Mulai belajar: <?php echo e($course->name); ?>">
                        <i class="fa-solid fa-play" aria-hidden="true">
                        </i>
                        Mulai Belajar : <?php echo e($course->name ?? 'Kursus'); ?>

                    </a>
                <?php else: ?>
                    <form action="<?php echo e(route('checkout.start', ['course' => $course->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn pay-btn">
                            <i class="fa-solid fa-play"></i>
                            Rp. <?php echo e($course->price ?? 'Free'); ?>

                        </button>
                    </form>
                <?php endif; ?>


                <ul class="quick-facts" aria-label="Informasi singkat kursus">
                    <li><i class="fa-regular fa-clock" aria-hidden="true"></i> <?php echo e($course->formatted_duration); ?></li>
                    <li><i class="fa-solid fa-signal" aria-hidden="true"></i> Tingkat: <?php echo e($course->level?->level ?? '-'); ?>

                    </li>
                    <li><i class="fa-solid fa-certificate" aria-hidden="true"></i> Sertifikat kelulusan</li>
                </ul>
            </div>
        </header>

        <!-- TABS -->
        <section class="tabs container" aria-label="Konten kursus">
            <input type="radio" id="tab-tentang" name="tabs" checked />
            <input type="radio" id="tab-modul" name="tabs" />
            <input type="radio" id="tab-mentor" name="tabs" />
            <input type="radio" id="tab-review" name="tabs" />

            <nav class="tab-nav" role="tablist" aria-label="Navigasi tab">
                <label for="tab-tentang" role="tab" aria-controls="panel-tentang" tabindex="0">Tentang Kursus</label>
                <label for="tab-modul" role="tab" aria-controls="panel-modul" tabindex="0">Modul</label>
                <label for="tab-mentor" role="tab" aria-controls="panel-mentor" tabindex="0">Mentor</label>
                <label for="tab-review" role="tab" aria-controls="panel-review" tabindex="0">Review</label>
                <span class="active-pill" aria-hidden="true"></span>
            </nav>

            <div class="tab-panels">
                <!-- TENTANG -->
                <article id="panel-tentang" class="tab-panel" role="tabpanel" aria-labelledby="tab-tentang">
                    <h2>Apa yang akan kamu pelajari</h2>
                    <?php echo $course->detail?->description ?? '<p class="muted">Belum ada deskripsi.</p>'; ?>

                    <?php if(!empty($course->detail?->outcomes)): ?>
                        <div class="outcomes"><?php echo $course->detail->outcomes; ?></div>
                    <?php endif; ?>
                </article>

                <!-- MODUL -->
                <article id="panel-modul" class="tab-panel" role="tabpanel" aria-labelledby="tab-modul">
                    <h2>Daftar Modul</h2>
                    <?php
                        $grouped = $course->lessons->groupBy(fn($l) => $l->module_name ?: 'Modul');
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $lessons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <details class="dp-accordion">
                            <summary>
                                <span class="mod-title"><?php echo e($module); ?></span>
                                <span class="count"><?php echo e($lessons->count()); ?> materi</span>
                            </summary>
                            <ul class="module-list">
                                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <i class="fa-regular fa-circle-play" aria-hidden="true"></i>
                                        <span class="ttl"><?php echo e($lesson->title); ?></span>
                                        <em class="dur"><?php echo e($lesson->formatted_duration); ?></em>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </details>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="muted">Belum ada modul.</p>
                    <?php endif; ?>
                </article>

                <!-- MENTOR -->
                <article id="panel-mentor" class="tab-panel" role="tabpanel" aria-labelledby="tab-mentor">
                    <h2>Mentor</h2>
                    <div class="mentor-grid">
                        <?php $__empty_1 = true; $__currentLoopData = $course->detail?->instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="mentor-card">
                                <div class="img-protected mentor-avatar"
                                    style="background-image: url('<?php echo e($mentor->avatar_path ? asset('storage/' . $mentor->avatar_path) : 'https://via.placeholder.com/240x240?text=Mentor'); ?>');">
                                </div>
                                <div class="mentor-info">
                                    <h3><?php echo e($mentor->user->name); ?></h3>
                                    <p class="role"><?php echo e($mentor->primary_skill ?? '-'); ?></p>
                                    <p class="bio"><?php echo e($mentor->short_bio ?? '-'); ?></p>
                                    <div class="links" aria-label="Sosial">
                                        <?php if($mentor->github_url): ?>
                                            <a href="<?php echo e($mentor->github_url); ?>" target="_blank" rel="noopener"
                                                aria-label="GitHub">
                                                <i class="fa-brands fa-github"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($mentor->linkedin_url): ?>
                                            <a href="<?php echo e($mentor->linkedin_url); ?>" target="_blank" rel="noopener"
                                                aria-label="LinkedIn">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="muted">Belum ada mentor yang ditambahkan.</p>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- REVIEW -->
                <article id="panel-review" class="tab-panel" role="tabpanel" aria-labelledby="tab-review">
                    <div class="review-header card-soft">
                        <div class="avg">
                            <div class="avg-score"><?php echo e($avgLabel); ?></div>
                            <div class="avg-stars" aria-hidden="true">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo e($i <= $avgRounded ? 'fa-solid fa-star' : 'fa-regular fa-star'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="count">(<?php echo e($course->reviews->count()); ?> ulasan)</p>
                        </div>
                    </div>

                    <ul class="review-list">
                        <?php $__empty_1 = true; $__currentLoopData = $course->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="review-item card-soft">
                                <div class="img-protected review-avatar"
                                    style="background-image: url('<?php echo e($review->user->avatar ?? 'https://i.pravatar.cc/80'); ?>');">
                                </div>
                                <div class="review-body">
                                    <div class="name">
                                        <?php echo e($review->user->name); ?>

                                        <span class="stars-inline" aria-hidden="true">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php echo e($i <= (int) $review->rating ? '★' : '☆'); ?>

                                            <?php endfor; ?>
                                        </span>
                                    </div>
                                    <p class="comment"><?php echo e($review->comment); ?></p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="muted">Belum ada review.</p>
                        <?php endif; ?>
                    </ul>
                </article>
            </div>
        </section>

        <!-- REKOMENDASI -->
        <section class="container recos" aria-label="Rekomendasi kursus">
            <h2>Orang lain juga kursus di sini</h2>
            <div class="reco-row">
                <?php $__empty_1 = true; $__currentLoopData = $relatedCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="reco-card card-hover" href="<?php echo e(route('detail.index', $rel->slug)); ?>"
                        aria-label="Lihat <?php echo e($rel->name); ?>">
                        <div class="img-protected reco-thumb"
                            style="background-image: url('<?php echo e($rel->img ? asset('storage/' . $rel->img) : 'https://via.placeholder.com/600x340?text=Course'); ?>');">
                        </div>
                        <div class="reco-body">
                            <h3><?php echo e($rel->name); ?></h3>
                            <div class="mini">
                                <span class="stars-mini" aria-hidden="true">
                                    <?php $rr = round((float)($rel->reviews_avg_rating ?? 0)); ?>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo e($i <= $rr ? '★' : '☆'); ?>

                                    <?php endfor; ?>
                                </span>
                                <span class="price"><?php echo e($rel->priceRange->name ?? 'Gratis'); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="muted">Tidak ada rekomendasi.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/detail/index.blade.php ENDPATH**/ ?>