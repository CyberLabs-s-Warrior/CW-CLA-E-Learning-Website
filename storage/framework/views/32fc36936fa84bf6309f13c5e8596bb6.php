<?php $__env->startSection('title', 'Daftar Course'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
          style="width: 40px; height: 40px;">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Daftar Course</h1>
    </div>

    
    <div class="d-flex justify-content-end mb-3">
      <a href="<?php echo e(route('admin.course.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i>Tambah Course
      </a>
    </div>

    
    <form method="GET" action="<?php echo e(route('admin.course.index')); ?>" class="mb-3" style="max-width: 320px;">
      <div class="input-group">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Cari...">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

    
    <div class="card shadow-sm border-0 rounded-4 mb-4">
      <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.course.index')); ?>" class="row g-3 align-items-end">

          
          <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">

          
          <div class="col-md-3">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-select">
              <option value="">Semua</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                  <?php echo e($cat->category); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          
          <div class="col-md-3">
            <label class="form-label">Level</label>
            <select name="level" class="form-select">
              <option value="">Semua</option>
              <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($lvl->id); ?>" <?php echo e(request('level') == $lvl->id ? 'selected' : ''); ?>>
                  <?php echo e($lvl->level); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          
          <div class="col-md-3">
            <label class="form-label">Rentang Harga</label>
            <select name="price_range" class="form-select">
              <option value="">Semua</option>
              <option value="0-500000" <?php echo e(request('price_range') == '0-500000' ? 'selected' : ''); ?>>0 - 500rb</option>
              <option value="500000-1000000" <?php echo e(request('price_range') == '500000-1000000' ? 'selected' : ''); ?>>500rb - 1jt
              </option>
              <option value="1000000-2000000" <?php echo e(request('price_range') == '1000000-2000000' ? 'selected' : ''); ?>>1jt - 2jt
              </option>
              <option value="2000000-99999999" <?php echo e(request('price_range') == '2000000-99999999' ? 'selected' : ''); ?>>2jt+
              </option>
            </select>
          </div>

          
          <div class="col-md-3">
            <label class="form-label">Urutkan</label>
            <select name="sort" class="form-select">
              <option value="">Default</option>
              <option value="duration_asc" <?php echo e(request('sort') == 'duration_asc' ? 'selected' : ''); ?>>Durasi Terpendek</option>
              <option value="duration_desc" <?php echo e(request('sort') == 'duration_desc' ? 'selected' : ''); ?>>Durasi Terlama</option>
              <option value="students_desc" <?php echo e(request('sort') == 'students_desc' ? 'selected' : ''); ?>>Jumlah Siswa Terbanyak
              </option>
              <option value="students_asc" <?php echo e(request('sort') == 'students_asc' ? 'selected' : ''); ?>>Jumlah Siswa Tersedikit
              </option>
              <option value="rating_desc" <?php echo e(request('sort') == 'rating_desc' ? 'selected' : ''); ?>>Rating Tertinggi</option>
              <option value="rating_asc" <?php echo e(request('sort') == 'rating_asc' ? 'selected' : ''); ?>>Rating Terendah</option>
            </select>
          </div>

          
          <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
              <i class="fas fa-filter me-1"></i>Filter
            </button>
            <a href="<?php echo e(route('admin.course.index')); ?>" class="btn btn-outline-secondary rounded-pill px-4">
              <i class="fas fa-times me-1"></i>Reset
            </a>
          </div>

        </form>
      </div>
    </div>

    
    <?php if($courses->isEmpty()): ?>
      <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-info-circle"></i>
        <div>Belum ada data course.</div>
      </div>
    <?php endif; ?>

    
    <?php if($courses->isNotEmpty()): ?>
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Gambar</th>
                  <th>Course</th>
                  <th>Slug</th>
                  <th>Kategori</th>
                  <th>Level</th>
                  <th>Harga</th>
                  <th>Range Harga</th>
                  <th>Durasi</th>
                  <th>Jumlah Siswa</th>
                  <th>Rating</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td>
                      <?php if($course->img): ?>
                        <img src="<?php echo e(asset('storage/' . $course->img)); ?>" alt="" class="img-thumbnail rounded shadow-sm"
                          style="width: 60px; height: auto;">
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($course->name); ?></td>
                    <td><?php echo e($course->slug); ?></td>
                    <td><?php echo e($course->category->category ?? '-'); ?></td>
                    <td><?php echo e($course->level->level ?? '-'); ?></td>
                    <td>Rp<?php echo e(number_format($course->price)); ?></td>
                    <td>
                      <?php if($course->priceRange): ?>
                        Rp<?php echo e(number_format($course->priceRange->min_price)); ?> -
                        Rp<?php echo e(number_format($course->priceRange->max_price)); ?>

                      <?php else: ?>
                        <span class="text-muted">Tidak Masuk Range</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($course->formatted_duration): ?>
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm">
                          <i class="fas fa-clock me-1"></i> <?php echo e($course->formatted_duration); ?>

                        </span>
                      <?php else: ?>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">-</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($course->students_count); ?></td>
                    <td><?php echo e($course->rating); ?></td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.course.edit', $course)); ?>"
                          class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm" data-bs-toggle="tooltip">
                          <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="<?php echo e(route('admin.course.destroy', $course)); ?>" method="POST" class="d-inline"
                          id="delete-form-<?php echo e($course->id); ?>">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm btn-delete"
                            data-id="<?php echo e($course->id); ?>" data-name="<?php echo e($course->name); ?>" data-bs-toggle="tooltip">
                            <i class="fas fa-trash-alt me-1"></i>Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>

          
          <div class="mt-4 px-3">
            <?php echo e($courses->withQueryString()->links('vendor.pagination.bootstrap-5')); ?>

          </div>
        </div>
      </div>
    <?php endif; ?>
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

<?php $__env->startPush('scripts'); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Session Success
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
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseBlue 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      <?php endif; ?>

      // Session Error
      <?php if(session('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: <?php echo json_encode(session('error'), 15, 512) ?>,
          background: 'linear-gradient(145deg, #fff0f0, #fff8f8)',
          color: '#7f1d1d',
          iconColor: '#dc3545',
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
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      <?php endif; ?>

      // Error Validasi
      <?php if($errors->any()): ?>
        <?php $errorMessages = implode("<br>", $errors->all()); ?>
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          html: <?php echo json_encode($errorMessages, 15, 512) ?>,
          background: 'linear-gradient(145deg, #fff0f0, #fff8f8)',
          color: '#7f1d1d',
          iconColor: '#dc3545',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
            title: 'fw-bold fs-4 text-danger custom-swal-title',
            htmlContainer: 'mt-2 fs-6 custom-swal-text text-start',
            icon: 'custom-swal-icon'
          },
          didOpen: () => {
            const icon = document.querySelector('.custom-swal-icon');
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      <?php endif; ?>

      // Modal hapus
      let deleteForm = null;
      document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function () {
          const courseId = this.dataset.id;
          const courseName = this.dataset.name;
          deleteForm = document.getElementById(`delete-form-${courseId}`);
          document.getElementById("itemToDelete").textContent = courseName;
          const modal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
          modal.show();
        });
      });

      document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
        if (deleteForm) {
          document.getElementById("deleteSpinner").classList.remove("d-none");
          document.getElementById("deleteBtnText").textContent = "Menghapus...";
          deleteForm.submit();
        }
      });
    });
  </script>

  <style>
    @keyframes bounceInIcon {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }

      60% {
        transform: scale(1.2);
        opacity: 1;
      }

      100% {
        transform: scale(1);
      }
    }

    @keyframes fadeZoomOut {
      0% {
        transform: scale(1);
        opacity: 1;
      }

      100% {
        transform: scale(0.9);
        opacity: 0;
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

    @keyframes pulseRed {
      0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.6);
      }

      70% {
        box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
      }
    }
  </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/course/list/index.blade.php ENDPATH**/ ?>