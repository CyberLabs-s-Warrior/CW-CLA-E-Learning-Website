@extends('templates.app')

@section('title', 'Edit Kursus Detail')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-edit"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Kursus Detail</h1>
  </div>

  {{-- Error Message --}}
  @if($errors->any())
    <div class="alert alert-danger shadow-sm">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.detail_courses.update', $detailCourse->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="course-form">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="col-12">
          <label for="title" class="form-label fw-semibold">Judul Kursus</label>
          <input type="text" name="title" id="title" class="form-control shadow-sm" required value="{{ old('title', $detailCourse->title) }}">
        </div>

        {{-- Deskripsi --}}
        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="description" class="form-control shadow-sm" rows="4" required>{{ old('description', $detailCourse->description) }}</textarea>
        </div>

        {{-- Modul --}}
        <div class="col-12">
          <label class="form-label fw-semibold">Modul</label>
          <div id="modules-list">
            @php
              $modules = old('modules', $detailCourse->modules ?? []);
              if (!is_array($modules)) {
                $modules = [];
              }
            @endphp

            @if(count($modules))
              @foreach($modules as $index => $modul)
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

        {{-- Media --}}
        <div class="col-12">
          <label for="media" class="form-label fw-semibold">Upload Media (Gambar / Video)</label>
          <input type="file" name="media" id="media" class="form-control shadow-sm" accept="image/*,video/*">
          <small class="text-muted fst-italic">Format yang didukung: JPG, PNG, MP4, dll.</small>

          @if($detailCourse->media)
            <div class="mt-2">
              <small class="text-muted d-block">Media saat ini:</small>
              <div class="rounded shadow-sm border p-2 bg-light">
                @if(\Illuminate\Support\Str::contains($detailCourse->media, ['.mp4', '.webm']))
                  <video src="{{ asset('storage/' . $detailCourse->media) }}" controls width="250"></video>
                @else
                  <img src="{{ asset('storage/' . $detailCourse->media) }}" alt="Media" class="img-fluid rounded" style="max-height: 200px;">
                @endif
              </div>
            </div>
          @endif
        </div>

        {{-- Aksi --}}
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
  {{-- CKEditor --}}
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

        // Tampilkan spinner dan disable tombol submit
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
