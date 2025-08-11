@extends('templates.app')

@section('title', 'Edit Course')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-pen-to-square"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Course</h1>
  </div>

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form id="editCourseForm" action="{{ route('admin.course.update', $course) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
          <label for="name" class="form-label fw-semibold">Nama Course</label>
          <input type="text" name="name" id="name" class="form-control shadow-sm" value="{{ old('name', $course->name) }}" required>
        </div>

        <div class="col-md-6">
          <label for="course_category_id" class="form-label fw-semibold">Kategori</label>
          <select name="course_category_id" id="course_category_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih category --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ (old('course_category_id', $course->course_category_id) == $category->id) ? 'selected' : '' }}>
                {{ $category->category }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="course_level_id" class="form-label fw-semibold">Level</label>
          <select name="course_level_id" id="course_level_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih level --</option>
            @foreach($levels as $level)
              <option value="{{ $level->id }}" {{ (old('course_level_id', $course->course_level_id) == $level->id) ? 'selected' : '' }}>
                {{ $level->level }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="price" class="form-label fw-semibold">Harga</label>
          <input type="number" name="price" id="price" class="form-control shadow-sm" value="{{ old('price', $course->price) }}" required>
        </div>

        <div class="col-md-6">
          <label for="img" class="form-label fw-semibold">Gambar Saat Ini</label><br>
          @if($course->img)
            <img src="{{ asset('storage/' . $course->img) }}" alt="Gambar Course" class="img-thumbnail rounded mb-2" width="100">
          @else
            <p class="text-muted">Belum ada gambar</p>
          @endif
          <input type="file" name="img" id="img" class="form-control shadow-sm mt-2">
        </div>

        {{-- Tombol --}}
        <div class="col-12 d-flex gap-2 mt-4">
          <button id="submitBtn" type="submit" class="btn btn-warning rounded-pill px-4 d-flex align-items-center">
            <i class="fas fa-save me-2"></i>
            <span class="btn-text">Update</span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
          </button>
          <a href="{{ route('admin.course.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert notifikasi
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
      });
    @elseif(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });
    @endif

    // Spinner loading saat submit form
    const form = document.getElementById('editCourseForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      spinner.classList.remove('d-none');
      btnText.textContent = 'Menyimpan...';
    });
  });
</script>
@endpush
