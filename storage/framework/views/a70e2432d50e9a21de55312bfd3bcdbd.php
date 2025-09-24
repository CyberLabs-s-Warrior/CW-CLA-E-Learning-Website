
<?php $__env->startSection('title','Forum — Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

  
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 fw-bold text-dark">Kategori Forum</h1>
    <a href="<?php echo e(route('admin.forum.categories.create')); ?>" class="btn btn-primary shadow-sm">
      <i class="fa fa-plus me-1"></i> Tambah Kategori
    </a>
  </div>

  
  <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
      <i class="fa fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  
  <div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-semibold">
      Daftar Kategori
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-secondary">
            <tr>
              <th>Nama</th>
              <th>Slug</th>
              <th>Urutan</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td class="fw-medium"><?php echo e($c->name); ?></td>
                <td><span class="text-muted"><?php echo e($c->slug); ?></span></td>
                <td><?php echo e($c->sort_order); ?></td>
                <td>
                  <?php if($c->is_private): ?>
                    <span class="badge bg-danger">Privat</span>
                  <?php else: ?>
                    <span class="badge bg-success">Publik</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-warning text-white" 
                       href="<?php echo e(route('admin.forum.categories.edit',$c)); ?>">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" 
                          action="<?php echo e(route('admin.forum.categories.destroy',$c)); ?>" 
                          onsubmit="return confirm('Arsipkan kategori ini?')">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fa fa-folder-open me-2"></i> Belum ada kategori.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <?php echo e($categories->links()); ?>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/forum/categories/index.blade.php ENDPATH**/ ?>