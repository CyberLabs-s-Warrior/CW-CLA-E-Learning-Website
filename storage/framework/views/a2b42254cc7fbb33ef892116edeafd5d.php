<?php $__env->startSection('title','Instruktur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-3 py-md-4 instructor-index">

  
  <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
    <div>
      <h1 class="h4 mb-0">Instruktur</h1>
      <div class="text-muted small">Kelola profil instruktur. Gunakan pencarian jika perlu.</div>
    </div>
    <a href="<?php echo e(route('admin.instruktur.create')); ?>" class="btn btn-primary ms-md-auto">
      <i class="fa fa-plus me-2"></i> Buat Profil
    </a>
  </div>

  
  <?php if(session('success')): ?>
    <div class="alert alert-success rounded-3 shadow-sm">
      <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  
  <div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-3 p-md-3">
      <form method="GET" action="<?php echo e(route('admin.instruktur.index')); ?>">
        <div class="row g-2 align-items-center">
          <div class="col-12 col-md-8 col-lg-6">
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
              <input type="search"
                     name="search"
                     value="<?php echo e(request('search')); ?>"
                     class="form-control"
                     placeholder="Cari nama instruktur…"
                     autocomplete="off">
              <?php if(request()->filled('search')): ?>
                <a class="btn btn-outline-secondary" href="<?php echo e(route('admin.instruktur.index')); ?>" title="Reset">
                  <i class="fas fa-rotate-left"></i>
                </a>
              <?php endif; ?>
              <button class="btn btn-outline-primary">
                Terapkan
              </button>
            </div>
          </div>
        </div>

        <?php if(request()->filled('search')): ?>
          <div class="mt-2 small text-muted">
            Menampilkan hasil untuk: <span class="fw-semibold">“<?php echo e(request('search')); ?>”</span>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light sticky-top">
            <tr>
              <th>Instruktur</th>
              <th>Bidang</th>
              <th style="width:120px;">Status</th>
              <th style="width:90px;">Urut</th>
              <th style="width:180px;">Diperbarui</th>
              <th class="text-end" style="width:170px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              $name = $p->user->name ?? 'Instruktur';
              $img  = $p->avatar_path
                        ? asset('storage/'.$p->avatar_path)
                        : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=EAF2FF&color=0D6EFD&bold=true';
            ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="<?php echo e($img); ?>" class="avatar-sm rounded-circle object-fit-cover" alt="<?php echo e($name); ?>">
                  <div class="d-flex flex-column lh-sm">
                    <span class="fw-semibold"><?php echo e($name); ?></span>
                    <small class="text-muted">ID: #<?php echo e($p->id); ?></small>
                  </div>
                </div>
              </td>

              <td class="text-truncate" style="max-width: 360px;">
                <?php echo e($p->primary_skill); ?>

              </td>

              <td>
                <?php if($p->is_published): ?>
                  <span class="badge badge-soft-success">Published</span>
                <?php else: ?>
                  <span class="badge badge-soft-secondary">Draft</span>
                <?php endif; ?>
              </td>

              <td><span class="text-muted"><?php echo e($p->sort_order); ?></span></td>

              <td>
                <div><?php echo e($p->updated_at?->format('d M Y H:i')); ?></div>
                <div class="text-muted small"><?php echo e($p->updated_at?->diffForHumans()); ?></div>
              </td>

              <td class="text-end">
                <div class="btn-group" role="group">
                  <a href="<?php echo e(route('admin.instruktur.edit',$p)); ?>" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-pen me-1"></i> Edit
                  </a>
                  <form action="<?php echo e(route('admin.instruktur.destroy',$p)); ?>" method="post" class="d-inline"
                        onsubmit="return confirm('Hapus profil <?php echo e($name); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
                <div class="mb-2"><i class="far fa-folder-open fa-2x"></i></div>
                Belum ada profil instruktur.
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php if($profiles->hasPages()): ?>
      <div class="card-footer d-flex flex-column flex-md-row align-items-md-center gap-2 justify-content-between">
        <div class="small text-muted">
          Menampilkan <?php echo e($profiles->firstItem()); ?>–<?php echo e($profiles->lastItem()); ?> dari <?php echo e($profiles->total()); ?> data
        </div>
        <div>
          <?php echo e($profiles->appends(request()->query())->links()); ?>

        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  /* ====== Scoped styling: halaman index instruktur ====== */
  .instructor-index .rounded-4{ border-radius: 1rem; }
  .instructor-index .object-fit-cover{ object-fit: cover; }
  .instructor-index .avatar-sm{ width:40px; height:40px; }

  /* Ruang & ritme */
  .instructor-index .card { overflow: hidden; }
  .instructor-index .table > :not(caption) > * > *{
    padding-top: .9rem;
    padding-bottom: .9rem;
    vertical-align: middle;
  }

  /* Header lengket agar nyaman saat scroll data panjang */
  .instructor-index thead.sticky-top { top: 0; z-index: 1; }

  /* Zebra rows halus */
  .instructor-index .table tbody tr:nth-child(odd){
    background-color: #fcfdff;
  }

  /* Badge lembut */
  .badge-soft-success{
    color:#0f5132; background:#d1e7dd; border-radius:999px; font-weight:700;
  }
  .badge-soft-secondary{
    color:#41464b; background:#e2e3e5; border-radius:999px; font-weight:700;
  }

  /* Input icon sedikit redup */
  .instructor-index .input-group-text i{ opacity:.65; }

  /* Responsif tombol di HP */
  @media (max-width: 576px){
    .instructor-index td.text-end .btn{
      margin-bottom: .25rem;
    }
    .instructor-index .btn-group{
      display: grid;
      grid-template-columns: 1fr;
      gap: .25rem;
    }
  }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/instructors/index.blade.php ENDPATH**/ ?>