@extends('templates.app')

@section('title', 'Tambah Level Course')

@section('content')
<div class="container-fluid py-4 animate-fade-in">

  {{-- Header --}}
  <div class="d-flex align-items-center mb-4 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow" style="background: linear-gradient(135deg, #a5d6a7, #66bb6a);">
        <i class="fas fa-signal fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-1">Tambah Level Course</h1>
      <p class="text-muted mb-0">Silakan isi nama level yang akan digunakan pada course</p>
    </div>
  </div>

  {{-- Form --}}
  <form id="levelForm" action="{{ route('admin.course-levels.store') }}" method="POST" class="animate-fade-up">
    @csrf

    <div class="mb-3">
      <label for="level" class="form-label fw-semibold">Nama Level</label>
      <input
        type="text"
        name="level"
        id="level"
        class="form-control shadow-sm rounded-3 @error('level') is-invalid @enderror"
        placeholder="Contoh: Pemula"
        required
      >
      @error('level')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-3 d-flex align-items-center gap-2">
      <button
        id="submitBtn"
        type="submit"
        class="btn btn-success rounded-pill px-4 d-flex align-items-center"
      >
        <i class="fas fa-save me-2"></i>
        <span class="btn-text">Simpan</span>
        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
      </button>
      <a href="{{ route('admin.course-categories.create') }}" class="btn btn-secondary rounded-pill px-4 d-flex align-items-center">
        <i class="fas fa-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </form>
</div>
@endsection

@section('styles')
<style>
  .icon-circle-lg {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #a5d6a7, #66bb6a);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in {
    animation: fadeIn 0.6s ease-in-out both;
  }

  .animate-slide-up {
    animation: slideUp 0.6s ease-in-out both;
  }

  .animate-fade-up {
    opacity: 0;
    animation: fadeIn 0.5s ease-in-out forwards;
  }
</style>
@endsection

@section('scripts')
<script>
  document.getElementById('levelForm').addEventListener('submit', function () {
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Menyimpan...';
  });
</script>
@endsection
