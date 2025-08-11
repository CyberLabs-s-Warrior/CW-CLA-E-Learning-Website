@extends('templates.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid py-4">
  {{-- Heading --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-edit"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Kategori</h1>
  </div>

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-primary border-bottom-0">
      <i class="fas fa-folder-tree me-2"></i>Form Edit Kategori
    </div>
    <div class="card-body">
      <form id="editCategoryForm" method="POST" action="{{ route('admin.course-categories.update', $category->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        {{-- Input --}}
        <div>
          <label for="category" class="form-label fw-semibold">Nama Kategori</label>
          <input
            type="text"
            id="category"
            name="category"
            class="form-control shadow-sm @error('category') is-invalid @enderror"
            value="{{ old('category', $category->category) }}"
            required
          >
          @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 align-items-center">
          <button type="submit" id="submitBtn" class="btn btn-warning rounded-pill px-4 d-flex align-items-center">
            <i class="fas fa-save me-2"></i>
            <span class="btn-text">Update</span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
          </button>
          <a href="{{ route('admin.course-categories.index') }}" class="btn btn-secondary rounded-pill px-4 d-flex align-items-center">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // SweetAlert for flash messages
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

      // Spinner & disable button on submit
      const form = document.getElementById('editCategoryForm');
      const submitBtn = document.getElementById('submitBtn');
      const spinner = submitBtn.querySelector('.spinner-border');
      const btnText = submitBtn.querySelector('.btn-text');

      form.addEventListener('submit', () => {
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Menyimpan...';
      });
    });
  </script>
@endsection
