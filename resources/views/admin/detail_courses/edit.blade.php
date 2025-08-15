@extends('templates.app')

@section('title', 'Edit Kursus Detail')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-edit"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Kursus Detail</h1>
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
      <form action="{{ route('admin.detail_courses.update', $detailCourse->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="course-form">
        @csrf
        @method('PUT')

        <div class="col-12">
          <label for="course_id" class="form-label fw-semibold">Pilih Kursus</label>
          <select name="course_id" id="course_id" class="form-select shadow-sm" required>
            <option value="">-- Pilih Kursus --</option>
            @foreach($courseList as $id => $name)
              <option value="{{ $id }}" {{ old('course_id', $detailCourse->course_id) == $id ? 'selected' : '' }}>
                {{ $name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="description" class="form-control shadow-sm editor" rows="4" required>{{ old('description', $detailCourse->description) }}</textarea>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Modul</label>
          <div id="modules-list">
            @php
              $modules = old('modules', $detailCourse->modules ?? []);
              if (!is_array($modules)) $modules = [];
            @endphp

            @if(count($modules))
              @foreach($modules as $modul)
                <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" value="{{ $modul }}" placeholder="Modul {{ $loop->iteration }}" required>
              @endforeach
            @else
              <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" placeholder="Modul 1" required>
            @endif
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addModule()">
            <i class="fas fa-plus me-1"></i>Tambah Modul
          </button>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Upload Media Tambahan (Gambar / Video)</label>
          
          @if($detailCourse->media && is_array($detailCourse->media))
            <div class="mt-2">
              <small class="text-muted d-block">Media saat ini:</small>
              <div class="rounded shadow-sm border p-2 bg-light d-flex gap-2 flex-wrap">
                @foreach($detailCourse->media as $index => $file)
                  <div class="position-relative">
                    @if(\Illuminate\Support\Str::contains($file, ['.mp4', '.webm', '.mov', '.avi']))
                      <video src="{{ asset('storage/' . $file) }}" controls width="150"></video>
                    @else
                      <img src="{{ asset('storage/' . $file) }}" alt="Media" class="img-fluid rounded" style="max-height: 150px;">
                    @endif
                    <div class="form-check mt-1 text-center">
                      <input class="form-check-input" type="checkbox" name="remove_media[]" value="{{ $index }}" id="remove-media-{{ $index }}">
                      <label class="form-check-label small" for="remove-media-{{ $index }}">Hapus</label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <div id="media-list" class="mt-2">
            <input type="file" name="media[]" class="form-control mb-2 shadow-sm" accept="image/*,video/*">
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addMedia()">
            <i class="fas fa-plus me-1"></i>Tambah Media
          </button>
          <small class="text-muted fst-italic d-block mt-1">Format: JPG, PNG, MP4, MOV, AVI. Max 10MB per file.</small>
        </div>

        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm" id="btn-submit">
            <span id="btn-text"><i class="fas fa-save me-2"></i>Update</span>
            <span id="btn-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
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
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'media[]';
    input.className = 'form-control mb-2 shadow-sm';
    input.accept = 'image/*,video/*';
    document.getElementById('media-list').appendChild(input);
  }

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

    document.getElementById('course-form').addEventListener('submit', function (e) {
      if (editorInstance) {
        const data = editorInstance.getData().trim();
        document.querySelector('#description').value = data;

        if (data === '') {
          e.preventDefault();
          alert('Deskripsi tidak boleh kosong.');
          return;
        }
      }

      const btnSubmit = document.getElementById('btn-submit');
      const btnText = document.getElementById('btn-text');
      const btnSpinner = document.getElementById('btn-spinner');

      btnText.classList.add('d-none');
      btnSpinner.classList.remove('d-none');
      btnSubmit.disabled = true;
    });
  }
</script>
@endpush
