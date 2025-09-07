{{-- resources/views/admin/instructors/edit.blade.php --}}
@extends('templates.app')
@section('title','Edit Profil Instruktur')

@section('content')
<div class="container-fluid py-3 py-md-4 instructor-edit">

  {{-- Header --}}
  <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
    <div>
      <h1 class="h4 mb-0">Edit Profil: {{ $profile->user->name ?? 'Instruktur' }}</h1>
      <div class="text-muted small">Perbarui informasi instruktur di bawah ini.</div>
    </div>
    <a href="{{ route('admin.instruktur.index') }}" class="btn btn-outline-secondary ms-md-auto">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
  </div>

  {{-- Errors --}}
  @if($errors->any())
    <div class="alert alert-danger rounded-3 shadow-sm">
      <div class="fw-semibold mb-1"><i class="fas fa-circle-exclamation me-2"></i>Perbaiki isian berikut:</div>
      <ul class="mb-0 small">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <form action="{{ route('admin.instruktur.update', $profile) }}" method="post" enctype="multipart/form-data"
        class="card border-0 shadow-sm rounded-4">
    @csrf
    @method('PUT')

    <div class="card-body p-3 p-md-4">
      <div class="row g-4">
        {{-- Kolom kiri: form utama --}}
        <div class="col-lg-8">

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Bidang (primary skill) <span class="text-danger">*</span></label>
              <input type="text"
                     name="primary_skill"
                     value="{{ old('primary_skill',$profile->primary_skill) }}"
                     maxlength="120"
                     required
                     class="form-control @error('primary_skill') is-invalid @enderror">
              @error('primary_skill') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">Contoh: Fullstack Developer, Mobile Engineer, Data/AI, dsb.</div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Urutan</label>
              <input type="number"
                     name="sort_order"
                     value="{{ old('sort_order',$profile->sort_order) }}"
                     min="0"
                     class="form-control @error('sort_order') is-invalid @enderror">
              @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">Angka kecil tampil lebih dulu.</div>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Deskripsi singkat <span class="text-danger">*</span></label>
            <textarea name="short_bio"
                      rows="5"
                      maxlength="600"
                      required
                      oninput="window.updateBioCount(this)"
                      class="form-control @error('short_bio') is-invalid @enderror">{{ old('short_bio',$profile->short_bio) }}</textarea>
            @error('short_bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="d-flex justify-content-between small text-muted mt-1">
              <span>Tips: jelaskan ringkas keahlian & pengalaman utama.</span>
              <span><span id="bioCount">0</span>/600</span>
            </div>
          </div>

          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <label class="form-label">GitHub</label>
              <input type="url"
                     name="github_url"
                     value="{{ old('github_url',$profile->github_url) }}"
                     placeholder="https://github.com/username"
                     class="form-control @error('github_url') is-invalid @enderror">
              @error('github_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">LinkedIn</label>
              <input type="url"
                     name="linkedin_url"
                     value="{{ old('linkedin_url',$profile->linkedin_url) }}"
                     placeholder="https://www.linkedin.com/in/username"
                     class="form-control @error('linkedin_url') is-invalid @enderror">
              @error('linkedin_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        {{-- Kolom kanan: status & avatar --}}
        <div class="col-lg-4">
          <div class="card border-0 bg-light rounded-4">
            <div class="card-body">

              <div class="mb-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox"
                         id="pub" name="is_published" value="1"
                         {{ old('is_published', $profile->is_published) ? 'checked' : '' }}>
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
                       class="form-control @error('avatar') is-invalid @enderror"
                       onchange="window.previewAvatar(this)">
                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">jpg/png/webp, maks 1MB. Mengunggah foto baru akan mengganti foto saat ini.</div>
              </div>

              @php
                $current = $profile->avatar_path ? asset('storage/'.$profile->avatar_path) : null;
                $fallbackName = $profile->user->name ?? 'Instruktur';
                $placeholder = 'https://ui-avatars.com/api/?name='.urlencode($fallbackName).'&background=EAF2FF&color=0D6EFD&bold=true';
              @endphp

              <div class="text-center">
                <div class="ratio ratio-1x1 rounded-3 overflow-hidden bg-white border"
                     style="max-width: 180px; margin: 10px auto 0;">
                  <img id="avatarPreview"
                       src="{{ $current ?: $placeholder }}"
                       alt="Foto {{ $profile->user?->name ?? 'Instruktur' }}"
                       class="w-100 h-100 object-fit-cover">
                </div>
                <div class="small text-muted mt-2">Preview</div>
              </div>

            </div>
          </div>
        </div>
      </div>{{-- /row --}}
    </div>{{-- /card-body --}}

    <div class="card-footer bg-white d-flex flex-column flex-sm-row gap-2 justify-content-end p-3 p-md-3 rounded-bottom-4">
      <a href="{{ route('admin.instruktur.index') }}" class="btn btn-light">Kembali</a>
      <button class="btn btn-primary">
        <i class="fas fa-save me-2"></i>Update
      </button>
    </div>
  </form>
</div>
@endsection

@push('styles')
<style>
  /* Scoped styling untuk halaman edit instruktur */
  .instructor-edit .rounded-4{ border-radius: 1rem; }
  .instructor-edit .rounded-bottom-4{ border-bottom-left-radius:1rem; border-bottom-right-radius:1rem; }
  .instructor-edit .object-fit-cover{ object-fit: cover; }
  .instructor-edit .form-label{ font-weight: 600; }
  .instructor-edit .form-text{ color:#64748b; }
</style>
@endpush

@push('scripts')
<script>
  // Counter bio
  window.updateBioCount = function(el){
    document.getElementById('bioCount').textContent = (el.value || '').length;
  };
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
    reader.onload = e => (img.src = e.target.result);
    reader.readAsDataURL(file);
  };
</script>
@endpush
