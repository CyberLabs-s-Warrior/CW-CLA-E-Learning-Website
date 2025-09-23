<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4 fw-bold">Edit User</h4>

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

                    <form id="editUserForm" action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                   value="<?php echo e(old('name', $user->name)); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil (opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required
                                   value="<?php echo e(old('email', $user->email)); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin diubah)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <?php if(!$user->hasRole('superadmin')): ?>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="">-- Pilih Role --</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role); ?>" <?php echo e($user->hasRole($role) ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($role)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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

                                    <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fitur => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="border rounded p-3 bg-light">
                                                <strong class="text-uppercase small text-muted d-block mb-2">
                                                    <?php echo e(ucfirst($fitur)); ?>

                                                </strong>
                                                <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="<?php echo e($permission->name); ?>"
                                                               class="form-check-input"
                                                               id="perm_<?php echo e($permission->name); ?>"
                                                               <?php echo e($user->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label small"
                                                               for="perm_<?php echo e($permission->name); ?>">
                                                            <?php echo e(ucwords(str_replace('_', ' ', $permission->name))); ?>

                                                        </label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" id="btnSubmit" class="btn btn-primary">
                                <span id="btnText"><i class="bi bi-save me-1"></i> Update</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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

        function togglePermissions() {
            if (roleSelect && (roleSelect.value === 'admin' || roleSelect.value === 'instructor')) {
                permissionWrapper.style.display = 'block';
            } else {
                permissionWrapper.style.display = 'none';
                permissionWrapper.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        }

        togglePermissions();
        if (roleSelect) {
            roleSelect.addEventListener('change', togglePermissions);
        }

        // Spinner saat submit
        const form = document.getElementById('editUserForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function () {
            btnSubmit.disabled = true;
            btnText.textContent = 'Menyimpan...';
            btnSpinner.classList.remove('d-none');
        });
    });
</script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>