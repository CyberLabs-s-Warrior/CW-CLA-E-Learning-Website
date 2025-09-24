<?php $__env->startSection('title', 'Tambah Konten About'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
      style="width: 40px; height: 40px;">
      <i class="fas fa-plus"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Konten About</h1>
    </div>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger rounded-3 shadow-sm">
    <ul class="mb-0">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><i class="fas fa-exclamation-circle me-1"></i><?php echo e($error); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <form action="<?php echo e(route('admin.about.store')); ?>" method="POST" enctype="multipart/form-data" id="createForm">
      <?php echo csrf_field(); ?>

      <div class="mb-4">
        <label class="form-label fw-semibold">Section</label>
        <input list="section-list" name="section"
        class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('section')); ?>"
        required>

        <datalist id="section-list">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($section); ?>">
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>

        <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

      </small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Judul <span class="text-muted">(opsional)</span></label>
        <input type="text" name="title" class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('title')); ?>">
        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

      </small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Deskripsi <span class="text-muted">(opsional)</span></label>
        <textarea name="description" id="editor" rows="4"
        class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

      </small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>


      <div class="mb-4">
        <label class="form-label fw-semibold">Gambar <span class="text-muted">(opsional)</span></label>
        <input type="file" name="image" class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

      </small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-4">
  <label class="form-label fw-semibold">Urutan Tampil <span class="text-muted">(opsional)</span></label>
  <input type="number" name="display_order" class="form-control rounded-3"
         value="<?php echo e(old('display_order', $content->display_order ?? null)); ?>" placeholder="Contoh: 1">
  <div class="form-text">Angka kecil tampil lebih atas. Kosongkan bila tidak perlu.</div>
</div>


      <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success rounded-pill px-4 me-2" id="submitBtn">
        <span id="btnText"><i class="fas fa-save me-2"></i>Simpan</span>
        </button>
        <a href="<?php echo e(route('admin.about.index')); ?>" class="btn btn-secondary rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
      </form>
    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
  <script>
    document.getElementById('createForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    btn.disabled = true;
    btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });

        ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });

    // Tombol submit loading
    document.getElementById('createForm').addEventListener('submit', function () {
      const btn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');

      btn.disabled = true;
      btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/about/create.blade.php ENDPATH**/ ?>