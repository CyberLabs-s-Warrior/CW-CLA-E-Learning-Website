 

<?php $__env->startSection('content'); ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Testimoni</h1>
    <a href="<?php echo e(route('admin.testimoni.create')); ?>" class="btn btn-primary">Tambah</a>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">  
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Student</th>
              <th>Ulasan</th>
              <th>Publish</th>
              <th style="width:180px"></th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <?php
                $name = $row->user->name ?? '-';
                $parts = preg_split('/\s+/', trim($name));
                $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
                $hue = crc32($name) % 360;
              ?>
              <tr>
                <td><?php echo e($items->firstItem() + $i); ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width:34px;height:34px;background:hsl(<?php echo e($hue); ?> 85% 90%);font-weight:700;">
                      <?php echo e($initials); ?>

                    </div>
                    <?php echo e($name); ?>

                  </div>
                </td>
                <td><?php echo e(\Illuminate\Support\Str::limit($row->content, 90)); ?></td>
                <td>
                  <span class="badge bg-<?php echo e($row->is_published ? 'success' : 'secondary'); ?>">
                    <?php echo e($row->is_published ? 'Ya' : 'Tidak'); ?>

                  </span>
                </td>
                <td class="text-end">
                <a href="<?php echo e(route('admin.testimoni.edit', ['testimoni' => $row])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  
                <form action="<?php echo e(route('admin.testimoni.destroy', ['testimoni' => $row])); ?>" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus testimoni ini?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
                                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="5" class="text-center text-muted p-4">Belum ada data</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php if($items instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
      <div class="card-footer"><?php echo e($items->links()); ?></div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/testimoni/index.blade.php ENDPATH**/ ?>