<?php $__env->startSection('title', 'Daftar Materi'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 44px; height: 44px;">
          <i class="fas fa-book-open"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Daftar Materi</h1>
    </div>

    
    <div class="d-flex justify-content-end mb-3">
      <a href="<?php echo e(route('admin.lessons.create')); ?>"
        class="btn btn-primary px-4 shadow-sm rounded-3 d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Tambah Materi</span>
      </a>
    </div>


<form method="GET" action="<?php echo e(route('admin.lessons.index')); ?>" class="mb-3 d-flex gap-2" style="max-width: 700px;">
  
  <div class="input-group" style="max-width: 300px;">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
           class="form-control" placeholder="Cari judul...">
    <button class="btn btn-primary" type="submit">
      <i class="fas fa-search"></i>
    </button>
  </div>

  
  <select name="course_id" class="form-select" style="max-width: 250px;" onchange="this.form.submit()">
    <option value="">Semua Kursus</option>
    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($course->id); ?>" <?php echo e(request('course_id') == $course->id ? 'selected' : ''); ?>>
        <?php echo e($course->name); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</form>


    
    <?php if(session('success')): ?>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: <?php echo json_encode(session('success'), 15, 512) ?>,
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            background: '#f8fbff',
            color: '#1e3a8a',
            iconColor: '#0d6efd',
            customClass: {
              popup: 'rounded-4 shadow-lg p-4',
              title: 'fw-bold fs-4 text-primary',
              htmlContainer: 'mt-2 fs-6',
            }
          });
        });
      </script>
    <?php endif; ?>

    
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-0">
        <?php if($lessons->count()): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap mb-0">
              <thead class="table-light">
                <tr>
                  <th>Kursus</th>
                  <th>Modul</th>
                  <th>Judul</th>
                  <th>Media</th>
                  <th>Durasi</th>
                  <th>Preview</th>
                  <th>Urutan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $currentCourse = null;
                  $currentModule = null; 
                ?>

                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  <?php if($currentCourse !== $lesson->course_id): ?>
                    <tr class="table-primary">
                      <td colspan="8" class="fw-bold">
                        <i class="fas fa-chalkboard me-2"></i> Kursus: <?php echo e($lesson->course->name ?? '-'); ?>

                      </td>
                    </tr>
                    <?php 
                      $currentCourse = $lesson->course_id;
                      $currentModule = null;
                    ?>
                  <?php endif; ?>

                  
                  <?php if($currentModule !== $lesson->module_name): ?>
                    <tr class="table-secondary">
                      <td colspan="8" class="fw-bold">
                        <i class="fas fa-layer-group me-2"></i> Modul: <?php echo e($lesson->module_name); ?>

                      </td>
                    </tr>
                    <?php $currentModule = $lesson->module_name; ?>
                  <?php endif; ?>

                  <?php
                    $mediaExt = strtolower(pathinfo($lesson->media, PATHINFO_EXTENSION));
                    $isImage = in_array($mediaExt, ['jpg', 'jpeg', 'png', 'webp']);
                    $isVideo = in_array($mediaExt, ['mp4', 'mov', 'avi', 'mkv']);
                  ?>

                  
                  <tr>
                    <td><?php echo e(optional($lesson->course)->name ?? '-'); ?></td>
                    <td><?php echo e($lesson->module_name); ?></td>
                    <td class="fw-semibold"><?php echo e($lesson->title); ?></td>
                    <td>
                      <?php if($lesson->media): ?>
                        <?php if($isImage): ?>
                          <img src="<?php echo e(asset('storage/' . $lesson->media)); ?>" alt="<?php echo e($lesson->title); ?>"
                            class="img-thumbnail rounded shadow-sm" style="width: 80px; height: auto;">
                        <?php elseif($isVideo): ?>
                          <video controls class="rounded" style="width: 100%; max-width: 200px; max-height: 150px;">
                            <source src="<?php echo e(asset('storage/' . $lesson->media)); ?>" type="video/<?php echo e($mediaExt); ?>">
                            Browser Anda tidak mendukung pemutaran video.
                          </video>
                        <?php else: ?>
                          <span class="text-muted small fst-italic">Format tidak didukung</span>
                        <?php endif; ?>
                      <?php else: ?>
                        <span class="text-muted small fst-italic">Tidak ada</span>
                      <?php endif; ?>
                    </td>

                    <td>
                      <?php if($lesson->duration): ?>
                        <?php
                          $seconds = $lesson->duration;
                          if ($seconds >= 3600) {
                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);
                            $durationFormatted = $hours . ' jam' . ($minutes > 0 ? ' ' . $minutes . ' menit' : '');
                          } elseif ($seconds >= 60) {
                            $minutes = floor($seconds / 60);
                            $remainingSeconds = $seconds % 60;
                            $durationFormatted = $minutes . ' menit' . ($remainingSeconds > 0 ? ' ' . $remainingSeconds . ' detik' : '');
                          } else {
                            $durationFormatted = $seconds . ' detik';
                          }
                        ?>
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm">
                          <i class="fas fa-clock me-1"></i> <?php echo e($durationFormatted); ?>

                        </span>
                      <?php else: ?>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($lesson->is_preview): ?>
                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Ya</span>
                      <?php else: ?>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Tidak</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($lesson->order); ?></td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2 flex-nowrap">
                        
                        <a href="<?php echo e(route('admin.lessons.show', $lesson)); ?>"
                          class="btn btn-sm btn-outline-info shadow-sm rounded-3" title="Lihat">
                          <i class="fas fa-eye"></i>
                        </a>

                        
                        <a href="<?php echo e(route('admin.lessons.edit', $lesson)); ?>"
                          class="btn btn-sm btn-outline-warning shadow-sm rounded-3" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>

                        
                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm rounded-3" data-bs-toggle="modal"
                          data-bs-target="#modalHapus<?php echo e($lesson->id); ?>" title="Hapus">
                          <i class="fas fa-trash-alt"></i>
                        </button>

                        
                        <div class="modal fade" id="modalHapus<?php echo e($lesson->id); ?>" tabindex="-1"
                          aria-labelledby="modalHapusLabel<?php echo e($lesson->id); ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                              <div class="modal-header border-0">
                                <h5 class="modal-title">
                                  <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus materi <strong><?php echo e($lesson->title); ?></strong>?
                              </div>
                              <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-3 px-3"
                                  data-bs-dismiss="modal">Batal</button>
                                <form action="<?php echo e(route('admin.lessons.destroy', $lesson)); ?>" method="POST" class="m-0"
                                  onsubmit="return showSpinner(this, <?php echo e($lesson->id); ?>)">
                                  <?php echo csrf_field(); ?>
                                  <?php echo method_field('DELETE'); ?>
                                  <button type="submit" class="btn btn-danger rounded-3 px-3 d-flex align-items-center gap-2"
                                    id="btnDelete<?php echo e($lesson->id); ?>">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                      aria-hidden="true" id="spinner<?php echo e($lesson->id); ?>"></span>
                                    <span>Ya, Hapus</span>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>

          
          <div class="mt-4 px-3">
            <?php echo e($lessons->withQueryString()->links('vendor.pagination.bootstrap-5')); ?>

          </div>
        <?php else: ?>
          <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0 rounded-3">
            <i class="fas fa-info-circle"></i>
            <span>Belum ada data materi yang tersedia.</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function showSpinner(form, id) {
      const btn = form.querySelector(`#btnDelete${id}`);
      const spinner = form.querySelector(`#spinner${id}`);
      const btnText = btn.querySelector('span:last-child');

      spinner.classList.remove('d-none');
      btnText.textContent = 'Menghapus...';
      btn.disabled = true;

      return true;
    }
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/lessons/index.blade.php ENDPATH**/ ?>