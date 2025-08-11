@extends('templates.app')

@section('title', 'Tambah Rentang Harga Course')

@section('content')
<div class="container-fluid py-4 animate-fade-in">

  {{-- Header --}}
  <div class="d-flex align-items-center mb-4 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow" style="background: linear-gradient(135deg, #ff8a65, #ff7043);">
        <i class="fas fa-money-check-alt fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-1">Tambah Rentang Harga</h1>
      <p class="text-muted mb-0">Masukkan harga minimum dan maksimum untuk course</p>
    </div>
  </div>

  {{-- Form --}}
  <form id="priceForm" action="{{ route('admin.course-prices.store') }}" method="POST" class="animate-fade-up">
    @csrf

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="min_price" class="form-label fw-semibold">Harga Minimum</label>
        <input type="number" name="min_price" id="min_price" class="form-control shadow-sm rounded-3 @error('min_price') is-invalid @enderror" placeholder="Contoh: 1000" required>
        @error('min_price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6 mb-3">
        <label for="max_price" class="form-label fw-semibold">Harga Maksimum</label>
        <input type="number" name="max_price" id="max_price" class="form-control shadow-sm rounded-3 @error('max_price') is-invalid @enderror" placeholder="Contoh: 10000" required>
        @error('max_price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

<div class="mt-4 d-flex gap-2">
  <button
    id="submitBtn"
    type="submit"
    class="btn btn-primary rounded-pill px-4 d-flex align-items-center"
  >
    <i class="fas fa-save me-2"></i>
    <span class="btn-text">Simpan</span>
    <span
      class="spinner-border spinner-border-sm ms-2 d-none"
      role="status"
      aria-hidden="true"
    ></span>
  </button>

  <a
    href="{{ route('admin.course-categories.create') }}"
    class="btn btn-secondary rounded-pill px-4 d-flex align-items-center"
  >
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
    background: linear-gradient(135deg, #ff8a65, #ff7043);
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

@section('scripts')
<script>
  document.getElementById('priceForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    // Tampilkan spinner, sembunyikan teks, disable tombol
    spinner.classList.remove('d-none');
    btnText.textContent = 'Menyimpan...';
    submitBtn.disabled = true;
  });
</script>
@endsection
