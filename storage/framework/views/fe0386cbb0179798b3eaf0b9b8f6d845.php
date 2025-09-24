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

    
    <div class="stat-grid">
        <div class="stat-card">
            <p class="stat-label"><i class="fa-solid fa-book-open"></i> Active Courses</p>
            <p class="stat-value">3</p>
        </div>
        <div class="stat-card">
            <p class="stat-label"><i class="fa-solid fa-bolt"></i> Weekly Streak</p>
            <p class="stat-value">5d</p>
        </div>
        <div class="stat-card">
            <p class="stat-label"><i class="fa-solid fa-trophy"></i> Points</p>
            <p class="stat-value">1,240</p>
        </div>
    </div>

    <div class="dashboard-grid">
        
        <section class="left-panel">
            <div class="overview-card">
                <p class="overview-label"><i class="fas fa-chart-line"></i> Progress Belajar</p>
                <p class="overview-value">45%</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:45%"></div>
                </div>
            </div>

            <section class="upcoming">
                <h3 class="up-title">Upcoming Schedule</h3>
                <div class="up-list">
                    <div class="up-item">
                        <div class="up-date">12<br>Aug</div>
                        <div>
                            <strong>Live: Intro to SQL</strong>
                            <p class="up-meta">10:00–11:00 • Zoom</p>
                        </div>
                        <button class="up-goto">Join</button>
                    </div>
                    <div class="up-item">
                        <div class="up-date">14<br>Aug</div>
                        <div>
                            <strong>Quiz: Python Loops</strong>
                            <p class="up-meta">Deadline 23:59</p>
                        </div>
                        <button class="up-goto">Open</button>
                    </div>
                </div>
            </section>
        </section>

        
        <section class="right-panel">
            <h2 class="section-title">Continue Learning</h2>
            <div class="course-grid">
                <article class="course-card">
                    <div>
                        <div class="icon"><i class="fas fa-code"></i></div>
                        <h3 class="course-title">Programming Basics</h3>
                        <p class="course-meta">Lesson 2 of 8</p>
                        <span class="badge">Beginner</span>
                    </div>
                    <button class="btn-primary">Continue</button>
                </article>

                <article class="course-card">
                    <div>
                        <div class="icon"><i class="fas fa-database"></i></div>
                        <h3 class="course-title">Data Science Foundations</h3>
                        <p class="course-meta">Lesson 12 of 12</p>
                        <span class="badge">Completed</span>
                    </div>
                    <button class="btn-primary">Review</button>
                </article>

                <article class="course-card">
                    <div>
                        <div class="icon"><i class="fas fa-robot"></i></div>
                        <h3 class="course-title">Machine Learning Intro</h3>
                        <p class="course-meta">Lesson 3 of 10</p>
                        <span class="badge">Intermediate</span>
                    </div>
                    <button class="btn-primary">Continue</button>
                </article>
            </div>
        </section>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/dashboard/index.blade.php ENDPATH**/ ?>