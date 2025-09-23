<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="fw-bold mb-0 d-flex align-items-center">
                <span class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center me-2"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-people-fill" style="color: #0d6efd; font-size: 1.2rem;"></i>
                </span>
                Manajemen User
            </h4>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah User
            </a>
        </div>

        
        <form method="GET" id="filter-form" class="mb-4 d-flex flex-wrap gap-3 align-items-end">
            <div>
                <label for="role" class="form-label mb-1">Filter Role</label>
                <select name="role" id="role" class="form-select"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">-- Semua Role --</option>
                    <?php $__currentLoopData = ['superadmin', 'admin', 'instructor', 'student']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($roleItem); ?>" <?php echo e(request('role') == $roleItem ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($roleItem)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="permission" class="form-label mb-1">Filter Akses</label>
                <select name="permission" id="permission" class="form-select"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">-- Semua Akses --</option>
                    <?php $__currentLoopData = $allPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($perm->name); ?>" <?php echo e(request('permission') == $perm->name ? 'selected' : ''); ?>>
                            <?php echo e(str_replace('_', ' ', ucfirst($perm->name))); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="search" class="form-label mb-1">Cari Nama</label>
                <div class="input-group">
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" class="form-control"
                        placeholder="Masukkan nama...">
                    <button type="submit" class="btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        
        <?php if(request()->filled('role') || request()->filled('permission') || request()->filled('search')): ?>
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan user
                    <?php if(request()->filled('search')): ?>
                        dengan nama mengandung: <strong>"<?php echo e(request('search')); ?>"</strong>
                    <?php endif; ?>
                    <?php if(request()->filled('role')): ?>
                        <?php if(request()->filled('search')): ?> dan <?php endif; ?>
                        role: <strong><?php echo e(ucfirst(request('role'))); ?></strong>
                    <?php endif; ?>
                    <?php if(request()->filled('permission')): ?>
                        <?php if(request()->filled('role') || request()->filled('search')): ?> dan <?php endif; ?>
                        akses: <strong><?php echo e(str_replace('_', ' ', request('permission'))); ?></strong>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        <?php endif; ?>

        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle shadow-sm rounded overflow-hidden">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width: 20%">Role & Akses</th>
                        <th>Dibuat</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e(($users->currentPage() - 1) * $users->perPage() + $index + 1); ?></td>
                            <td>
                                <img src="<?php echo e(asset('storage/' . $user->foto)); ?>" width="50" height="50" class="rounded-circle">
                            </td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <div class="mb-2">
                                    <?php
                                        $roleColors = [
                                            'superadmin' => 'bg-danger',
                                            'admin' => 'bg-primary',
                                            'instructor' => 'bg-info',
                                            'student' => 'bg-bright-green'
                                        ];
                                    ?>

                                    <style>
                                        .bg-bright-green {
                                            background-color: #28e36d !important;
                                            /* hijau cerah custom */
                                            color: #fff !important;
                                        }
                                    </style>

                                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge <?php echo e($roleColors[$role->name] ?? 'bg-secondary'); ?> text-white me-1">
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <?php
                                    $permissions = $user->getAllPermissions()->pluck('name')->toArray();
                                ?>

                                <?php if(!$user->hasRole('superadmin') && $permissions): ?>
                                    <button class="btn btn-sm btn-outline-secondary collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#perm-<?php echo e($user->id); ?>" aria-expanded="false"
                                        aria-controls="perm-<?php echo e($user->id); ?>">
                                        <i class="bi bi-eye me-1"></i> Tampilkan Akses
                                    </button>
                                    <div class="collapse mt-2" id="perm-<?php echo e($user->id); ?>">
                                        <div class="border rounded p-2 bg-light">
                                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-secondary text-light me-1 mb-1">
                                                    <?php echo e(str_replace('_', ' ', $permission)); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i')); ?></td>
                            <td class="text-center">
                                <?php if(!($user->is_superadmin && auth()->id() !== $user->id)): ?>
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-warning me-1"
                                        data-bs-toggle="tooltip" title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (! ($user->is_superadmin)): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST"
                                        class="d-inline form-delete" data-nama="<?php echo e($user->name); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip"
                                            title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada user</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-3">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(el => new bootstrap.Tooltip(el));

            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = button.closest('.form-delete');
                    const nama = form.getAttribute('data-nama');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `User "${nama}" akan dihapus secara permanen.`,
                        icon: 'warning',
                        background: 'linear-gradient(145deg, #e6f0ff, #f8fbff)',
                        color: '#1e3a8a',
                        iconColor: '#0d6efd',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Ya, hapus!',
                        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                        customClass: {
                            popup: 'rounded-4 shadow-lg border-0 p-3',
                            title: 'fw-bold fs-4 text-primary',
                            htmlContainer: 'mt-2 fs-6',
                            confirmButton: 'px-4 py-2 rounded-pill shadow-sm',
                            cancelButton: 'px-4 py-2 rounded-pill shadow-sm'
                        },
                        preConfirm: () => {
                            Swal.showLoading();
                            return new Promise((resolve) => {
                                setTimeout(resolve, 500);
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
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
                from { opacity: 1; transform: scale(1); }
                to { opacity: 0; transform: scale(0.85); }
            }

            @keyframes fadeZoomIn {
                from { opacity: 0; transform: scale(0.85); }
                to { opacity: 1; transform: scale(1); }
            }

            @keyframes bounceInIcon {
                0% { transform: translateY(50px) scale(0.8); opacity: 0; }
                60% { transform: translateY(-10px) scale(1.05); opacity: 1; }
                100% { transform: translateY(0) scale(1); }
            }

            @keyframes pulseBlue {
                0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6); }
                70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
                100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
            }

            .custom-swal-title {
                animation: fadeInDown 0.5s ease 0.2s both;
            }

            .custom-swal-text {
                animation: fadeInUp 0.5s ease 0.4s both;
            }

            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/users/index.blade.php ENDPATH**/ ?>