<?php $__env->startSection('title','Edit Karya'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-3 py-md-4">
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
    <div>
      <h1 class="h4 mb-0">Edit Karya</h1>
      <div class="text-muted small">Perbarui informasi karya anggota dan gambar cover.</div>
    </div>
    <a href="<?php echo e(route('admin.showcase.index')); ?>" class="btn btn-light border ms-md-auto">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
  </div>

  <?php if($errors->any()): ?>
    <div class="alert alert-danger rounded-3">
      <div class="fw-semibold mb-1"><i class="fas fa-triangle-exclamation me-2"></i>Periksa kembali isian Anda</div>
      <ul class="mb-0 ps-3">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('admin.showcase.update', $showcase)); ?>" method="POST" enctype="multipart/form-data" id="showcaseEditForm">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <div class="row g-4">
      <!-- Kiri: Isian utama -->
      <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-3 p-md-4">

            
            <div class="mb-3">
              <label class="form-label fw-semibold">Pembuat (Student) <span class="text-danger">*</span></label>
              <select name="user_id" id="studentSelect" class="form-select" required>
                <option value="" disabled>— Cari / pilih student —</option>
                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($s->id); ?>" <?php echo e(old('user_id',$showcase->user_id)==$s->id?'selected':''); ?>>
                    <?php echo e($s->name); ?> — <?php echo e($s->email); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <div class="form-text">Ketik nama atau email untuk mencari.</div>
            </div>

            
            <div class="mb-3">
              <div class="d-flex justify-content-between">
                <label class="form-label fw-semibold mb-0">Judul Karya <span class="text-danger">*</span></label>
                <small class="text-muted"><span id="titleCount">0</span>/150</small>
              </div>
              <input
                type="text"
                name="title"
                id="titleInput"
                maxlength="150"
                class="form-control"
                placeholder="Contoh: Web Portofolio Sederhana"
                value="<?php echo e(old('title',$showcase->title)); ?>"
                required>
              <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-0">
              <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
              <textarea
                name="description"
                id="descInput"
                class="form-control"
                rows="4"
                placeholder="Tuliskan deskripsi singkat karya (tujuan, fitur utama, teknologi, dsb.)"
                required><?php echo e(old('description',$showcase->description)); ?></textarea>
              <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <div class="form-text">Gunakan 2–5 kalimat ringkas.</div>
            </div>

          </div>
        </div>
      </div>

      <!-- Kanan: Upload & Preview -->
      <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-3 p-md-4">
            <label class="form-label fw-semibold d-flex align-items-center gap-2">
              <i class="fas fa-image"></i> Gambar Cover (opsional)
            </label>

            <div class="mb-2">
              <div class="ratio ratio-16x9 border rounded-3 bg-light d-flex align-items-center justify-content-center overflow-hidden" id="previewWrap">
                <img id="imgPreview" alt="Preview cover" class="w-100 h-100 object-fit-cover <?php echo e($showcase->image_path ? '' : 'd-none'); ?>"
                     src="<?php echo e($showcase->image_path ? asset('storage/'.$showcase->image_path) : ''); ?>">
                <div id="previewPlaceholder" class="text-muted small <?php echo e($showcase->image_path ? 'd-none' : ''); ?>">
                  <i class="fas fa-image mb-1 d-block"></i> Belum ada gambar
                </div>
              </div>
            </div>

            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            <div class="form-text">Upload untuk mengganti. Maks 2MB — JPG/PNG/WebP (disarankan rasio 16:9).</div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-3">
          <div class="card-body p-3">
            <div class="small text-muted">
              <i class="fas fa-lightbulb me-1"></i>
              Tips: Judul ringkas, deskripsi fokus ke hasil & dampak. Gambar jelas, tanpa teks berlebihan.
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="sticky-actions d-flex gap-2 mt-4">
      <button class="btn btn-primary px-4" id="submitBtn">
        <span class="me-2"><i class="fas fa-save"></i></span> Update
      </button>
      <a href="<?php echo e(route('admin.showcase.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
  <style>
    .rounded-4 { border-radius: 1rem; }
    .object-fit-cover { object-fit: cover; }
    .sticky-actions{
      position: sticky; bottom: 0; padding: .75rem; background: rgba(255,255,255,.8);
      backdrop-filter: blur(6px); border-top: 1px solid rgba(0,0,0,.075);
      box-shadow: 0 -6px 30px rgba(0,0,0,.05);
    }
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  <script>
    (function(){
      // Searchable select
      new TomSelect('#studentSelect', {
        plugins: ['clear_button'],
        persist: false,
        create: false,
        maxItems: 1,
        placeholder: 'Cari nama / email...',
        closeAfterSelect: true,
        render: {
          option: function(data, escape){
            return `<div><div class="fw-semibold">${escape(data.text)}</div></div>`;
          }
        }
      });

      // Counter judul
      const title = document.getElementById('titleInput');
      const titleCount = document.getElementById('titleCount');
      function updateCount(){ titleCount.textContent = (title.value || '').length; }
      title.addEventListener('input', updateCount); updateCount();

      // Auto-resize textarea
      const desc = document.getElementById('descInput');
      function autosize(el){
        el.style.height = 'auto';
        el.style.height  = Math.min(el.scrollHeight, 400) + 'px';
      }
      ['input','change'].forEach(ev => desc.addEventListener(ev, () => autosize(desc)));
      autosize(desc);

      // Preview gambar (live)
      const input = document.getElementById('imageInput');
      const img = document.getElementById('imgPreview');
      const ph  = document.getElementById('previewPlaceholder');
      input.addEventListener('change', (e)=>{
        const file = e.target.files && e.target.files[0];
        if(!file){ return; }
        const url = URL.createObjectURL(file);
        img.src = url;
        img.onload = () => URL.revokeObjectURL(url);
        img.classList.remove('d-none');
        ph.classList.add('d-none');
      });

      // UX submit
      const form = document.getElementById('showcaseEditForm');
      const btn  = document.getElementById('submitBtn');
      form.addEventListener('submit', ()=>{
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
      });
    })();
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/showcase/edit.blade.php ENDPATH**/ ?>