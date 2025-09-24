<?php $__env->startSection('title', 'Tambah Course'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
  
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-plus-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Course Baru</h1>
  </div>

  
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form id="addCourseForm" action="<?php echo e(route('admin.course.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
        <?php echo csrf_field(); ?>

        <div class="col-md-6">
          <label for="name" class="form-label fw-semibold">Nama Course</label>
          <input type="text" name="name" id="name" class="form-control shadow-sm" required>
        </div>

        <div class="col-md-6">
          <label for="course_category_id" class="form-label fw-semibold">Kategori</label>
          <select name="course_category_id" id="course_category_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih category --</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="course_level_id" class="form-label fw-semibold">Level</label>
          <select name="course_level_id" id="course_level_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih level --</option>
            <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($level->id); ?>"><?php echo e($level->level); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="price" class="form-label fw-semibold">Harga</label>
          <input type="number" name="price" id="price" class="form-control shadow-sm" required>
        </div>

        <div class="col-md-6">
          <label for="img" class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="img" id="img" class="form-control shadow-sm">
        </div>

        
        <div class="col-12 d-flex gap-2 mt-4">
          <button id="submitBtn" type="submit" class="btn btn-success rounded-pill px-4 d-flex align-items-center">
            <i class="fas fa-save me-2"></i>
            <span class="btn-text">Simpan</span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
          </button>
          <a href="<?php echo e(route('admin.course.index')); ?>" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert success
    <?php if(session('success')): ?>
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
    <?php endif; ?>

    // SweetAlert error umum
    <?php if(session('error')): ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: <?php echo json_encode(session('error'), 15, 512) ?>,
        background: 'linear-gradient(145deg, #ffe6e6, #fff8f8)',
        color: '#7f1d1d',
        iconColor: '#dc2626',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
          title: 'fw-bold fs-4 text-danger custom-swal-title',
          htmlContainer: 'mt-2 fs-6 custom-swal-text',
          icon: 'custom-swal-icon'
        },
        didOpen: () => {
          const icon = document.querySelector('.custom-swal-icon');
          if (icon) {
            icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          }
        },
        willClose: () => {
          const popup = document.querySelector('.custom-swal-popup');
          if (popup) {
            popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        }
      });
    <?php endif; ?>

    // SweetAlert untuk error validasi
    <?php if($errors->any()): ?>
      <?php
        $errorMessages = implode('<br>', $errors->all());
      ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        html: <?php echo json_encode($errorMessages, 15, 512) ?>,
        background: 'linear-gradient(145deg, #ffe6e6, #fff8f8)',
        color: '#7f1d1d',
        iconColor: '#dc2626',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
          title: 'fw-bold fs-4 text-danger custom-swal-title',
          htmlContainer: 'mt-2 fs-6 custom-swal-text',
          icon: 'custom-swal-icon'
        },
        didOpen: () => {
          const icon = document.querySelector('.custom-swal-icon');
          if (icon) {
            icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          }
        },
        willClose: () => {
          const popup = document.querySelector('.custom-swal-popup');
          if (popup) {
            popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        }
      });
    <?php endif; ?>

    // Spinner loading on submit
    const form = document.getElementById('addCourseForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      spinner.classList.remove('d-none');
      btnText.textContent = 'Menyimpan...';
    });
  });
</script>

<style>
@keyframes bounceInIcon {
  0% { transform: scale(0.3); opacity: 0; }
  50% { transform: scale(1.05); opacity: 1; }
  70% { transform: scale(0.9); }
  100% { transform: scale(1); }
}
@keyframes pulseBlue {
  0%, 100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6); }
  50% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
}
@keyframes pulseRed {
  0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.6); }
  50% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
}
@keyframes fadeZoomOut {
  to { transform: scale(0.85); opacity: 0; }
}
</style>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/course/list/create.blade.php ENDPATH**/ ?>