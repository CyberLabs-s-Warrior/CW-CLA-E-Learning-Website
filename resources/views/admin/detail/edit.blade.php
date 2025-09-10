@extends('templates.app')

@section('title', 'Edit Kursus Detail')

@section('content')
  <div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 44px; height: 44px;">
          <i class="fas fa-edit"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Edit Kursus Detail</h1>
    </div>

    {{-- Error Validation --}}
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
        <form action="{{ route('admin.detail.update', $detail) }}" method="POST" id="course-form">
          @csrf
          @method('PUT')

          {{-- Pilih Course --}}
          <div class="mb-4">
            <label for="course_id" class="form-label fw-semibold">Pilih Kursus</label>
            <select name="course_id" id="course_id" class="form-select shadow-sm" required>
              <option value="">-- Pilih Kursus --</option>
              @foreach($courseList as $id => $name)
                <option value="{{ $id }}" {{ old('course_id', $detail->course_id) == $id ? 'selected' : '' }}>
                  {{ $name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Pilih Instruktur (dinamis) --}}
          <div class="mb-4">
            <label class="form-label fw-semibold">Instruktur</label>
            <div id="instructor-wrapper">
              @php
                $selected = old('instructors', $detail->instructors->pluck('id')->toArray());
              @endphp
              @forelse($selected as $insId)
                <div class="input-group mb-2 instructor-item">
                  <select name="instructors[]" class="form-select shadow-sm instructor-select" required>
                    <option value="">-- Pilih Instruktur --</option>
                    @foreach($instructors as $ins)
                      <option value="{{ $ins->id }}"
                        data-avatar="{{ $ins->avatar_path ? asset('storage/' . $ins->avatar_path) : '/default-avatar.png' }}"
                        data-skill="{{ $ins->primary_skill }}"
                        {{ $insId == $ins->id ? 'selected' : '' }}>
                        {{ $ins->user->name }}
                      </option>
                    @endforeach
                  </select>
                  <button type="button" class="btn btn-outline-danger btn-remove-instructor {{ $loop->first ? 'd-none' : '' }}">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              @empty
                {{-- fallback kalau tidak ada instruktur terpilih --}}
                <div class="input-group mb-2 instructor-item">
                  <select name="instructors[]" class="form-select shadow-sm instructor-select" required>
                    <option value="">-- Pilih Instruktur --</option>
                    @foreach($instructors as $ins)
                      <option value="{{ $ins->id }}"
                        data-avatar="{{ $ins->avatar_path ? asset('storage/' . $ins->avatar_path) : '/default-avatar.png' }}"
                        data-skill="{{ $ins->primary_skill }}">
                        {{ $ins->user->name }}
                      </option>
                    @endforeach
                  </select>
                  <button type="button" class="btn btn-outline-danger btn-remove-instructor d-none">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              @endforelse
            </div>
            <button type="button" class="btn btn-outline-success btn-sm mt-2" id="btn-add-instructor">
              <i class="fas fa-plus"></i> Tambah Instruktur
            </button>
            <small class="text-muted d-block mt-1">Anda bisa menambahkan lebih dari satu instruktur.</small>
          </div>

          {{-- Preview Data Course --}}
          <div id="course-preview" class="mb-4 d-none">
            <div class="border rounded-3 p-3 bg-light">
              <h5 class="fw-bold mb-3">Preview Data Kursus</h5>
              <div class="d-flex align-items-center gap-3">
                <img id="preview-image" src="" alt="cover" class="rounded shadow-sm" style="max-height:100px;">
                <div>
                  <h6 id="preview-title" class="fw-bold mb-1"></h6>
                  <div class="text-muted small">
                    <span id="preview-levels"></span> |
                    <span id="preview-duration"></span>
                  </div>
                </div>
              </div>

              <hr>
              <p class="fw-semibold mb-1">Modul:</p>
              <ul id="preview-lessons" class="mb-3"></ul>

              <p class="fw-semibold mb-1">Mentor:</p>
              <ul id="preview-instructors" class="mb-3"></ul>
            </div>
          </div>

          {{-- Deskripsi --}}
          <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Deskripsi</label>
            <textarea name="description" id="description" class="form-control shadow-sm editor" rows="4">{{ old('description', $detail->description) }}</textarea>
          </div>

          {{-- Outcomes --}}
          <div class="mb-3">
            <label for="outcomes" class="form-label fw-semibold">Hasil yang Dicapai</label>
            <textarea name="outcomes" id="outcomes" class="form-control shadow-sm editor" rows="3">{{ old('outcomes', $detail->outcomes) }}</textarea>
          </div>

          <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm d-flex align-items-center" id="btn-submit">
              <span id="btn-text"><i class="fas fa-save me-2"></i>Update</span>
              <span id="btn-spinner" class="d-none">
                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                Menyimpan...
              </span>
            </button>
            <a href="{{ route('admin.detail.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
              <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{-- CKEditor 5 --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

  <script>
    // Init CKEditor
    document.querySelectorAll('.editor').forEach((el) => {
      ClassicEditor.create(el).catch(err => console.error(err));
    });

    // Spinner submit
    const form = document.getElementById('course-form');
    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', function () {
      btnSubmit.disabled = true;
      btnText.classList.add('d-none');
      btnSpinner.classList.remove('d-none');
    });

    // --- Preview course ---
    const courseSelect = document.getElementById('course_id');
    const previewBox = document.getElementById('course-preview');
    const previewImg = document.getElementById('preview-image');
    const previewTitle = document.getElementById('preview-title');
    const previewLevels = document.getElementById('preview-levels');
    const previewDuration = document.getElementById('preview-duration');
    const previewLessons = document.getElementById('preview-lessons');
    const previewInstructors = document.getElementById('preview-instructors');

    // wrapper untuk instructor select
    const wrapper = document.getElementById("instructor-wrapper");
    const btnAdd = document.getElementById("btn-add-instructor");

    // --- Update preview instructors (dibuat global supaya bisa dipanggil dari mana saja) ---
    function updatePreviewInstructors() {
      previewInstructors.innerHTML = "";
      wrapper.querySelectorAll("select").forEach(select => {
        let option = select.options[select.selectedIndex];
        if (option && option.value) {
          let avatar = option.dataset.avatar || "/default-avatar.png";
          let skill = option.dataset.skill || "";
          let name = option.text;
          previewInstructors.innerHTML += `
              <li class="d-flex align-items-center mb-1">
                <img src="${avatar}" class="rounded-circle me-2" style="width:28px;height:28px;object-fit:cover;">
                <div>
                  <span class="fw-semibold">${name}</span>
                  <small class="text-muted d-block">${skill}</small>
                </div>
              </li>`;
        }
      });
    }

    function renderPreview(data) {
      previewBox.classList.remove('d-none');
      previewTitle.textContent = data.course.name || '';
      previewImg.src = data.course.image_url || '/default.jpg';
      previewLevels.textContent = data.course.level || '';
      previewDuration.textContent = data.course.duration || '-';

      previewLessons.innerHTML = '';
      (data.lessons || []).forEach(l => {
        previewLessons.innerHTML += `<li><span class="fw-semibold">${l.title}</span> 
                                       <span class="text-muted small">(${l.duration_formatted})</span></li>`;
      });

      // panggil update preview instructors biar mentor langsung muncul
      updatePreviewInstructors();
    }

    function fetchPreview(courseId){
      if(!courseId){ 
        previewBox.classList.add('d-none'); 
        return; 
      }
      fetch(`/admin/detail/course/${courseId}/info`)
        .then(res => res.json())
        .then(data => renderPreview(data))
        .catch(err => console.error('Fetch error:', err));
    }

    courseSelect.addEventListener('change', function(){ 
      fetchPreview(this.value); 
    });

    // --- Dynamic instructors ---
    document.addEventListener("DOMContentLoaded", function () {
      btnAdd.addEventListener("click", function () {
        const firstItem = wrapper.querySelector(".instructor-item");
        const newItem = firstItem.cloneNode(true);
        newItem.querySelector("select").value = "";
        newItem.querySelector(".btn-remove-instructor").classList.remove("d-none");
        wrapper.appendChild(newItem);
      });

      wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".btn-remove-instructor")) {
          e.target.closest(".instructor-item").remove();
          updatePreviewInstructors();
        }
      });

      wrapper.addEventListener("change", function (e) {
        if (e.target.tagName === "SELECT") {
          updatePreviewInstructors();
        }
      });

      // init: kalau course sudah terpilih, langsung fetch + render preview
      if(courseSelect.value){ 
        fetchPreview(courseSelect.value); 
      }

      // init preview instructors pada load pertama (supaya mentor langsung muncul saat edit)
      updatePreviewInstructors();
    });
  </script>
@endpush
