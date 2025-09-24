<?php $__env->startSection('title', 'Tambah Data Course'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5 animate-fade-in">

  
  <div class="d-flex align-items-center mb-5 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow"
        style="background: linear-gradient(135deg, #3949ab, #1e88e5);">
        <i class="fas fa-plus-circle fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h3 fw-bold mb-2">Tambah Data Course</h1>
      <p class="text-muted fs-6">Silakan pilih jenis data yang ingin ditambahkan</p>
    </div>
  </div>

  
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <a href="<?php echo e(route('admin.course-categories.create.category')); ?>" class="text-decoration-none">
        <div class="card shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale animate-fade-up" style="animation-delay: 0.1s;">
          <div class="icon-circle bg-primary text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-folder-plus fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-2 text-primary">Tambah Kategori</h5>
          <p class="text-muted small mb-0">Buat kategori baru untuk course.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="<?php echo e(route('admin.course-levels.create')); ?>" class="text-decoration-none">
        <div class="card shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale animate-fade-up" style="animation-delay: 0.25s;">
          <div class="icon-circle bg-success text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-layer-group fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-2 text-success">Tambah Level</h5>
          <p class="text-muted small mb-0">Tentukan level seperti Pemula, Menengah, atau Lanjutan.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="<?php echo e(route('admin.course-prices.create')); ?>" class="text-decoration-none">
        <div class="card shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale animate-fade-up" style="animation-delay: 0.4s;">
          <div class="icon-circle bg-danger text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-money-bill-wave fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-2 text-danger">Tambah Rentang Harga</h5>
          <p class="text-muted small mb-0">Tentukan rentang harga seperti Rp1.000 – Rp10.000.</p>
        </div>
      </a>
    </div>
  </div>

  
  <div>
    <a href="<?php echo e(route('admin.course-categories.index')); ?>" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-arrow-left me-2"></i>Kembali ke Index
    </a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
  /* Hover shadow + scale effect */
  .hover-shadow:hover {
    box-shadow: 0 1.25rem 2.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-6px) scale(1.05);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .transition-scale {
    transition: transform 0.35s ease;
  }

  /* Icon circles */
  .icon-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .icon-circle-lg {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
  }

  /* Animations */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes bounceIcon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }

  .animate-fade-in {
    animation: fadeIn 0.6s ease forwards;
  }

  .animate-slide-up {
    animation: slideUp 0.7s ease forwards;
  }

  .animate-fade-up {
    opacity: 0;
    animation: fadeIn 0.75s ease forwards;
  }

  .animate-icon-bounce {
    animation: bounceIcon 1.5s infinite ease-in-out;
  }

  /* Typography tweaks */
  h5.fw-semibold {
    letter-spacing: 0.02em;
  }
  p.text-muted {
    line-height: 1.4;
  }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/course/categories/create.blade.php ENDPATH**/ ?>