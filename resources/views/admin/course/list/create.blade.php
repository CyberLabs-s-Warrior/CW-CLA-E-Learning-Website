@extends('templates.app')

@section('title', 'Tambah Course')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-plus-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Course Baru</h1>
  </div>

  {{-- Form Card --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
          <label for="name" class="form-label fw-semibold">Nama Course</label>
          <input type="text" name="name" id="name" class="form-control shadow-sm" required>
        </div>

        <div class="col-md-6">
          <label for="course_category_id" class="form-label fw-semibold">Kategori</label>
          <select name="course_category_id" id="course_category_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih category --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->category }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="course_level_id" class="form-label fw-semibold">Level</label>
          <select name="course_level_id" id="course_level_id" class="form-select shadow-sm" required>
            <option value="">-- Silahkan memilih level --</option>
            @foreach($levels as $level)
              <option value="{{ $level->id }}">{{ $level->level }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="price" class="form-label fw-semibold">Harga</label>
          <input type="number" name="price" id="price" class="form-control shadow-sm" required>
        </div>

        <div class="col-md-6">
          <label for="img" class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="img" id="img" class="form-control shadow-sm">
        </div>

        {{-- Tombol --}}
        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="fas fa-save me-2"></i>Simpan
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
    // Show success alert
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
      });
    @endif

    // Show error alert
    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });
    @endif
  });
</script>
@endpush
