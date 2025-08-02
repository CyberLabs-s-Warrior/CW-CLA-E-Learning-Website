@extends('templates.app')

@section('title', 'Tambah Kategori Course')

@section('content')
<div class="container-fluid py-4 animate-fade-in">

  {{-- Header --}}
  <div class="d-flex align-items-center mb-4 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow" style="background: linear-gradient(135deg, #81d4fa, #29b6f6);">
        <i class="fas fa-folder-plus fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-1">Tambah Kategori Course</h1>
      <p class="text-muted mb-0">Masukkan nama kategori course yang ingin ditambahkan</p>
    </div>
  </div>

  {{-- Form --}}
  <form action="{{ route('admin.course-categories.store.category') }}" method="POST" class="animate-fade-up">
    @csrf

    <div class="mb-3">
      <label for="category" class="form-label fw-semibold">Nama Kategori</label>
      <input type="text" name="category" id="category" class="form-control shadow-sm rounded-3 @error('category') is-invalid @enderror" placeholder="Contoh: Programming" required>
      @error('category')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">
        <i class="fas fa-save me-2"></i>Simpan
      </button>
      <a href="{{ route('admin.course-categories.create') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>
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
    background: linear-gradient(135deg, #81d4fa, #29b6f6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  /* Animasi */
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
