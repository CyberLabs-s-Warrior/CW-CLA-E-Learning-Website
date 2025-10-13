<?php $__env->startSection('title', 'Tambah User'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4 fw-bold">Tambah User</h4>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    
                    <form id="createForm" action="<?php echo e(route('admin.users.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Nama lengkap"
                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                value="<?php echo e(old('name')); ?>">
                            <?php $__errorArgs = ['name'];
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

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['foto'];
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

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email aktif"
                                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                value="<?php echo e(old('email')); ?>">
                            <?php $__errorArgs = ['email'];
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

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__errorArgs = ['password'];
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

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role); ?>" <?php echo e(old('role') == $role ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($role)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4" id="permission-wrapper" style="display: none;">
                            <label class="form-label fw-bold">Akses / Permissions</label>
                            <div class="row">
                               <?php
  $grouped = [];
  foreach ($permissions as $permission) {
      $parts = explode('_', $permission->name);
      $fitur = end($parts);
      $grouped[$fitur][] = $permission;
  }
?>

<div class="row">
<?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fitur => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="col-md-4 mb-3">
    <div class="border rounded p-3 bg-light">
      <strong class="text-uppercase small text-muted d-block mb-2"><?php echo e(ucfirst($fitur)); ?></strong>

      <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $name = $permission->name; ?>
        <div class="form-check mb-2 d-flex align-items-center gap-2">
          <input type="checkbox"
                 name="permissions[]"
                 value="<?php echo e($name); ?>"
                 id="perm_<?php echo e($name); ?>"
                 class="form-check-input">
          <label class="form-check-label small d-flex align-items-center gap-1" for="perm_<?php echo e($name); ?>">
            <?php echo e(ucwords(str_replace('_', ' ', $name))); ?>

            
            <span class="badge bg-secondary text-light ms-1 via-role-badge d-none">via role</span>
          </label>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<small class="text-muted d-block mt-2">
  Catatan: centang di sini menambahkan <em>direct permission</em> ke akun. 
  Permission yang berasal dari <strong>role</strong> tetap berlaku meski kotak ini tidak dicentang.
  Untuk mencabut akses yang datang dari role, ubah permission di Role-nya.
</small>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const permissionWrapper = document.getElementById('permission-wrapper');
    const checkboxes = permissionWrapper.querySelectorAll('input[type="checkbox"]');

    const rolePermissions = <?php echo json_encode($rolePermissions, 15, 512) ?>;

    function togglePermissions() {
        const selectedRole = roleSelect.value;
        if (selectedRole && rolePermissions[selectedRole]) {
            permissionWrapper.style.display = 'block';
            checkboxes.forEach(cb => cb.checked = false);
            rolePermissions[selectedRole].forEach(name => {
                const checkbox = document.getElementById(`perm_${name}`);
                if (checkbox) checkbox.checked = true;
            });
        } else {
            permissionWrapper.style.display = 'none';
            checkboxes.forEach(cb => cb.checked = false);
        }
    }

    togglePermissions();
    roleSelect.addEventListener('change', togglePermissions);
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const originalBtnHtml = btnSubmit.innerHTML;

    if (form && btnSubmit) {
        form.addEventListener('submit', function () {
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Menyimpan...
            `;

            // Jika submit gagal (misalnya validasi server), tombol kembali normal
            setTimeout(() => {
                if (document.querySelectorAll('.alert-danger').length > 0) {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = originalBtnHtml;
                }
            }, 500);
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const roleSelect = document.getElementById('role');
  const permissionWrapper = document.getElementById('permission-wrapper');
  const rolePermissions = <?php echo json_encode($rolePermissions, 15, 512) ?>; // { admin: [...], instructor: [...] }

  function togglePermissions() {
    const selectedRole = roleSelect.value;
    const viaRole = new Set(rolePermissions[selectedRole] || []);

    if (!selectedRole) {
      permissionWrapper.style.display = 'none';
      return;
    }

    permissionWrapper.style.display = 'block';

    // Iterasi semua checkbox
    permissionWrapper.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(cb => {
      const name = cb.value;

      // 1) JANGAN dikunci: semua checkbox tetap bisa diklik
      cb.disabled = false;

      // 2) Default state: pre-check yang via role supaya admin paham defaultnya
      //    (kalau mau: kamu bisa set false agar hanya info badge yang tampil)
      cb.checked = viaRole.has(name);

      // 3) Tampilkan/hilangkan badge "via role" untuk transparansi
      const badge = cb.closest('.form-check')?.querySelector('.via-role-badge');
      if (badge) {
        if (viaRole.has(name)) {
          badge.classList.remove('d-none');
        } else {
          badge.classList.add('d-none');
        }
      }
    });
  }

  togglePermissions();
  roleSelect.addEventListener('change', togglePermissions);
});
</script>



<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/users/create.blade.php ENDPATH**/ ?>