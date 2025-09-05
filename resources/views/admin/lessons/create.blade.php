@extends('templates.app')

@section('title', 'Tambah Materi')

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
      <h1 class="h4 fw-semibold mb-0">Tambah Materi</h1>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body">
        <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data" class="row g-3"
          id="lesson-form">
          @csrf

          <div class="col-md-6">
            <label for="course_id" class="form-label fw-semibold">Kursus</label>
            <select name="course_id" id="course_id" class="form-select shadow-sm @error('course_id') is-invalid @enderror"
              required>
              <option value="">-- Pilih Kursus --</option>
              @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                  {{ $course->name }}
                </option>
              @endforeach
            </select>
            @error('course_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="module_select" class="form-label fw-semibold">Nama Modul</label>
            <select id="module_select" class="form-select shadow-sm @error('module_name') is-invalid @enderror" required
              disabled>
              <option value="">-- Pilih Modul --</option>
            </select>
            @error('module_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6 d-none" id="module_manual_wrapper">
            <label for="module_manual" class="form-label fw-semibold">Nama Modul Baru</label>
            <input type="text" id="module_manual" class="form-control shadow-sm">
          </div>
          <input type="hidden" name="detail_courses_id" id="detail_courses_id" value="{{ old('detail_courses_id') }}">
          <input type="hidden" name="module_name" id="module_name" value="{{ old('module_name') }}">

          <div class="col-md-12">
            <label for="title" class="form-label fw-semibold">Judul Materi</label>
            <input type="text" name="title" id="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
              value="{{ old('title') }}" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-12">
            <label for="content" class="form-label fw-semibold">Konten Materi</label>
            <textarea name="content" id="content" rows="4"
              class="form-control shadow-sm @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Upload Media --}}
          <div class="col-md-6">
            <label for="media" class="form-label fw-semibold">Upload Media (opsional)</label>
            <input type="file" name="media" id="media" class="form-control shadow-sm @error('media') is-invalid @enderror"
              accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
            @error('media')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Durasi Manual --}}
          <div
            class="col-md-6 {{ old('duration_hours') || old('duration_minutes') || old('duration_seconds') ? '' : 'd-none' }}"
            id="duration_wrapper">
            <label class="form-label fw-semibold">Durasi Materi</label>
            <div class="d-flex gap-2">
              <input type="number" name="duration_hours" id="duration_hours"
                class="form-control shadow-sm @error('duration_hours') is-invalid @enderror" placeholder="Jam" min="0"
                value="{{ old('duration_hours', 0) }}">
              <input type="number" name="duration_minutes" id="duration_minutes"
                class="form-control shadow-sm @error('duration_minutes') is-invalid @enderror" placeholder="Menit" min="0"
                max="59" value="{{ old('duration_minutes', 0) }}">
              <input type="number" name="duration_seconds" id="duration_seconds"
                class="form-control shadow-sm @error('duration_seconds') is-invalid @enderror" placeholder="Detik" min="0"
                max="59" value="{{ old('duration_seconds', 0) }}">
            </div>
            <small class="text-muted">
              * Wajib diisi jika media bukan video<br>
              * Contoh: <b>1 jam 20 menit 15 detik</b>
            </small>
            @error('duration_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @error('duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @error('duration_seconds') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
    ClassicEditor.create(document.querySelector('#content'))
      .then(editor => { editorInstance = editor; })
      .catch(error => { console.error(error); });

    const courseSelect = document.getElementById('course_id');
    const moduleSelect = document.getElementById('module_select');
    const moduleManualWrapper = document.getElementById('module_manual_wrapper');
    const moduleManualInput = document.getElementById('module_manual');
    const detailCourseInput = document.getElementById('detail_courses_id');
    const moduleNameInput = document.getElementById('module_name');

    const mediaInput = document.getElementById('media');
    const durationWrapper = document.getElementById('duration_wrapper');

    const durationHours = document.getElementById('duration_hours');
    const durationMinutes = document.getElementById('duration_minutes');
    const durationSeconds = document.getElementById('duration_seconds');

    // Toggle durasi manual jika bukan video
    mediaInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) {
        durationWrapper.classList.add('d-none');
        durationHours.value = 0;
        durationMinutes.value = 0;
        durationSeconds.value = 0;
        return;
      }

      const ext = file.name.split('.').pop().toLowerCase();
      const videoExt = ['mp4', 'mov', 'avi'];

      if (videoExt.includes(ext)) {
        durationWrapper.classList.add('d-none');
        durationHours.value = 0;
        durationMinutes.value = 0;
        durationSeconds.value = 0;
      } else {
        durationWrapper.classList.remove('d-none');
      }
    });

    courseSelect.addEventListener('change', function () {
      const courseId = this.value;
      moduleSelect.innerHTML = '<option value="">Sedang memuat modul...</option>';
      moduleSelect.disabled = true;
      detailCourseInput.value = '';
      moduleNameInput.value = '';
      moduleManualWrapper.classList.add('d-none');
      moduleManualInput.value = '';

      if (!courseId) {
        moduleSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
        return;
      }

      fetch(`/admin/course/${courseId}/modules`)
        .then(response => {
          if (!response.ok) throw new Error("Gagal memuat modul.");
          return response.json();
        })
        .then(data => {
          let options = '<option value="">-- Pilih Modul --</option>';
          data.forEach(item => {
            options += `<option value="${item.detail_courses_id}" data-name="${item.module_name}">${item.module_name}</option>`;
          });
          options += `<option value="__new__">+ Tambah Modul Baru</option>`;
          moduleSelect.innerHTML = options;
          moduleSelect.disabled = false;
        })
        .catch(error => {
          console.error(error);
          moduleSelect.innerHTML = '<option value="">Tidak dapat memuat modul</option>';
          moduleSelect.disabled = true;
        });
    });

    moduleSelect.addEventListener('change', function () {
      const selectedValue = this.value;
      const selectedOption = this.options[this.selectedIndex];

      if (selectedValue === '__new__') {
        moduleManualWrapper.classList.remove('d-none');
        detailCourseInput.value = '';
        moduleNameInput.value = '';
      } else {
        moduleManualWrapper.classList.add('d-none');
        moduleManualInput.value = '';
        detailCourseInput.value = selectedValue;
        moduleNameInput.value = selectedOption.dataset.name || '';
      }
    });

    const form = document.getElementById('lesson-form');
    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnSaving = document.getElementById('btn-saving');

    form.addEventListener('submit', function (e) {
      if (editorInstance) {
        const data = editorInstance.getData().trim();
        document.querySelector('#content').value = data;

        if (data === '') {
          e.preventDefault();
          alert('Konten materi tidak boleh kosong.');
          return;
        }
      }

      if (moduleSelect.value === '__new__') {
        const manualValue = moduleManualInput.value.trim();
        if (!manualValue) {
          e.preventDefault();
          alert('Silakan isi nama modul baru.');
          return;
        }
        moduleNameInput.value = manualValue;
      }

      if (!moduleNameInput.value) {
        e.preventDefault();
        alert('Silakan pilih atau masukkan modul terlebih dahulu.');
        return;
      }

      // Validasi durasi kalau bukan video
      if (!durationWrapper.classList.contains('d-none')) {
        const h = parseInt(durationHours.value || 0);
        const m = parseInt(durationMinutes.value || 0);
        const s = parseInt(durationSeconds.value || 0);

        if (h === 0 && m === 0 && s === 0) {
          e.preventDefault();
          alert('Durasi wajib diisi minimal 1 detik untuk media non-video.');
          return;
        }
      }

      btnText.classList.add('d-none');
      btnSaving.classList.remove('d-none');
      btnSubmit.disabled = true;
    });
  </script>
@endsection