<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Data Diri</title>
  <link rel="stylesheet" href="{{ asset('client/userdata.css') }}">
</head>
<body>

  <div class="form-container">
    <h2 class="form-title">Lengkapi Data Diri Anda</h2>
    <p class="form-subtitle">Isi data berikut untuk melanjutkan ke dashboard</p>

    {{-- Upload Foto Profil --}}
    <div class="profile-picture-wrapper">
      <input type="file" id="profile-upload" accept="image/*" name="foto" hidden form="form-userdata">
      <label for="profile-upload" class="profile-label">
        <img
          src="{{ optional(auth()->user()->profile)->foto
                  ? asset('storage/'.auth()->user()->profile->foto)
                  : 'https://www.w3schools.com/howto/img_avatar.png' }}"
          alt="Foto Profil" id="profile-preview">
        <div class="overlay"><span class="plus-icon">+</span></div>
      </label>
      @error('foto') <small style="color:red">{{ $message }}</small> @enderror
    </div>

    {{-- Form --}}
    <form action="{{ route('pendataan.store') }}" method="POST" enctype="multipart/form-data" id="form-userdata" class="userdata-form">
      @csrf

      {{-- Jenis Kelamin --}}
      <div class="form-group">
        <label>Jenis Kelamin</label>
        <div class="radio-group">
          <label>
            <input type="radio" name="jenis_kelamin" value="Laki-laki"
              {{ old('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' }} required> Laki-laki
          </label>
          <label>
            <input type="radio" name="jenis_kelamin" value="Perempuan"
              {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }}> Perempuan
          </label>
        </div>
        @error('jenis_kelamin') <small style="color:red">{{ $message }}</small> @enderror
      </div>

      {{-- Status --}}
      <div class="form-group">
        <label for="status">Status (Pelajar/Mahasiswa/Pekerja/dll)</label>
        <input type="text" id="status" name="status" placeholder="Contoh: Mahasiswa" value="{{ old('status') }}" required>
        @error('status') <small style="color:red">{{ $message }}</small> @enderror
      </div>

      {{-- Tanggal Lahir --}}
      <div class="form-group">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
        @error('tgl_lahir') <small style="color:red">{{ $message }}</small> @enderror
      </div>

      <div class="form-group center">
        <button type="submit" class="submit-btn">Simpan Data</button>
      </div>
    </form>
  </div>

  <script>
    // Preview foto profil
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
