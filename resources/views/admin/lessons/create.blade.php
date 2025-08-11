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
      <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="lesson-form">
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
          <button type="submit" class="btn btn-success rounded-pill px-4" id="btn-submit">
            <span id="btn-text"><i class="fas fa-save me-2"></i>Simpan</span>
            <span id="btn-saving" class="d-none">
              Menyimpan...
              <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
            </span>
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  let editorInstance;

  ClassicEditor
    .create(document.querySelector('#content'))
    .then(editor => {
      editorInstance = editor;
    })
    .catch(error => {
      console.error(error);
    });

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

  const form = document.getElementById('lesson-form');
  const btnSubmit = document.getElementById('btn-submit');
  const btnText = document.getElementById('btn-text');
  const btnSaving = document.getElementById('btn-saving');

  form.addEventListener('submit', function(e) {
    if (editorInstance) {
      const data = editorInstance.getData().trim();
      document.querySelector('#content').value = data;

      if (data === '') {
        e.preventDefault();
        alert('Konten materi tidak boleh kosong.');
        return;
      }
    }

    // Tampilkan teks "Menyimpan..." dan spinner, sembunyikan teks "Simpan"
    btnText.classList.add('d-none');
    btnSaving.classList.remove('d-none');
    btnSubmit.disabled = true;
  });
</script>
@endsection
