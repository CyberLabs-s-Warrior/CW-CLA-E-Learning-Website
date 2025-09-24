<?php $__env->startSection('title','Buat Profil Instruktur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-3 py-md-4 instructor-create">

  
  <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
    <div>
      <h1 class="h4 mb-0">Buat Profil Instruktur</h1>
      <div class="text-muted small">
        Lengkapi info dasar instruktur. Hanya user dengan role <strong>instructor</strong> yang ditampilkan.
      </div>
    </div>
    <a href="<?php echo e(route('admin.instruktur.index')); ?>" class="btn btn-outline-secondary ms-md-auto">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
  </div>

  
  <?php if($errors->any()): ?>
    <div class="alert alert-danger rounded-3 shadow-sm">
      <div class="fw-semibold mb-1"><i class="fas fa-circle-exclamation me-2"></i>Perbaiki isian berikut:</div>
      <ul class="mb-0 small">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($e); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <form action="<?php echo e(route('admin.instruktur.store')); ?>" method="post" enctype="multipart/form-data"
        class="card border-0 shadow-sm rounded-4">
    <?php echo csrf_field(); ?>

    <div class="card-body p-3 p-md-4">
      <div class="row g-4">
        
        <div class="col-lg-8">
          <div class="mb-3">
            <label class="form-label">Pilih User <span class="text-danger">*</span></label>
            <select name="user_id" class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <option value="">— pilih instruktur —</option>
              <?php $__currentLoopData = $instructorCandidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($u->id); ?>" <?php if(old('user_id')==$u->id): echo 'selected'; endif; ?>>
                  <?php echo e($u->name); ?> — <?php echo e($u->email); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="form-text">Hanya menampilkan user ber-role <code>instructor</code> yang belum punya profil.</div>
          </div>

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Bidang (Primary Skill) <span class="text-danger">*</span></label>
              <input type="text"
                     name="primary_skill"
                     value="<?php echo e(old('primary_skill')); ?>"
                     maxlength="120"
                     class="form-control <?php $__errorArgs = ['primary_skill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                     required>
              <?php $__errorArgs = ['primary_skill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <div class="form-text">Contoh: Fullstack Developer, Mobile Engineer, Data/AI, dsb.</div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Urutan (opsional)</label>
              <input type="number"
                     name="sort_order"
                     value="<?php echo e(old('sort_order', 0)); ?>"
                     min="0"
                     class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
              <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <div class="form-text">Angka kecil tampil lebih dulu.</div>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
            <textarea name="short_bio"
                      rows="5"
                      maxlength="600"
                      class="form-control <?php $__errorArgs = ['short_bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      required
                      oninput="window.updateBioCount(this)"><?php echo e(old('short_bio')); ?></textarea>
            <?php $__errorArgs = ['short_bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="d-flex justify-content-between small text-muted mt-1">
              <span>Tips: jelaskan ringkas keahlian & pengalaman utama.</span>
              <span><span id="bioCount">0</span>/600</span>
            </div>
          </div>

          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <label class="form-label">GitHub (opsional)</label>
              <input type="url"
                     name="github_url"
                     value="<?php echo e(old('github_url')); ?>"
                     placeholder="https://github.com/username"
                     class="form-control <?php $__errorArgs = ['github_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
              <?php $__errorArgs = ['github_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
              <label class="form-label">LinkedIn (opsional)</label>
              <input type="url"
                     name="linkedin_url"
                     value="<?php echo e(old('linkedin_url')); ?>"
                     placeholder="https://www.linkedin.com/in/username"
                     class="form-control <?php $__errorArgs = ['linkedin_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
              <?php $__errorArgs = ['linkedin_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
        </div>

        
        <div class="col-lg-4">
          <div class="card border-0 bg-light rounded-4">
            <div class="card-body">
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_published" id="pub"
                         value="1" <?php echo e(old('is_published', '1') ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="pub">Published</label>
                </div>
                <div class="form-text">Jika dinonaktifkan, profil tidak tampil ke publik.</div>
              </div>

              <hr class="text-muted">

              <div class="mb-2">
                <label class="form-label">Foto (opsional)</label>
                <input type="file"
                       name="avatar"
                       accept="image/*"
                       class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       onchange="window.previewAvatar(this)">
                <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="form-text">jpg/png/webp, maks 1MB.</div>
              </div>

              <div class="text-center">
                <div class="ratio ratio-1x1 rounded-3 overflow-hidden bg-white border"
                     style="max-width: 180px; margin: 10px auto 0;">
                  <img id="avatarPreview" src="https://ui-avatars.com/api/?name=Instruktur&background=EAF2FF&color=0D6EFD&bold=true"
                       alt="Preview Avatar" class="w-100 h-100 object-fit-cover">
                </div>
                <div class="small text-muted mt-2">Preview</div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div> 

    <div class="card-footer bg-white d-flex flex-column flex-sm-row gap-2 justify-content-end p-3 p-md-3 rounded-bottom-4">
      <a href="<?php echo e(route('admin.instruktur.index')); ?>" class="btn btn-light">Batal</a>
      <button class="btn btn-primary">
        <i class="fas fa-save me-2"></i>Simpan
      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  /* Scoped untuk halaman create instruktur */
  .instructor-create .rounded-4{ border-radius: 1rem; }
  .instructor-create .rounded-bottom-4{ border-bottom-left-radius:1rem; border-bottom-right-radius:1rem; }
  .instructor-create .object-fit-cover{ object-fit: cover; }

  /* Jarak vertikal sudah via py-3/py-md-4; tambah sedikit ruang antar blok */
  .instructor-create .card-body > .row { margin-top: .25rem; }

  /* Form control spacing sedikit lega */
  .instructor-create .form-label{ font-weight: 600; }
  .instructor-create .form-text{ color:#64748b; }

  /* Table-like helpers if needed elsewhere */
  .ratio{ background:#f8fafc; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // Hitung karakter bio
  window.updateBioCount = function(el){
    document.getElementById('bioCount').textContent = (el.value || '').length;
  };
  // Init saat load (agar menghitung old value)
  document.addEventListener('DOMContentLoaded', function(){
    const bio = document.querySelector('textarea[name="short_bio"]');
    if (bio) window.updateBioCount(bio);
  });

  // Preview avatar
  window.previewAvatar = function(input){
    const img = document.getElementById('avatarPreview');
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = e => img.src = e.target.result;
    reader.readAsDataURL(file);
  };

  // Tombol clear search (kalau kamu reuse komponen ini di halaman lain)
  document.getElementById('btnClear')?.addEventListener('click', function(){
    const q = document.getElementById('searchInput');
    q.value = '';
    q.form.submit();
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/instructors/create.blade.php ENDPATH**/ ?>