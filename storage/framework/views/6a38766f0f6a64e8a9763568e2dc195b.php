<?php $__env->startSection('title', 'Tambah Materi'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 44px; height: 44px;">
          <i class="fas fa-plus-circle"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Tambah Materi</h1>
    </div>

    <?php if($errors->any()): ?>
      <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body">
        <form action="<?php echo e(route('admin.lessons.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-3"
          id="lesson-form">
          <?php echo csrf_field(); ?>

          <div class="col-md-6">
            <label for="course_id" class="form-label fw-semibold">Kursus</label>
            <select name="course_id" id="course_id" class="form-select shadow-sm <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
              required>
              <option value="">-- Pilih Kursus --</option>
              <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>>
                  <?php echo e($course->name); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['course_id'];
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

          <div class="col-md-6">
            <label for="module_select" class="form-label fw-semibold">Nama Modul</label>
            <select id="module_select" class="form-select shadow-sm <?php $__errorArgs = ['module_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
              disabled>
              <option value="">-- Pilih Modul --</option>
            </select>
            <?php $__errorArgs = ['module_name'];
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

          <div class="col-md-6 d-none" id="module_manual_wrapper">
            <label for="module_manual" class="form-label fw-semibold">Nama Modul Baru</label>
            <input type="text" id="module_manual" class="form-control shadow-sm">
          </div>
          <input type="hidden" name="detail_courses_id" id="detail_courses_id" value="<?php echo e(old('detail_courses_id')); ?>">
          <input type="hidden" name="module_name" id="module_name" value="<?php echo e(old('module_name')); ?>">

          <div class="col-md-12">
            <label for="title" class="form-label fw-semibold">Judul Materi</label>
            <input type="text" name="title" id="title" class="form-control shadow-sm <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
              value="<?php echo e(old('title')); ?>" required>
            <?php $__errorArgs = ['title'];
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

          <div class="col-md-12">
            <label for="content" class="form-label fw-semibold">Konten Materi</label>
            <textarea name="content" id="content" rows="4"
              class="form-control shadow-sm <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('content')); ?></textarea>
            <?php $__errorArgs = ['content'];
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

          
          <div class="col-md-6">
            <label for="media" class="form-label fw-semibold">Upload Media (opsional)</label>
            <input type="file" name="media" id="media" class="form-control shadow-sm <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
              accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
            <?php $__errorArgs = ['media'];
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

          
          <div
            class="col-md-6 <?php echo e(old('duration_hours') || old('duration_minutes') || old('duration_seconds') ? '' : 'd-none'); ?>"
            id="duration_wrapper">
            <label class="form-label fw-semibold">Durasi Materi</label>
            <div class="d-flex gap-2">
              <input type="number" name="duration_hours" id="duration_hours"
                class="form-control shadow-sm <?php $__errorArgs = ['duration_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Jam" min="0"
                value="<?php echo e(old('duration_hours', 0)); ?>">
              <input type="number" name="duration_minutes" id="duration_minutes"
                class="form-control shadow-sm <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Menit" min="0"
                max="59" value="<?php echo e(old('duration_minutes', 0)); ?>">
              <input type="number" name="duration_seconds" id="duration_seconds"
                class="form-control shadow-sm <?php $__errorArgs = ['duration_seconds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Detik" min="0"
                max="59" value="<?php echo e(old('duration_seconds', 0)); ?>">
            </div>
            <small class="text-muted">
              * Wajib diisi jika media bukan video<br>
              * Contoh: <b>1 jam 20 menit 15 detik</b>
            </small>
            <?php $__errorArgs = ['duration_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['duration_seconds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>



          
          <div class="col-12 d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success rounded-pill px-4" id="btn-submit">
              <span id="btn-text"><i class="fas fa-save me-2"></i>Simpan</span>
              <span id="btn-saving" class="d-none">
                Menyimpan...
                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
              </span>
            </button>
            <a href="<?php echo e(route('admin.lessons.index')); ?>" class="btn btn-secondary rounded-pill px-4">
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
    let editorInstance;
    ClassicEditor.create(document.querySelector('#content'))
      .then(editor => { editorInstance = editor; })
      .catch(error => { console.error(error); });

    const courseSelect = document.getElementById('course_id');
    const moduleSelect = document.getElementById('module_select');
    const moduleManualWrapper = document.getElementById('module_manual_wrapper');
    const moduleManualInput = document.getElementById('module_manual');
    const detailCourseInput = document.getElementById('detail_courses_id');
    const moduleNameInput = document.getElementById('module_name');

    const mediaInput = document.getElementById('media');
    const durationWrapper = document.getElementById('duration_wrapper');

    const durationHours = document.getElementById('duration_hours');
    const durationMinutes = document.getElementById('duration_minutes');
    const durationSeconds = document.getElementById('duration_seconds');

    // Toggle durasi manual jika bukan video
    mediaInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) {
        durationWrapper.classList.add('d-none');
        durationHours.value = 0;
        durationMinutes.value = 0;
        durationSeconds.value = 0;
        return;
      }

      const ext = file.name.split('.').pop().toLowerCase();
      const videoExt = ['mp4', 'mov', 'avi'];

      if (videoExt.includes(ext)) {
        durationWrapper.classList.add('d-none');
        durationHours.value = 0;
        durationMinutes.value = 0;
        durationSeconds.value = 0;
      } else {
        durationWrapper.classList.remove('d-none');
      }
    });

    courseSelect.addEventListener('change', function () {
      const courseId = this.value;
      moduleSelect.innerHTML = '<option value="">Sedang memuat modul...</option>';
      moduleSelect.disabled = true;
      detailCourseInput.value = '';
      moduleNameInput.value = '';
      moduleManualWrapper.classList.add('d-none');
      moduleManualInput.value = '';

      if (!courseId) {
        moduleSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
        return;
      }

      fetch(`/admin/course/${courseId}/modules`)
        .then(response => {
          if (!response.ok) throw new Error("Gagal memuat modul.");
          return response.json();
        })
        .then(data => {
          let options = '<option value="">-- Pilih Modul --</option>';
          data.forEach(item => {
            options += `<option value="${item.detail_courses_id}" data-name="${item.module_name}">${item.module_name}</option>`;
          });
          options += `<option value="__new__">+ Tambah Modul Baru</option>`;
          moduleSelect.innerHTML = options;
          moduleSelect.disabled = false;
        })
        .catch(error => {
          console.error(error);
          moduleSelect.innerHTML = '<option value="">Tidak dapat memuat modul</option>';
          moduleSelect.disabled = true;
        });
    });

    moduleSelect.addEventListener('change', function () {
      const selectedValue = this.value;
      const selectedOption = this.options[this.selectedIndex];

      if (selectedValue === '__new__') {
        moduleManualWrapper.classList.remove('d-none');
        detailCourseInput.value = '';
        moduleNameInput.value = '';
      } else {
        moduleManualWrapper.classList.add('d-none');
        moduleManualInput.value = '';
        detailCourseInput.value = selectedValue;
        moduleNameInput.value = selectedOption.dataset.name || '';
      }
    });

    const form = document.getElementById('lesson-form');
    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnSaving = document.getElementById('btn-saving');

    form.addEventListener('submit', function (e) {
      if (editorInstance) {
        const data = editorInstance.getData().trim();
        document.querySelector('#content').value = data;

        if (data === '') {
          e.preventDefault();
          alert('Konten materi tidak boleh kosong.');
          return;
        }
      }

      if (moduleSelect.value === '__new__') {
        const manualValue = moduleManualInput.value.trim();
        if (!manualValue) {
          e.preventDefault();
          alert('Silakan isi nama modul baru.');
          return;
        }
        moduleNameInput.value = manualValue;
      }

      if (!moduleNameInput.value) {
        e.preventDefault();
        alert('Silakan pilih atau masukkan modul terlebih dahulu.');
        return;
      }

      // Validasi durasi kalau bukan video
      if (!durationWrapper.classList.contains('d-none')) {
        const h = parseInt(durationHours.value || 0);
        const m = parseInt(durationMinutes.value || 0);
        const s = parseInt(durationSeconds.value || 0);

        if (h === 0 && m === 0 && s === 0) {
          e.preventDefault();
          alert('Durasi wajib diisi minimal 1 detik untuk media non-video.');
          return;
        }
      }

      btnText.classList.add('d-none');
      btnSaving.classList.remove('d-none');
      btnSubmit.disabled = true;
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/lessons/create.blade.php ENDPATH**/ ?>