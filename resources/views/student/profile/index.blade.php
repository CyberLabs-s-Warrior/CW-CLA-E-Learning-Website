{{-- Learnify — Student Profile --}}
@extends('layouts.student')

@push('styles')
  <link rel="stylesheet" href="{{ asset('client/student-profile.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('title', 'Profile - Learnify')

@section('content')
<main class="profile-container" id="profileRoot">
  {{-- Header --}}
  <section class="profile-header card" aria-labelledby="profileTitle">
    <img class="avatar-xl"
         src="{{ $user->profile?->avatar_url ?? asset('image/avatar.jpg') }}"
         alt="Foto profil {{ $user->name }}">
    <div class="ph-info">
      <h1 class="ph-name" id="profileTitle">
        {{ $user->profile->nama_lengkap ?? $user->name }}
      </h1>
      <div class="ph-meta">
        {{-- FIX: jangan pakai @{{ ... }} --}}
        <span>{{ '@' . ($user->username ?? '—') }}</span>
        <span aria-hidden="true">•</span>
        <span>{{ $user->email }}</span>
        <span aria-hidden="true">•</span>
        <span>Bergabung sejak {{ $user->created_at?->format('d M Y') }}</span>
      </div>
      <a href="{{ route('dashboard.index') }}" class="btn-light">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
      </a>
    </div>
  </section>

  {{-- Tabs --}}
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

  {{-- Alerts --}}
  @if(session('success'))
    <div class="alert success" role="status">
      <i class="fa-regular fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert danger" role="alert">
      <ul class="mb-0" style="margin:0; padding-left: 1rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Panel: Biodata --}}
  <section id="panel-biodata" class="panel active" role="tabpanel" aria-labelledby="tab-biodata">
    <form action="{{ route('student.profile.biodata') }}" method="POST" enctype="multipart/form-data" class="card form-grid" novalidate>
      @csrf @method('PUT')

      {{-- Foto --}}
      <div class="form-col">
        <label for="foto">Foto</label>
        <div class="avatar-upload">
          <img class="avatar-lg" id="avatarPreview"
               src="{{ $user->profile?->avatar_url ?? asset('image/avatar.jpg') }}"
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
        @error('foto')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      {{-- Jenis Kelamin --}}
      <div class="form-col">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="input @error('jenis_kelamin') error @enderror" required>
          @foreach (['Laki-laki','Perempuan'] as $jk)
            <option value="{{ $jk }}" @selected($user->profile?->jenis_kelamin === $jk)>{{ $jk }}</option>
          @endforeach
        </select>
        @error('jenis_kelamin')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      {{-- Tanggal Lahir --}}
      <div class="form-col">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input id="tgl_lahir" type="date" name="tgl_lahir"
               class="input @error('tgl_lahir') error @enderror"
               value="{{ old('tgl_lahir', optional($user->profile?->tgl_lahir)->format('Y-m-d')) }}">
        <small class="helper">Tidak boleh di masa depan.</small>
        @error('tgl_lahir')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      {{-- Status --}}
      <div class="form-col">
        <label for="status">Status</label>
        <input id="status" type="text" name="status"
               class="input @error('status') error @enderror"
               value="{{ old('status', $user->profile?->status) }}"
               placeholder="Mis. Pelajar kelas 12">
        @error('status')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-actions">
        <button class="btn-primary" type="submit">
          <i class="fa-regular fa-floppy-disk"></i> Simpan Biodata
        </button>
      </div>
    </form>
  </section>

  {{-- Panel: Akun --}}
  <section id="panel-account" class="panel" role="tabpanel" aria-labelledby="tab-account" hidden>
    <form action="{{ route('student.profile.account') }}" method="POST" class="card form-grid" novalidate>
      @csrf @method('PUT')

      <div class="form-col">
        <label for="name">Nama</label>
        <input id="name" type="text" class="input @error('name') error @enderror" name="name"
               value="{{ old('name', $user->name) }}" required>
        @error('name')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-col">
        <label for="username">Username</label>
        <input id="username" type="text" class="input @error('username') error @enderror" name="username"
               value="{{ old('username', $user->username) }}">
        <small class="helper">Hanya huruf, angka, tanda hubung, dan garis bawah disarankan.</small>
        @error('username')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-col">
        <label>Email</label>
        <input type="email" class="input" value="{{ $user->email }}" disabled>
        <small class="helper">Email tidak dapat diubah.</small>
     </div>


      <div class="form-col">
        <label for="phone">No. HP</label>
        <input id="phone" type="text" class="input @error('phone') error @enderror" name="phone"
               value="{{ old('phone', $user->phone) }}">
        @error('phone')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-actions">
        <button class="btn-primary" type="submit">
          <i class="fa-regular fa-floppy-disk"></i> Simpan Akun
        </button>
      </div>
    </form>
  </section>

  {{-- Panel: Keamanan --}}
<section id="panel-security" class="panel" role="tabpanel" aria-labelledby="tab-security" hidden>
  {{-- ALERT AREA (KHUSUS KEAMANAN) --}}
  @if (session('status') === 'password-updated')
    <div class="alert success" role="status" style="margin-bottom:12px">
      <i class="fa-regular fa-circle-check"></i> Password berhasil diperbarui.
    </div>
  @endif

  @if ($errors->updatePassword->any())
    <div class="alert danger" role="alert" style="margin-bottom:12px">
      <strong>Gagal memperbarui password.</strong>
      <ul style="margin:.4rem 0 0; padding-left:1rem;">
        @foreach ($errors->updatePassword->all() as $msg)
          <li>{{ $msg }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('student.profile.password') }}" method="POST" class="card form-grid" novalidate>
    @csrf @method('PUT')

    <div class="form-col">
      <label for="current_password">Password Saat Ini</label>
      <input id="current_password" type="password"
             class="input @error('current_password','updatePassword') error @enderror"
             name="current_password" required autocomplete="current-password">
      @error('current_password','updatePassword')
        <small class="field-error">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-col">
      <label for="password">Password Baru</label>
      <input id="password" type="password"
             class="input @error('password','updatePassword') error @enderror"
             name="password" required autocomplete="new-password">
      <small class="helper">Gunakan kombinasi huruf besar/kecil, angka, dan simbol.</small>
      @error('password','updatePassword')
        <small class="field-error">{{ $message }}</small>
      @enderror
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

{{-- UX Script: tabs (keyboard-friendly), persist selected tab, avatar preview --}}
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
@endsection

{{-- Learnify — Student Profile --}}
