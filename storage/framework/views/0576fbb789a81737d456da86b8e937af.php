<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Dashboard</h2>
    <?php if($isSuper): ?>
      <span class="badge bg-danger">Superadmin</span>
    <?php else: ?>
      <span class="text-muted small">Mode Admin (berdasarkan permission)</span>
    <?php endif; ?>
  </div>

  
  <div class="row g-3 mb-3">
    <?php if($can['course']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Course</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['course_total']); ?></div>
            <div class="small text-muted">Free: <?php echo e($kpi['course_free']); ?> · Paid: <?php echo e($kpi['course_paid']); ?></div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Lesson</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['lesson_total']); ?></div>
            <div class="small text-muted">Kategori: <?php echo e($kpi['category_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['showcase']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Showcase</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['showcase_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['testimonial']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Testimonial</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['testimonial_total']); ?></div>
            <div class="small text-muted">Published: <?php echo e($kpi['testimonial_pub']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['instructor']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Instructors</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['instructor_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['forum']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Forum Categories</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['forum_cat_total']); ?></div>
            <div class="small text-muted">Threads: <?php echo e($kpi['forum_thread_total']); ?> · Posts: <?php echo e($kpi['forum_post_total']); ?></div>
            <div class="small text-muted">Locked: <?php echo e($kpi['forum_locked_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['about']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">About Items</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['about_total']); ?></div>
            <div class="small text-muted">Sections: <?php echo e($kpi['about_sections']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['contact']): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Contact Config</div>
            <div class="display-6 fw-semibold">
              <?php echo e($kpi['contact_is_configured'] ? 'OK' : 'Belum'); ?>

            </div>
            <div class="small text-muted">Social filled: <?php echo e($kpi['contact_social_filled']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  
  <div class="row g-3 mb-4">
    <?php if($can['course']): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Course baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['course']); ?></div>
            </div>
            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Lesson baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['lesson']); ?></div>
            </div>
            <i class="fas fa-book-open fa-2x text-success"></i>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['showcase']): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Showcase baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['showcase']); ?></div>
            </div>
            <i class="fas fa-images fa-2x text-info"></i>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['testimonial']): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Testimonial baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['testimonial']); ?></div>
            </div>
            <i class="fas fa-comment-dots fa-2x text-warning"></i>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['forum']): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Thread baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['forum_thread']); ?></div>
            </div>
            <i class="fas fa-comments fa-2x text-secondary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Post baru (bulan ini)</div>
              <div class="h3 mb-0"><?php echo e($bulanIni['forum_post']); ?></div>
            </div>
            <i class="fas fa-reply fa-2x text-muted"></i>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  
  <?php
    $hasSeries = ($can['course'] && (!empty($series['course']) || !empty($series['lesson'])))
              || ($can['showcase'] && !empty($series['showcase']))
              || ($can['testimonial'] && !empty($series['testimonial']))
              || ($can['forum'] && (!empty($series['forum_thread']) || !empty($series['forum_post'])));
  ?>

  <?php if($hasSeries): ?>
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="card-title mb-0">Tren <?php echo e($tahun); ?></h5>
          <span class="text-muted small">Per Bulan</span>
        </div>
        <canvas id="trendChart" height="96"></canvas>
      </div>
    </div>
  <?php endif; ?>

  
  <div class="row g-3">
    <?php if($can['course']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Course Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['courses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <div class="fw-semibold"><?php echo e($c->name); ?></div>
                    <div class="text-muted small"><?php echo e($c->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></div>
                  </div>
                  <div class="text-nowrap">
                    <a href="<?php echo e(route('admin.detail.index')); ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                  </div>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Lesson Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['lessons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item">
                  <div class="fw-semibold"><?php echo e($l->title); ?></div>
                  <div class="text-muted small">Modul: <?php echo e($l->module_name ?? '-'); ?> · <?php echo e($l->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></div>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['showcase']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Showcase Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['showcases']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><?php echo e($s->title); ?></span>
                  <span class="text-muted small"><?php echo e($s->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></span>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['testimonial']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Testimonial Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['testis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item">
                  <div class="text-muted small"><?php echo e($t->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?>

                    <?php if($t->is_published): ?> · <span class="badge bg-primary">Published</span> <?php endif; ?>
                  </div>
                  <div class="fw-semibold text-truncate" style="-webkit-line-clamp:2; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                    <?php echo e(Str::limit(strip_tags($t->content), 160)); ?>

                  </div>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['forum']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Thread Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['threads']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <div class="fw-semibold"><?php echo e($th->title); ?></div>
                    <div class="text-muted small"><?php echo e($th->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></div>
                  </div>
                  <?php if($th->is_locked): ?>
                    <span class="badge bg-secondary">Locked</span>
                  <?php endif; ?>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Post Terbaru</h6>
            <ul class="list-group list-group-flush">
              <?php $__empty_1 = true; $__currentLoopData = $latest['posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Post #<?php echo e($p->id); ?> (Thread #<?php echo e($p->thread_id); ?>)</span>
                  <span class="text-muted small"><?php echo e($p->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></span>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="list-group-item text-muted">Belum ada data.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <?php if( ($can['course'] && (!empty($series['course']) || !empty($series['lesson'])))
    || ($can['showcase'] && !empty($series['showcase']))
    || ($can['testimonial'] && !empty($series['testimonial']))
    || ($can['forum'] && (!empty($series['forum_thread']) || !empty($series['forum_post']))) ): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      (function(){
        const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const datasets = [];

        <?php if($can['course']): ?>
          datasets.push({ label:'Course',   data:<?php echo json_encode($series['course'], 15, 512) ?>,       borderWidth:2, tension:.3 });
          datasets.push({ label:'Lesson',   data:<?php echo json_encode($series['lesson'], 15, 512) ?>,       borderWidth:2, tension:.3 });
        <?php endif; ?>
        <?php if($can['showcase']): ?>
          datasets.push({ label:'Showcase', data:<?php echo json_encode($series['showcase'], 15, 512) ?>,     borderWidth:2, tension:.3 });
        <?php endif; ?>
        <?php if($can['testimonial']): ?>
          datasets.push({ label:'Testimonial', data:<?php echo json_encode($series['testimonial'], 15, 512) ?>, borderWidth:2, tension:.3 });
        <?php endif; ?>
        <?php if($can['forum']): ?>
          datasets.push({ label:'Forum Threads', data:<?php echo json_encode($series['forum_thread'], 15, 512) ?>, borderWidth:2, tension:.3 });
          datasets.push({ label:'Forum Posts',   data:<?php echo json_encode($series['forum_post'], 15, 512) ?>,   borderWidth:2, tension:.3 });
        <?php endif; ?>

        const el = document.getElementById('trendChart');
        if (!el) return;

        new Chart(el, {
          type: 'line',
          data: { labels, datasets },
          options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
          }
        });
      })();
    </script>
  <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>