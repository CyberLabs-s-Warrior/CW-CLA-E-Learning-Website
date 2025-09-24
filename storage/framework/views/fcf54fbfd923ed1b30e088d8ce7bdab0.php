<?php $__env->startSection('title', 'Tambah Kategori Course'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 animate-fade-in">

  
  <div class="d-flex align-items-center mb-4 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow" style="background: linear-gradient(135deg, #81d4fa, #29b6f6);">
        <i class="fas fa-folder-plus fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-1">Tambah Kategori Course</h1>
      <p class="text-muted mb-0">Masukkan nama kategori course yang ingin ditambahkan</p>
    </div>
  </div>

  
  <form id="categoryForm" action="<?php echo e(route('admin.course-categories.store.category')); ?>" method="POST" class="animate-fade-up">
    <?php echo csrf_field(); ?>

    <div class="mb-3">
      <label for="category" class="form-label fw-semibold">Nama Kategori</label>
      <input
        type="text"
        name="category"
        id="category"
        class="form-control shadow-sm rounded-3 <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        placeholder="Contoh: Programming"
        required
      >
      <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="mt-3 d-flex align-items-center gap-2">
      <button
        id="submitBtn"
        type="submit"
        class="btn btn-primary rounded-pill px-4 d-flex align-items-center"
      >
        <i class="fas fa-save me-2"></i>
        <span class="btn-text">Simpan</span>
        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
      </button>
      <a href="<?php echo e(route('admin.course-categories.create')); ?>" class="btn btn-secondary rounded-pill px-4 d-flex align-items-center">
        <i class="fas fa-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
  .icon-circle-lg {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #81d4fa, #29b6f6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  /* Animasi */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in {
    animation: fadeIn 0.6s ease-in-out both;
  }

  .animate-slide-up {
    animation: slideUp 0.6s ease-in-out both;
  }

  .animate-fade-up {
    opacity: 0;
    animation: fadeIn 0.5s ease-in-out forwards;
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  document.getElementById('categoryForm').addEventListener('submit', function () {
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Menyimpan...';
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/course/categories/create_category.blade.php ENDPATH**/ ?>