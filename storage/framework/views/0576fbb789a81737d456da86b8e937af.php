<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
  /* ====== Tokens & polish ====== */
  :root{
    --radius: 14px;
  }
  .dash-wrap { max-width: 1200px; margin: 0 auto; }

  .card { border-radius: var(--radius); border: 1px solid rgba(0,0,0,.06); }
  .card:hover { transform: translateY(-1px); transition: .18s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.06)!important; }

  .kpi .card-body{ display:flex; flex-direction:column; gap:.25rem; }
  .kpi .display-6{ line-height:1; }
  .kpi .text-muted.small{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

  .section-title{
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 .5rem;
    display: flex; align-items: center; gap: .5rem;
  }
  .section-title i{ opacity:.75; }

  .list-group-item{ border-left:0; border-right:0; }
  .list-group-item:first-child{ border-top:0; }
  .list-group-item:last-child{ border-bottom:0; }

  .text-2line{
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
  }

  /* Empty state */
  .empty{
    padding: 16px; text-align:center; color: var(--bs-secondary-color);
    background: var(--bs-tertiary-bg); border-radius: var(--radius);
    border: 1px dashed var(--bs-border-color);
  }

  /* Header pills */
  .role-pill{ font-weight:600; letter-spacing:.2px; }

  /* Chart container padding */
  #trendChart{ max-height: 320px; }

  /* Dark mode */
  @media (prefers-color-scheme: dark){
    .card{ border-color: rgba(255,255,255,.08); }
    .card:hover{ box-shadow: 0 .5rem 1rem rgba(0,0,0,.35)!important; }
    .empty{ border-color: rgba(255,255,255,.12); }
  }

  /* Mobile tweaks */
  @media (max-width: 576px){
    .display-6{ font-size: 2rem; }
    .kpi .card-body{ gap:.35rem; }
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4 dash-wrap">
  
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="d-flex align-items-center gap-2">
      <h2 class="mb-0">Dashboard</h2>
      <span class="badge bg-light text-secondary border d-none d-sm-inline">Tahun: <?php echo e($tahun); ?></span>
    </div>
    <?php if($isSuper): ?>
      <span class="badge bg-danger role-pill">Superadmin</span>
    <?php else: ?>
      <span class="badge bg-secondary-subtle text-secondary-emphasis border role-pill">
        Mode Admin
      </span>
    <?php endif; ?>
  </div>

  
  <div class="row g-3 mb-4 kpi">
    <?php if($can['course']): ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Course</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['course_total']); ?></div>
            <div class="small text-muted">Free: <?php echo e($kpi['course_free']); ?> · Paid: <?php echo e($kpi['course_paid']); ?></div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
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
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Showcase</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['showcase_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['testimonial']): ?>
      <div class="col-12 col-sm-6 col-lg-3">
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
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Instructors</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['instructor_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['forum']): ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Forum Categories</div>
            <div class="display-6 fw-semibold"><?php echo e($kpi['forum_cat_total']); ?></div>
            <div class="small text-muted">
              Threads: <?php echo e($kpi['forum_thread_total']); ?> · Posts: <?php echo e($kpi['forum_post_total']); ?>

            </div>
            <div class="small text-muted">Locked: <?php echo e($kpi['forum_locked_total']); ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['about']): ?>
      <div class="col-12 col-sm-6 col-lg-3">
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
      <div class="col-12 col-sm-6 col-lg-3">
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
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Tren <?php echo e($tahun); ?></h5>
          <span class="text-muted small">Per Bulan</span>
        </div>
        <canvas id="trendChart" aria-label="Grafik tren per bulan" role="img"></canvas>
      </div>
    </div>
  <?php endif; ?>

  
  <div class="row g-3">
    <?php if($can['course']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-graduation-cap"></i> <span>Course Terbaru</span></div>

            <?php if(!empty($latest['courses']) && count($latest['courses'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['courses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3">
                      <div class="fw-semibold text-truncate" title="<?php echo e($c->name); ?>"><?php echo e($c->name); ?></div>
                      <div class="text-muted small">
                        <?php echo e($c->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?>

                      </div>
                    </div>
                    <div class="text-nowrap">
                      <a href="<?php echo e(route('admin.detail.index')); ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                    </div>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada course terbaru.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-book-open"></i> <span>Lesson Terbaru</span></div>

            <?php if(!empty($latest['lessons']) && count($latest['lessons'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['lessons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item">
                    <div class="fw-semibold text-truncate" title="<?php echo e($l->title); ?>"><?php echo e($l->title); ?></div>
                    <div class="text-muted small">
                      Modul: <?php echo e($l->module_name ?? '-'); ?> ·
                      <?php echo e($l->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?>

                    </div>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada lesson terbaru.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['showcase']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-images"></i> <span>Showcase Terbaru</span></div>

            <?php if(!empty($latest['showcases']) && count($latest['showcases'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['showcases']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-truncate" title="<?php echo e($s->title); ?>"><?php echo e($s->title); ?></span>
                    <span class="text-muted small"><?php echo e($s->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></span>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada showcase terbaru.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['testimonial']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-comment-dots"></i> <span>Testimonial Terbaru</span></div>

            <?php if(!empty($latest['testis']) && count($latest['testis'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['testis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                      <span><?php echo e($t->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></span>
                      <?php if($t->is_published): ?>
                        <span class="badge bg-primary">Published</span>
                      <?php endif; ?>
                    </div>
                    <div class="fw-semibold text-2line"><?php echo e(Str::limit(strip_tags($t->content), 160)); ?></div>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada testimonial terbaru.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if($can['forum']): ?>
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-comments"></i> <span>Thread Terbaru</span></div>

            <?php if(!empty($latest['threads']) && count($latest['threads'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['threads']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3">
                      <div class="fw-semibold text-truncate" title="<?php echo e($th->title); ?>"><?php echo e($th->title); ?></div>
                      <div class="text-muted small"><?php echo e($th->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></div>
                    </div>
                    <?php if($th->is_locked): ?>
                      <span class="badge bg-secondary">Locked</span>
                    <?php endif; ?>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada thread terbaru.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-reply"></i> <span>Post Terbaru</span></div>

            <?php if(!empty($latest['posts']) && count($latest['posts'])>0): ?>
              <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $latest['posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-truncate">Post #<?php echo e($p->id); ?> (Thread #<?php echo e($p->thread_id); ?>)</span>
                    <span class="text-muted small"><?php echo e($p->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></span>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php else: ?>
              <div class="empty">Belum ada post terbaru.</div>
            <?php endif; ?>
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

        const withStyle = (label, data, colorVar) => {
          // pakai warna Bootstrap jika ada, fallback ke warna default Chart.js
          const css = getComputedStyle(document.documentElement);
          const color = getComputedStyle(document.body).getPropertyValue(colorVar) || css.getPropertyValue('--bs-primary') || '#0d6efd';
          return {
            label, data,
            borderColor: color.trim(),
            backgroundColor: color.trim() + '33', // 20% alpha
            borderWidth: 2, tension: .3, fill: false, pointRadius: 2
          };
        };

        <?php if($can['course']): ?>
          datasets.push(withStyle('Course', <?php echo json_encode($series['course'], 15, 512) ?>, '--bs-primary'));
          datasets.push(withStyle('Lesson', <?php echo json_encode($series['lesson'], 15, 512) ?>, '--bs-success'));
        <?php endif; ?>
        <?php if($can['showcase']): ?>
          datasets.push(withStyle('Showcase', <?php echo json_encode($series['showcase'], 15, 512) ?>, '--bs-info'));
        <?php endif; ?>
        <?php if($can['testimonial']): ?>
          datasets.push(withStyle('Testimonial', <?php echo json_encode($series['testimonial'], 15, 512) ?>, '--bs-warning'));
        <?php endif; ?>
        <?php if($can['forum']): ?>
          datasets.push(withStyle('Forum Threads', <?php echo json_encode($series['forum_thread'], 15, 512) ?>, '--bs-secondary'));
          datasets.push(withStyle('Forum Posts', <?php echo json_encode($series['forum_post'], 15, 512) ?>, '--bs-gray'));
        <?php endif; ?>

        const el = document.getElementById('trendChart');
        if (!el) return;

        new Chart(el, {
          type: 'line',
          data: { labels, datasets },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
              legend: { position: 'top', labels: { usePointStyle:true, boxWidth:8 } },
              tooltip: { intersect:false, mode:'index' }
            },
            scales: {
              y: { beginAtZero: true, ticks: { precision: 0 } },
              x: { ticks: { autoSkip: true, maxRotation: 0 } }
            }
          }
        });
      })();
    </script>
  <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>