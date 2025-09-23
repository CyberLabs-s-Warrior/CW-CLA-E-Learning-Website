<?php $__env->startSection('title', 'Edit Materi'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid py-4">
    
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 44px; height: 44px;">
          <i class="fas fa-edit"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Edit Materi</h1>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body">
        <form action="<?php echo e(route('admin.lessons.update', $lesson->id)); ?>" method="POST" enctype="multipart/form-data"
          class="row g-3" id="lesson-form">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          
          <div class="col-md-6">
            <label for="course_id" class="form-label fw-semibold">Kursus</label>
            <select name="course_id" id="course_id" class="form-select shadow-sm" required>
              <option value="">-- Pilih Kursus --</option>
              <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($course->id); ?>" <?php echo e($lesson->course_id == $course->id ? 'selected' : ''); ?>>
                  <?php echo e($course->name); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          
          <div class="col-md-6">
            <label for="module_select" class="form-label fw-semibold">Nama Modul</label>
            <select id="module_select" class="form-select shadow-sm" required <?php echo e(!$lesson->detail_course ? 'disabled' : ''); ?>>
              <?php if($lesson->detail_course): ?>
                <option value="<?php echo e($lesson->detail_course->id); ?>" data-name="<?php echo e($lesson->detail_course->module_name); ?>"
                  selected>
                  <?php echo e($lesson->detail_course->module_name); ?>

                </option>
              <?php else: ?>
                <option value="">-- Pilih Modul --</option>
              <?php endif; ?>
            </select>
          </div>

          
          <input type="hidden" name="detail_courses_id" id="detail_courses_id"
            value="<?php echo e(old('detail_courses_id', $lesson->detail_courses_id)); ?>">
          
          <input type="hidden" name="module_name" id="module_name" value="<?php echo e(old('module_name', $lesson->module_name)); ?>">

          
          <div class="col-md-12">
            <label for="title" class="form-label fw-semibold">Judul Materi</label>
            <input type="text" name="title" id="title" class="form-control shadow-sm"
              value="<?php echo e(old('title', $lesson->title)); ?>" required>
          </div>

          
          <div class="col-md-12">
            <label for="content" class="form-label fw-semibold">Konten Materi</label>
            <textarea name="content" id="content" rows="4"
              class="form-control shadow-sm"><?php echo e(old('content', $lesson->content)); ?></textarea>
          </div>

          
          <div class="col-md-6">
            <label for="media" class="form-label fw-semibold">Upload Media (opsional)</label>
            <input type="file" name="media" id="media" class="form-control shadow-sm"
              accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
            <?php if($lesson->media): ?>
              <small class="text-muted">Media saat ini: <?php echo e($lesson->media); ?></small>
            <?php endif; ?>
          </div>

          
          <div class="col-md-6" id="duration-wrapper">
            <label class="form-label fw-semibold">Durasi Materi</label>
            <div class="d-flex gap-2">
              <input type="number" name="duration_hours" class="form-control shadow-sm" placeholder="Jam" min="0"
                value="<?php echo e(old('duration_hours', $hours)); ?>">
              <input type="number" name="duration_minutes" class="form-control shadow-sm" placeholder="Menit" min="0"
                max="59" value="<?php echo e(old('duration_minutes', $minutes)); ?>">
              <input type="number" name="duration_seconds" class="form-control shadow-sm" placeholder="Detik" min="0"
                max="59" value="<?php echo e(old('duration_seconds', $seconds)); ?>">
            </div>
            <small class="text-muted">Isi manual jika media berupa gambar</small>
          </div>


          
          <div class="col-12 d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-warning rounded-pill px-4" id="btn-submit">
              <span id="btn-text"><i class="fas fa-save me-2"></i>Perbarui</span>
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
    ClassicEditor
      .create(document.querySelector('#content'))
      .then(editor => { editorInstance = editor; })
      .catch(error => { console.error(error); });

    const courseSelect = document.getElementById('course_id');
    const moduleSelect = document.getElementById('module_select');
    const detailCourseInput = document.getElementById('detail_courses_id');
    const moduleNameInput = document.getElementById('module_name');

    // Fetch modul berdasarkan kursus yang dipilih
    function loadModules(courseId, preselectedId = null) {
      moduleSelect.innerHTML = '<option value="">Sedang memuat modul...</option>';
      moduleSelect.disabled = true;

      fetch(`/admin/course/${courseId}/modules`)
        .then(response => {
          if (!response.ok) throw new Error("Gagal memuat modul.");
          return response.json();
        })
        .then(data => {
          let options = '<option value="">-- Pilih Modul --</option>';
          let foundSelected = false;

          data.forEach(item => {
            const isSelected = item.detail_courses_id == (preselectedId || detailCourseInput.value);
            const selected = isSelected ? 'selected' : '';
            if (isSelected) {
              foundSelected = true;
              detailCourseInput.value = item.detail_courses_id;
              moduleNameInput.value = item.module_name;
            }
            options += `<option value="${item.detail_courses_id}" data-name="${item.module_name}" ${selected}>${item.module_name}</option>`;
          });

          moduleSelect.innerHTML = options;
          moduleSelect.disabled = false;

          // fallback kalau tidak ada yg selected
          if (!foundSelected) {
            detailCourseInput.value = '';
            moduleNameInput.value = '';
          }
        })
        .catch(error => {
          console.error(error);
          moduleSelect.innerHTML = '<option value="">Tidak dapat memuat modul</option>';
          moduleSelect.disabled = true;
          detailCourseInput.value = '';
          moduleNameInput.value = '';
        });
    }

    // Event: Saat kursus diubah
    courseSelect.addEventListener('change', function () {
      const courseId = this.value;
      detailCourseInput.value = '';
      moduleNameInput.value = '';

      if (!courseId) {
        moduleSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
        moduleSelect.disabled = true;
        return;
      }

      loadModules(courseId);
    });

    // Event: Saat modul diubah
    moduleSelect.addEventListener('change', function () {
      detailCourseInput.value = this.value;
      const selectedOption = this.options[this.selectedIndex];
      moduleNameInput.value = selectedOption?.dataset.name || '';
    });

    // Load modul otomatis jika halaman edit memiliki kursus yang sudah terpilih
    document.addEventListener('DOMContentLoaded', function () {
      const selectedCourseId = courseSelect.value;
      if (selectedCourseId) {
        loadModules(selectedCourseId, detailCourseInput.value);
      }
    });

    // Form submit handler
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

      if (!detailCourseInput.value || !moduleNameInput.value) {
        e.preventDefault();
        alert('Silakan pilih modul terlebih dahulu.');
        return;
      }

      btnText.classList.add('d-none');
      btnSaving.classList.remove('d-none');
      btnSubmit.disabled = true;
    });

    // Durasi toggle berdasarkan media type
    const mediaInput = document.getElementById('media');
    const durationWrapper = document.getElementById('duration-wrapper');

    function toggleDurationField(fileName) {
      if (!fileName) {
        durationWrapper.style.display = 'block'; // default tampil
        return;
      }
      const ext = fileName.split('.').pop().toLowerCase();
      if (['mp4', 'mov', 'avi'].includes(ext)) {
        durationWrapper.style.display = 'none'; // video → hide
      } else {
        durationWrapper.style.display = 'block'; // image → show
      }
    }

    // Initial check kalau sudah ada media
    toggleDurationField("<?php echo e($lesson->media); ?>");

    // Event saat pilih file baru
    mediaInput.addEventListener('change', function () {
      if (this.files.length > 0) {
        toggleDurationField(this.files[0].name);
      }
    });

  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/lessons/edit.blade.php ENDPATH**/ ?>