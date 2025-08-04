@extends('templates.app')

@section('title', 'Tambah Materi')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-plus-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Materi</h1>
  </div>

  {{-- Card --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        {{-- Pilih Kursus --}}
        <div class="col-md-6">
          <label for="detail_courses_id" class="form-label fw-semibold">Kursus</label>
          <select name="detail_courses_id" id="detail_courses_id" class="form-select shadow-sm" required>
            <option value="">-- Pilih Kursus --</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
          </select>
        </div>

        {{-- Pilih Modul --}}
        <div class="col-md-6">
          <label for="module_name" class="form-label fw-semibold">Nama Modul</label>
          <select name="module_name" id="module_name" class="form-select shadow-sm" required disabled>
            <option value="">-- Pilih Modul --</option>
          </select>
        </div>

        {{-- Judul --}}
        <div class="col-md-12">
          <label for="title" class="form-label fw-semibold">Judul Materi</label>
          <input type="text" name="title" id="title" class="form-control shadow-sm" value="{{ old('title') }}" required>
        </div>

        {{-- Konten --}}
        <div class="col-md-12">
          <label for="content" class="form-label fw-semibold">Konten Materi</label>
          <textarea name="content" id="content" rows="4" class="form-control shadow-sm">{{ old('content') }}</textarea>
        </div>

        {{-- Upload Media --}}
        <div class="col-md-6">
          <label for="media" class="form-label fw-semibold">Upload Media (opsional)</label>
          <input type="file" name="media" id="media" class="form-control shadow-sm" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
        </div>

        {{-- Tombol --}}
        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="fas fa-save me-2"></i>Simpan
          </button>
          <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const courseSelect = document.getElementById('detail_courses_id');
  const moduleSelect = document.getElementById('module_name');

  courseSelect.addEventListener('change', function () {
    const courseId = this.value;
    moduleSelect.innerHTML = '<option value="">Sedang memuat modul...</option>';
    moduleSelect.disabled = true;

    if (!courseId) {
      moduleSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
      return;
    }

    fetch(`/admin/detail-courses/${courseId}/modules`)
      .then(response => {
        if (!response.ok) throw new Error("Gagal memuat modul.");
        return response.json();
      })
      .then(data => {
        let options = '<option value="">-- Pilih Modul --</option>';
        data.modules.forEach(module => {
          options += `<option value="${module}">${module}</option>`;
        });
        moduleSelect.innerHTML = options;
        moduleSelect.disabled = false;
      })
      .catch(error => {
        console.error(error);
        moduleSelect.innerHTML = '<option value="">Tidak dapat memuat modul</option>';
        moduleSelect.disabled = true;
      });
  });
</script>
@endsection
