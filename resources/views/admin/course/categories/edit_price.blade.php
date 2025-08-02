@extends('templates.app')

@section('title', 'Edit Rentang Harga')

@section('content')
<div class="container-fluid py-4">
  {{-- Heading --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
        <i class="fas fa-coins"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Rentang Harga</h1>
  </div>

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-danger border-bottom-0">
      <i class="fas fa-money-bill-wave me-2"></i>Form Edit Rentang Harga
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-prices.update', $price->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        {{-- Input Fields --}}
        <div class="row g-3">
          <div class="col-md-6">
            <label for="min_price" class="form-label fw-semibold">Harga Minimum</label>
            <input type="number" name="min_price" id="min_price"
                   class="form-control shadow-sm @error('min_price') is-invalid @enderror"
                   value="{{ old('min_price', $price->min_price) }}" placeholder="Masukkan harga minimum" required>
            @error('min_price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="max_price" class="form-label fw-semibold">Harga Maksimum</label>
            <input type="number" name="max_price" id="max_price"
                   class="form-control shadow-sm @error('max_price') is-invalid @enderror"
                   value="{{ old('max_price', $price->max_price) }}" placeholder="Masukkan harga maksimum" required>
            @error('max_price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 mt-3">
          <button type="submit" class="btn btn-danger rounded-pill px-4">
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
