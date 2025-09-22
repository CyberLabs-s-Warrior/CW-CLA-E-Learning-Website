@extends('templates.app')
@section('title','Form Kategori Forum — Edit')

@section('content')
<div class="container-fluid">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 fw-bold text-dark">Edit Kategori</h1>
    <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-outline-secondary">
      <i class="fa fa-arrow-left me-1"></i> Kembali
    </a>
  </div>

  {{-- Error summary --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
      <strong>Periksa kembali isian kamu:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-semibold">Detail Kategori</div>
    <div class="card-body">
      <form class="needs-validation" novalidate
            method="POST"
            action="{{ route('admin.forum.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
          {{-- Nama --}}
          <div class="col-lg-6">
            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $category->name) }}" required maxlength="100"
                   placeholder="Mis. Pengumuman, Tanya Jawab, Tips & Trik">
            <div class="form-text d-flex justify-content-between">
              <span>Nama kategori yang ditampilkan publik.</span>
              <span><span id="name-count">0</span>/100</span>
            </div>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Slug --}}
          <div class="col-lg-6">
            <label for="slug" class="form-label">Slug <span class="text-muted">(opsional)</span></label>
            <div class="input-group">
              <span class="input-group-text d-none d-md-inline">/forum/</span>
              <input id="slug" name="slug" type="text"
                     class="form-control @error('slug') is-invalid @enderror"
                     value="{{ old('slug', $category->slug) }}"
                     placeholder="pengumuman">
            </div>
            <div class="form-text">
              Biarkan kosong untuk dibuat otomatis dari Nama.
              <span class="text-muted">Pratinjau: <code id="slug-preview">/forum/{{ old('slug', $category->slug) }}</code></span>
            </div>
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Deskripsi --}}
          <div class="col-12">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Gambaran singkat kategori ini.">{{ old('description', $category->description) }}</textarea>
            <div class="form-text">Opsional tapi disarankan untuk memandu pengguna.</div>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Urutan + Privat --}}
          <div class="col-md-6">
            <label for="sort_order" class="form-label">Urutan</label>
            <input id="sort_order" type="number" name="sort_order"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $category->sort_order) }}" min="0" step="1">
            <div class="form-text">Angka lebih kecil tampil lebih atas.</div>
            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input id="is_private" class="form-check-input" type="checkbox" name="is_private" value="1"
                     {{ old('is_private', $category->is_private) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_private">Kategori Privat</label>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button id="btn-submit" class="btn btn-primary">
            <span class="submit-label"><i class="fa fa-save me-1"></i> Simpan Perubahan</span>
            <span class="submit-loading d-none">
              <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan…
            </span>
          </button>
          <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function () {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const preview = document.getElementById('slug-preview');
    const nameCount = document.getElementById('name-count');
    const form = document.querySelector('form.needs-validation');
    const submitBtn = document.getElementById('btn-submit');
    const labelSpan = submitBtn?.querySelector('.submit-label');
    const loadingSpan = submitBtn?.querySelector('.submit-loading');

    function slugify(text) {
      return text.toString()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    }

    let slugTouched = !!slugInput.value;
    slugInput.addEventListener('input', () => {
      slugTouched = slugInput.value.length > 0;
      preview.textContent = '/forum/' + slugify(slugInput.value);
    });

    function updatePreviewFromName() {
      if (!slugTouched) {
        const s = slugify(nameInput.value);
        slugInput.value = s;
        preview.textContent = '/forum/' + s;
      }
      nameCount.textContent = nameInput.value.length;
    }

    nameInput.addEventListener('input', updatePreviewFromName);
    // init
    updatePreviewFromName();

    // Bootstrap validation + anti double submit
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault(); e.stopPropagation();
      } else {
        submitBtn.disabled = true;
        if (labelSpan && loadingSpan) { labelSpan.classList.add('d-none'); loadingSpan.classList.remove('d-none'); }
      }
      form.classList.add('was-validated');
    }, false);
  })();
</script>
@endpush
@endsection
