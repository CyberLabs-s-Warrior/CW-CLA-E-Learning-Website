<?php $__env->startSection('title', 'Kelola Konten About'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center"
      style="width: 40px; height: 40px;">
      <i class="fas fa-info-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Kelola Konten About</h1>
    </div>

    <div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <form method="GET" action="<?php echo e(route('admin.about.index')); ?>" id="filter-form"
      class="d-flex align-items-end gap-3 flex-wrap">
      
      <div>
      <label for="section" class="form-label mb-1 fw-semibold">Filter Section:</label>
      <select name="section" id="section" class="form-select shadow-sm rounded-3" onchange="this.form.submit()">
        <option value="">-- Semua Section --</option>
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($section); ?>" <?php echo e(request('section') == $section ? 'selected' : ''); ?>>
      <?php echo e($section); ?>

      </option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      </div>


<div>
  <label for="search" class="form-label mb-1">Cari Nama</label>
  <div class="input-group">
    <input
      type="text"
      name="search"
      id="search"
      value="<?php echo e(request('search')); ?>"
      class="form-control"
      placeholder="Masukkan nama..."
    >
    <button type="submit" class="btn">
      <i class="fas fa-search"></i>
    </button>
  </div>
</div>


    </form>

    <a href="<?php echo e(route('admin.about.create')); ?>" class="btn btn-primary rounded-pill px-4">
      <i class="fas fa-plus me-2"></i>Tambah Konten
    </a>
    </div>

    
    <?php if(request()->filled('section') || request()->filled('search')): ?>
    <div class="alert alert-info d-flex justify-content-between align-items-center mb-3 rounded-3">
    <div>
      Menampilkan konten
      <?php if(request()->filled('section')): ?>
      dengan section: <strong><?php echo e(request('section')); ?></strong>
    <?php endif; ?>
      <?php if(request()->filled('search')): ?>
      <?php if(request()->filled('section')): ?> dan <?php endif; ?>
      judul mengandung: <strong>"<?php echo e(request('search')); ?>"</strong>
    <?php endif; ?>
    </div>
    <a href="<?php echo e(route('admin.about.index')); ?>" class="btn btn-sm btn-secondary">Reset</a>
    </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: <?php echo json_encode(session('success'), 15, 512) ?>,
      confirmButtonColor: '#3085d6',
      timer: 2500,
      timerProgressBar: true,
      showConfirmButton: false,
      });
    });
    </script>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
        <tr>
          <th>Section</th>
          <th>Judul</th>
          <th>Deskripsi</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
        <td><?php echo e($content->section); ?></td>
        <td><?php echo e($content->title ?? '-'); ?></td>
        <td><?php echo Str::limit($content->description ?? '-', 50); ?></td>
        <td>
        <?php if($content->image): ?>
        <img src="<?php echo e(asset('storage/' . $content->image)); ?>" width="60" class="img-thumbnail rounded">
      <?php else: ?>
        <span class="text-muted">-</span>
      <?php endif; ?>
        </td>
        <td>
        <div class="d-flex flex-wrap gap-1">
          <a href="<?php echo e(route('admin.about.edit', $content->id)); ?>"
          class="btn btn-sm btn-outline-warning rounded-pill px-3 me-2">
          <i class="fas fa-edit me-1"></i>Edit
          </a>

          <form action="<?php echo e(route('admin.about.destroy', $content->id)); ?>" method="POST"
          id="delete-form-<?php echo e($content->id); ?>">
          <?php echo csrf_field(); ?>
          <?php echo method_field('DELETE'); ?>
          <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-2"
          onclick="confirmDelete(<?php echo e($content->id); ?>, '<?php echo e($content->title ?? 'konten ini'); ?>')">
          <i class="fas fa-trash-alt me-1"></i>Hapus
          </button>
          </form>
        </div>
        </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="5" class="text-center text-muted py-4">
        <i class="fas fa-info-circle me-2"></i>Belum ada konten.
        </td>
      </tr>
      <?php endif; ?>
        </tbody>
      </table>
      </div>

      <div class="mt-4">
      <?php echo e($contents->withQueryString()->links('vendor.pagination.bootstrap-5')); ?>

      </div>
    </div>
    </div>
  </div>

  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0">
      <h5 class="modal-title fw-semibold" id="deleteConfirmModalLabel">
        <i class="fas fa-trash-alt me-2 text-danger"></i>Konfirmasi Hapus
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
      <p class="mb-0">Apakah Anda yakin ingin menghapus <span id="itemToDelete" class="fw-bold text-danger"></span>?
      </p>
      </div>
      <div class="modal-footer border-0">
      <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-danger rounded-pill px-4 d-flex align-items-center gap-2"
        id="confirmDeleteBtn">
        <span class="spinner-border spinner-border-sm d-none" id="deleteSpinner" role="status"
        aria-hidden="true"></span>
        <span id="deleteBtnText">Ya, Hapus</span>
      </button>
      </div>
    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script>
    let deleteFormId = null;

    function confirmDelete(id, title) {
    deleteFormId = `delete-form-${id}`;
    document.getElementById('itemToDelete').textContent = title;

    // Reset spinner & button
    document.getElementById('deleteSpinner').classList.add('d-none');
    document.getElementById('deleteBtnText').textContent = 'Ya, Hapus';
    document.getElementById('confirmDeleteBtn').disabled = false;

    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (!deleteFormId) return;

    const spinner = document.getElementById('deleteSpinner');
    const btnText = document.getElementById('deleteBtnText');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    spinner.classList.remove('d-none');
    btnText.textContent = 'Menghapus...';
    confirmBtn.disabled = true;

    setTimeout(() => {
      document.getElementById(deleteFormId).submit();
    }, 500);
    });
  </script>

  <?php if(session('success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: <?php echo json_encode(session('success'), 15, 512) ?>,
      background: 'linear-gradient(145deg, #e6f0ff, #f8fbff)',
      color: '#1e3a8a',
      iconColor: '#0d6efd',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true,
      customClass: {
      popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
      title: 'fw-bold fs-4 text-primary custom-swal-title',
      htmlContainer: 'mt-2 fs-6 custom-swal-text',
      icon: 'custom-swal-icon'
      },
      didOpen: () => {
      const icon = document.querySelector('.custom-swal-icon');
      if (icon) {
      icon.style.animation = 'bounceInIcon 0.6s ease, pulseBlue 1.5s infinite';
      }
      },
      willClose: () => {
      const popup = document.querySelector('.custom-swal-popup');
      if (popup) {
      popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
      }
      }
    });
    });
    </script>

    <style>
    .custom-swal-popup {
    animation: fadeZoomIn 0.45s ease;
    backdrop-filter: blur(6px);
    }

    @keyframes fadeZoomOut {
    from {
      opacity: 1;
      transform: scale(1);
    }

    to {
      opacity: 0;
      transform: scale(0.85);
    }
    }

    @keyframes fadeZoomIn {
    from {
      opacity: 0;
      transform: scale(0.85);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
    }

    @keyframes bounceInIcon {
    0% {
      transform: translateY(50px) scale(0.8);
      opacity: 0;
    }

    60% {
      transform: translateY(-10px) scale(1.05);
      opacity: 1;
    }

    100% {
      transform: translateY(0) scale(1);
    }
    }

    @keyframes pulseBlue {
    0% {
      box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6);
    }

    70% {
      box-shadow: 0 0 0 15px rgba(13, 110, 253, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
    }

    .custom-swal-title {
    animation: fadeInDown 0.5s ease 0.2s both;
    }

    .custom-swal-text {
    animation: fadeInUp 0.5s ease 0.4s both;
    }

    @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
    }

    @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
    }
    </style>
  <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/about/index.blade.php ENDPATH**/ ?>