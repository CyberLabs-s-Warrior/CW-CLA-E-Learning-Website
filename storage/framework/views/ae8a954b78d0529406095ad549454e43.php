<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Data Diri</title>
  <link rel="stylesheet" href="<?php echo e(asset('client/userdata.css')); ?>">
</head>
<body>

  <div class="form-container">
    <h2 class="form-title">Lengkapi Data Diri Anda</h2>
    <p class="form-subtitle">Isi data berikut untuk melanjutkan ke dashboard</p>

    
    <div class="profile-picture-wrapper">
      <input type="file" id="profile-upload" accept="image/*" name="foto" hidden form="form-userdata">
      <label for="profile-upload" class="profile-label">
        <img
          src="<?php echo e(optional(auth()->user()->profile)->foto
                  ? asset('storage/'.auth()->user()->profile->foto)
                  : 'https://www.w3schools.com/howto/img_avatar.png'); ?>"
          alt="Foto Profil" id="profile-preview">
        <div class="overlay"><span class="plus-icon">+</span></div>
      </label>
      <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:red"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <form action="<?php echo e(route('pendataan.store')); ?>" method="POST" enctype="multipart/form-data" id="form-userdata" class="userdata-form">
      <?php echo csrf_field(); ?>

      
      <div class="form-group">
        <label>Jenis Kelamin</label>
        <div class="radio-group">
          <label>
            <input type="radio" name="jenis_kelamin" value="Laki-laki"
              <?php echo e(old('jenis_kelamin') === 'Laki-laki' ? 'checked' : ''); ?> required> Laki-laki
          </label>
          <label>
            <input type="radio" name="jenis_kelamin" value="Perempuan"
              <?php echo e(old('jenis_kelamin') === 'Perempuan' ? 'checked' : ''); ?>> Perempuan
          </label>
        </div>
        <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:red"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-group">
        <label for="status">Status (Pelajar/Mahasiswa/Pekerja/dll)</label>
        <input type="text" id="status" name="status" placeholder="Contoh: Mahasiswa" value="<?php echo e(old('status')); ?>" required>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:red"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-group">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?php echo e(old('tgl_lahir')); ?>" required>
        <?php $__errorArgs = ['tgl_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:red"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group center">
        <button type="submit" class="submit-btn">Simpan Data</button>
      </div>
    </form>
  </div>

  <script>
    const upload = document.getElementById('profile-upload');
    const preview = document.getElementById('profile-preview');
    upload.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function () { preview.setAttribute('src', reader.result); }
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/pendataan/index.blade.php ENDPATH**/ ?>