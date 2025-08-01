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
      <form method="POST" action="{{ route('admin.course-categories.update', $category->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        {{-- Input --}}
        <div>
          <label for="category" class="form-label fw-semibold">Nama Kategori</label>
          <input type="text" id="category" name="category" class="form-control shadow-sm @error('category') is-invalid @enderror"
                 value="{{ old('category', $category->category) }}" required>
          @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-warning rounded-pill px-4">
            <i class="fas fa-save me-1"></i> Update
          </button>
          <a href="{{ route('admin.course-categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SweetAlert for success/error --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
  </script>
@endsection
