<?php $__env->startSection('title', 'Daftar Kursus Detail'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">

  
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-gradient-primary text-black rounded-circle d-flex align-items-center justify-content-center shadow"
        style="width:48px;height:48px;">
        <i class="fas fa-book-open"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-0">Manajemen Kursus Detail</h1>
      <p class="text-muted small mb-0">Kelola kursus, mentor, dan modul pembelajaran</p>
    </div>
  </div>

  
  <div class="d-flex justify-content-end mb-3">
    <a href="<?php echo e(route('admin.detail.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Kursus
    </a>
  </div>

  
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
      <form method="GET" action="<?php echo e(route('admin.detail.index')); ?>" class="row g-3 align-items-end">

        
        <div class="col-md-4">
          <label class="form-label fw-semibold">Cari Kursus</label>
          <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
            class="form-control rounded-pill shadow-sm" placeholder="Judul / Mentor">
        </div>

        
        <div class="col-md-3">
          <label class="form-label fw-semibold">Level</label>
          <select name="level" class="form-select rounded-pill shadow-sm">
            <option value="">Semua</option>
            <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($level->id); ?>" <?php echo e(request('level') == $level->id ? 'selected' : ''); ?>>
                <?php echo e($level->level); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        
        <div class="col-md-3">
          <label class="form-label fw-semibold">Urutkan Durasi</label>
          <select name="sort" class="form-select rounded-pill shadow-sm">
            <option value="">Default</option>
            <option value="shortest" <?php echo e(request('sort') == 'shortest' ? 'selected' : ''); ?>>Terpendek</option>
            <option value="longest" <?php echo e(request('sort') == 'longest' ? 'selected' : ''); ?>>Terpanjang</option>
          </select>
        </div>

        
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary rounded-pill w-100 shadow-sm">
            <i class="fas fa-filter me-1"></i> Filter
          </button>
          <a href="<?php echo e(route('admin.detail.index')); ?>" class="btn btn-light border rounded-pill w-100 shadow-sm">
            <i class="fas fa-undo me-1"></i> Reset
          </a>
        </div>
      </form>
    </div>
  </div>

  
  <?php if(session('success')): ?>
    <script>
      document.addEventListener('DOMContentLoaded', () => Swal.fire({
        icon: 'success', title: 'Berhasil!', text: <?php echo json_encode(session('success'), 15, 512) ?>,
        timer: 2500, timerProgressBar: true, showConfirmButton: false,
        background: '#f8fbff', color: '#1e3a8a', iconColor: '#0d6efd',
        customClass: { popup: 'rounded-4 shadow-lg p-4', title: 'fw-bold fs-4 text-primary', htmlContainer: 'mt-2 fs-6' }
      }));
    </script>
  <?php endif; ?>

  
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      <?php if($details->count()): ?>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="bg-light text-secondary small text-uppercase">
              <tr>
                <th>No</th>
                <th>Media</th>
                <th>Judul</th>
                <th>Level</th>
                <th>Durasi</th>
                <th>Modul</th>
                <th>Mentor</th>
                <th>Deskripsi</th>
                <th>Hasil</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover-bg-light">
                  
                  <td><?php echo e($loop->iteration + ($details->currentPage() - 1) * $details->perPage()); ?></td>

                  
                  <td>
                    <?php if($detail->course->img): ?>
                      <img src="<?php echo e(asset('storage/' . $detail->course->img)); ?>" alt="cover" 
                        class="rounded shadow-sm" style="width:60px; height:60px; object-fit:cover;">
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  
                  <td class="fw-semibold"><?php echo e(\Illuminate\Support\Str::limit($detail->course->name ?? '-', 40)); ?></td>

                  
                  <td>
                    <span class="badge rounded-pill bg-info text-dark">
                      <?php echo e($detail->course->level->level ?? 'N/A'); ?>

                    </span>
                  </td>

                  
                  <td>
                    <?php if($detail->total_duration): ?>
                      <span class="badge bg-light text-dark border">
                        <?php echo e(gmdate('H:i:s', $detail->total_duration)); ?>

                      </span>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>

                  
                  <td><?php echo e($detail->course->lessons->count()); ?></td>

                  
                  <td>
                    <?php if($detail->instructors->isNotEmpty()): ?>
                      <?php $__currentLoopData = $detail->instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-primary-subtle text-primary fw-semibold">
                          <?php echo e($ins->user->name); ?>

                        </span>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  
                  <td><?php echo \Illuminate\Support\Str::limit($detail->description, 75); ?></td>

                  
                  <td><?php echo \Illuminate\Support\Str::limit($detail->outcomes, 75); ?></td>

                  
                  <td class="text-center">
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                      <a href="<?php echo e(route('admin.detail.show', $detail)); ?>" 
                        class="btn btn-sm btn-outline-info rounded-pill px-3"><i class="fas fa-eye"></i></a>
                      <a href="<?php echo e(route('admin.detail.edit', $detail)); ?>" 
                        class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="fas fa-edit"></i></a>
                      <button class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#modalHapus<?php echo e($detail->id); ?>"><i class="fas fa-trash-alt"></i></button>
                    </div>
                  </td>
                </tr>

                
                <div class="modal fade" id="modalHapus<?php echo e($detail->id); ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow">
                      <div class="modal-header border-0">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus kursus
                          <strong><?php echo e($detail->course->name ?? '-'); ?></strong>?
                        </p>
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-3"
                          data-bs-dismiss="modal">Batal</button>
                        <form action="<?php echo e(route('admin.detail.destroy', $detail)); ?>" method="POST"
                          onsubmit="return showSpinner(this,<?php echo e($detail->id); ?>)">
                          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                          <button type="submit" class="btn btn-danger rounded-pill px-3 d-flex align-items-center gap-2"
                            id="btnDelete<?php echo e($detail->id); ?>">
                            <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner<?php echo e($detail->id); ?>"></span>
                            <span>Ya, Hapus</span>
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <div class="mt-4 px-3"><?php echo e($details->links('vendor.pagination.bootstrap-5')); ?></div>
      <?php else: ?>
        <div class="alert alert-light border d-flex align-items-center gap-2 mb-0 rounded-3 shadow-sm">
          <i class="fas fa-info-circle text-secondary"></i> 
          <span>Belum ada data kursus detail.</span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function showSpinner(form, id) {
    const btn = form.querySelector('#btnDelete' + id),
          spinner = form.querySelector('#spinner' + id),
          text = btn.querySelector('span:last-child');
    spinner.classList.remove('d-none');
    text.textContent = 'Menghapus...';
    btn.disabled = true;
    return true;
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/detail/index.blade.php ENDPATH**/ ?>