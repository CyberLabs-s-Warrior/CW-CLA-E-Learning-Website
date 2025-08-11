@extends('templates.app')

@section('title', 'Edit Level')

@section('content')
<div class="container-fluid py-4">
  {{-- Heading --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-signal"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Level</h1>
  </div>

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-success border-bottom-0">
      <i class="fas fa-signal me-2"></i>Form Edit Level
    </div>
    <div class="card-body">
      <form id="editLevelForm" method="POST" action="{{ route('admin.course-levels.update', $level->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        {{-- Input Level --}}
        <div>
          <label for="level" class="form-label fw-semibold">Nama Level</label>
          <input type="text" name="level" id="level"
                 class="form-control shadow-sm @error('level') is-invalid @enderror"
                 value="{{ old('level', $level->level) }}" placeholder="Masukkan nama level" required>
          @error('level')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 mt-2">
          <button id="submitBtn" type="submit" class="btn btn-success rounded-pill px-4 d-flex align-items-center">
            <i class="fas fa-save me-1"></i>
            <span class="btn-text">Update</span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
          </button>
          <a href="{{ route('admin.course-categories.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali
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

    // Spinner loading on submit
    const form = document.getElementById('editLevelForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    form.addEventListener('submit', function() {
      submitBtn.disabled = true;
      spinner.classList.remove('d-none');
      btnText.textContent = 'Menyimpan...';
    });
  });
</script>
@endsection
