@extends('templates.app')

@section('title', 'Tambah Kursus Detail')

@section('content')
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div
      class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm"
      style="width: 44px; height: 44px;">
      <i class="fas fa-plus-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Kursus Baru</h1>
    </div>

    @if($errors->any())
    <div class="alert alert-danger shadow-sm">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
      <li>{{ $err }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.detail_courses.store') }}" method="POST" enctype="multipart/form-data"
      class="row g-3" id="course-form">
      @csrf

      <div class="col-12">
        <label for="course_id" class="form-label fw-semibold">Pilih Kursus</label>
        <select name="course_id" id="course_id" class="form-select shadow-sm" required>
        <option value="">-- Pilih Kursus --</option>
        @foreach($courseList as $id => $name)
      <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>
        {{ $name }}
      </option>
      @endforeach
        </select>
      </div>

      <div class="col-12">
        <label for="description" class="form-label fw-semibold">Deskripsi</label>
        <textarea name="description" id="description" class="form-control shadow-sm editor"
        rows="4">{{ old('description') }}</textarea>
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold">Modul</label>
        <div id="modules-list">
        <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" placeholder="Modul 1" required>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addModule()">
        <i class="fas fa-plus me-1"></i>Tambah Modul
        </button>
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold">Upload Media (Gambar / Video)</label>
        <div id="media-list">
        <div class="media-item mb-2">
          <input type="file" name="media[]" class="form-control shadow-sm media-input" accept="image/*,video/*">
          <div class="media-preview mt-1"></div>
        </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addMedia()">
        <i class="fas fa-plus me-1"></i>Tambah Media
        </button>
        <small class="text-muted fst-italic d-block mt-1">Format: JPG, PNG, MP4, MOV, AVI. Max 10MB per file.</small>
      </div>


      <div class="col-12 d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm d-flex align-items-center">
        <i class="fas fa-save me-2"></i>
        <span class="btn-text">Simpan</span>
        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
        </button>
        <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
        <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
  function addModule() {
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'modules[]';
    input.className = 'form-control mb-2 shadow-sm';
    input.placeholder = 'Modul tambahan';
    input.required = true;
    document.getElementById('modules-list').appendChild(input);
  }

  function addMedia() {
    const container = document.createElement('div');
    container.className = 'media-item mb-2';
    container.innerHTML = `
      <input type="file" name="media[]" class="form-control shadow-sm media-input" accept="image/*,video/*">
      <div class="media-preview mt-1"></div>
    `;
    document.getElementById('media-list').appendChild(container);

    container.querySelector('.media-input').addEventListener('change', handlePreview);
  }

  function handlePreview(e) {
    const previewContainer = e.target.parentElement.querySelector('.media-preview');
    previewContainer.innerHTML = '';
    const files = e.target.files;

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onload = function(event) {
        let element;
        if (file.type.startsWith('image/')) {
          element = document.createElement('img');
          element.src = event.target.result;
          element.style.maxHeight = '100px';
          element.className = 'me-2';
        } else if (file.type.startsWith('video/')) {
          element = document.createElement('video');
          element.src = event.target.result;
          element.controls = true;
          element.style.maxHeight = '100px';
          element.className = 'me-2';
        }
        previewContainer.appendChild(element);
      }

      reader.readAsDataURL(file);
    }
  }

  document.querySelectorAll('.media-input').forEach(input => {
    input.addEventListener('change', handlePreview);
  });

  let editorInstance;
  if (!window.hasInitializedEditor) {
    window.hasInitializedEditor = true;

    ClassicEditor
      .create(document.querySelector('#description'))
      .then(editor => {
        editorInstance = editor;
      })
      .catch(error => {
        console.error(error);
      });

    document.getElementById('course-form').addEventListener('submit', function(e) {
      if (editorInstance) {
        const data = editorInstance.getData().trim();
        document.querySelector('#description').value = data;

        if (data === '') {
          e.preventDefault();
          alert('Deskripsi tidak boleh kosong.');
        }
      }
    });
  }

  document.getElementById('course-form').addEventListener('submit', function() {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
  });
</script>
@endpush