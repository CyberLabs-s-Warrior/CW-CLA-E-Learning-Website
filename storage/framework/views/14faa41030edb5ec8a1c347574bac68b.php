<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('client/student-profile.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Profile - Learnify'); ?>

<?php $__env->startSection('content'); ?>
<main class="profile-container" id="profileRoot">
  
  <section class="profile-header card" aria-labelledby="profileTitle">
    <img class="avatar-xl"
         src="<?php echo e($user->profile?->avatar_url ?? asset('image/avatar.jpg')); ?>"
         alt="Foto profil <?php echo e($user->name); ?>">
    <div class="ph-info">
      <h1 class="ph-name" id="profileTitle">
        <?php echo e($user->profile->nama_lengkap ?? $user->name); ?>

      </h1>
      <div class="ph-meta">
        
        <span><?php echo e('@' . ($user->username ?? '—')); ?></span>
        <span aria-hidden="true">•</span>
        <span><?php echo e($user->email); ?></span>
        <span aria-hidden="true">•</span>
        <span>Bergabung sejak <?php echo e($user->created_at?->format('d M Y')); ?></span>
      </div>
      <a href="<?php echo e(route('dashboard.index')); ?>" class="btn-light">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
      </a>
    </div>
  </section>

  
  <nav class="tabs" role="tablist" aria-label="Pengaturan profil">
    <button class="tab active" id="tab-biodata" data-tab="biodata" role="tab" aria-selected="true" aria-controls="panel-biodata">
      <i class="fa-regular fa-id-card"></i> Biodata
    </button>
    <button class="tab" id="tab-account" data-tab="account" role="tab" aria-selected="false" aria-controls="panel-account">
      <i class="fa-regular fa-user"></i> Akun
    </button>
    <button class="tab" id="tab-security" data-tab="security" role="tab" aria-selected="false" aria-controls="panel-security">
      <i class="fa-solid fa-shield-halved"></i> Keamanan
    </button>
  </nav>

  
  <?php if(session('success')): ?>
    <div class="alert success" role="status">
      <i class="fa-regular fa-circle-check"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="alert danger" role="alert">
      <ul class="mb-0" style="margin:0; padding-left: 1rem;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <section id="panel-biodata" class="panel active" role="tabpanel" aria-labelledby="tab-biodata">
    <form action="<?php echo e(route('student.profile.biodata')); ?>" method="POST" enctype="multipart/form-data" class="card form-grid" novalidate>
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

      
      <div class="form-col">
        <label for="foto">Foto</label>
        <div class="avatar-upload">
          <img class="avatar-lg" id="avatarPreview"
               src="<?php echo e($user->profile?->avatar_url ?? asset('image/avatar.jpg')); ?>"
               alt="Preview avatar">
          <div class="file-wrap">
            <input id="foto" type="file" name="foto" accept="image/*" aria-describedby="fotoHelp">
            <div class="file-ui">
              <i class="fa-regular fa-image"></i>
              <span class="hint">Pilih gambar (JPG/PNG/WEBP, &le; 2MB)</span>
            </div>
          </div>
        </div>
        <small id="fotoHelp" class="helper">Rasio persegi disarankan agar tidak terpotong.</small>
        <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-col">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="input <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
          <?php $__currentLoopData = ['Laki-laki','Perempuan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($jk); ?>" <?php if($user->profile?->jenis_kelamin === $jk): echo 'selected'; endif; ?>><?php echo e($jk); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-col">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input id="tgl_lahir" type="date" name="tgl_lahir"
               class="input <?php $__errorArgs = ['tgl_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('tgl_lahir', optional($user->profile?->tgl_lahir)->format('Y-m-d'))); ?>">
        <small class="helper">Tidak boleh di masa depan.</small>
        <?php $__errorArgs = ['tgl_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-col">
        <label for="status">Status</label>
        <input id="status" type="text" name="status"
               class="input <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('status', $user->profile?->status)); ?>"
               placeholder="Mis. Pelajar kelas 12">
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-actions">
        <button class="btn-primary" type="submit">
          <i class="fa-regular fa-floppy-disk"></i> Simpan Biodata
        </button>
      </div>
    </form>
  </section>

  
  <section id="panel-account" class="panel" role="tabpanel" aria-labelledby="tab-account" hidden>
    <form action="<?php echo e(route('student.profile.account')); ?>" method="POST" class="card form-grid" novalidate>
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

      <div class="form-col">
        <label for="name">Nama</label>
        <input id="name" type="text" class="input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
               value="<?php echo e(old('name', $user->name)); ?>" required>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-col">
        <label for="username">Username</label>
        <input id="username" type="text" class="input <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username"
               value="<?php echo e(old('username', $user->username)); ?>">
        <small class="helper">Hanya huruf, angka, tanda hubung, dan garis bawah disarankan.</small>
        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-col">
        <label>Email</label>
        <input type="email" class="input" value="<?php echo e($user->email); ?>" disabled>
        <small class="helper">Email tidak dapat diubah.</small>
     </div>


      <div class="form-col">
        <label for="phone">No. HP</label>
        <input id="phone" type="text" class="input <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone"
               value="<?php echo e(old('phone', $user->phone)); ?>">
        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-actions">
        <button class="btn-primary" type="submit">
          <i class="fa-regular fa-floppy-disk"></i> Simpan Akun
        </button>
      </div>
    </form>
  </section>

  
<section id="panel-security" class="panel" role="tabpanel" aria-labelledby="tab-security" hidden>
  
  <?php if(session('status') === 'password-updated'): ?>
    <div class="alert success" role="status" style="margin-bottom:12px">
      <i class="fa-regular fa-circle-check"></i> Password berhasil diperbarui.
    </div>
  <?php endif; ?>

  <?php if($errors->updatePassword->any()): ?>
    <div class="alert danger" role="alert" style="margin-bottom:12px">
      <strong>Gagal memperbarui password.</strong>
      <ul style="margin:.4rem 0 0; padding-left:1rem;">
        <?php $__currentLoopData = $errors->updatePassword->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($msg); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('student.profile.password')); ?>" method="POST" class="card form-grid" novalidate>
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <div class="form-col">
      <label for="current_password">Password Saat Ini</label>
      <input id="current_password" type="password"
             class="input <?php $__errorArgs = ['current_password','updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
             name="current_password" required autocomplete="current-password">
      <?php $__errorArgs = ['current_password','updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="field-error"><?php echo e($message); ?></small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-col">
      <label for="password">Password Baru</label>
      <input id="password" type="password"
             class="input <?php $__errorArgs = ['password','updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
             name="password" required autocomplete="new-password">
      <small class="helper">Gunakan kombinasi huruf besar/kecil, angka, dan simbol.</small>
      <?php $__errorArgs = ['password','updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="field-error"><?php echo e($message); ?></small>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-col">
      <label for="password_confirmation">Konfirmasi Password Baru</label>
      <input id="password_confirmation" type="password" class="input"
             name="password_confirmation" required autocomplete="new-password">
    </div>

    <div class="form-actions">
      <button class="btn-primary" type="submit">
        <i class="fa-regular fa-floppy-disk"></i> Ganti Password
      </button>
    </div>
  </form>
</section>

</main>


<script>
(function(){
  const tabs = Array.from(document.querySelectorAll('.tab'));
  const panels = {
    biodata:  document.getElementById('panel-biodata'),
    account:  document.getElementById('panel-account'),
    security: document.getElementById('panel-security'),
  };

  function selectTab(key){
    tabs.forEach(btn=>{
      const active = btn.dataset.tab === key;
      btn.classList.toggle('active', active);
      btn.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    Object.entries(panels).forEach(([k,p])=>{
      const on = (k === key);
      p.hidden = !on;
      p.classList.toggle('active', on);
    });
    try { localStorage.setItem('studentProfile.tab', key); } catch (e) {}
  }

  // Initial tab: from hash or localStorage
  const hashKey = location.hash?.replace('#','');
  const saved = (()=>{ try { return localStorage.getItem('studentProfile.tab'); } catch(e){ return null; }})();
  const initial = ['biodata','account','security'].includes(hashKey) ? hashKey : (saved || 'biodata');
  selectTab(initial);

  tabs.forEach(btn=>{
    btn.addEventListener('click', ()=> selectTab(btn.dataset.tab));

    // Keyboard navigation (Left/Right)
    btn.addEventListener('keydown', (e)=>{
      if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
      e.preventDefault();
      const idx = tabs.indexOf(btn);
      const next = (e.key === 'ArrowRight') ? (idx+1) % tabs.length : (idx-1+tabs.length) % tabs.length;
      tabs[next].focus();
      selectTab(tabs[next].dataset.tab);
    });
  });

  // Avatar preview
  const fileInput = document.getElementById('foto');
  const preview   = document.getElementById('avatarPreview');
  if (fileInput && preview){
    fileInput.addEventListener('change', ()=>{
      const f = fileInput.files?.[0];
      if (!f) return;
      if (!/^image\//.test(f.type)) return;
      const url = URL.createObjectURL(f);
      preview.src = url;
      preview.onload = ()=> URL.revokeObjectURL(url);
    });
  }
})();
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/profile/index.blade.php ENDPATH**/ ?>