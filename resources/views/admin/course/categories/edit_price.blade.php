@extends('templates.app')

@section('title', 'Edit Rentang Harga')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-coins"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Rentang Harga</h1>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-danger border-bottom-0">
      <i class="fas fa-money-bill-wave me-2"></i>Form Edit Rentang Harga
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-prices.update', $price->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <input type="number" name="min_price" class="form-control shadow-sm" value="{{ $price->min_price }}" placeholder="Harga Minimum" required>
          </div>
          <div class="col-md-6">
            <input type="number" name="max_price" class="form-control shadow-sm" value="{{ $price->max_price }}" placeholder="Harga Maksimum" required>
          </div>
        </div>

        <button type="submit" class="btn btn-danger rounded-pill w-auto align-self-start mt-2">
          <i class="fas fa-save me-1"></i> Update
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
