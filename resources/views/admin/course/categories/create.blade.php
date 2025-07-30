@extends('templates.app')

@section('title', 'Tambah Data')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-plus"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Data</h1>
  </div>

  {{-- Tambah Kategori --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold text-primary border-bottom-0">
      <i class="fas fa-folder-tree me-2"></i>Tambah Kategori
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-categories.store') }}" class="d-flex flex-column gap-3">
        @csrf
        <input type="text" name="category" class="form-control shadow-sm" placeholder="Nama Kategori" required>
        <button type="submit" class="btn btn-primary rounded-pill w-auto align-self-start">
          <i class="fas fa-save me-1"></i> Simpan
        </button>
      </form>
    </div>
  </div>

  {{-- Tambah Level --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold text-success border-bottom-0">
      <i class="fas fa-signal me-2"></i>Tambah Level
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-categories.store') }}" class="d-flex flex-column gap-3">
        @csrf
        <input type="text" name="level" class="form-control shadow-sm" placeholder="Nama Level" required>
        <button type="submit" class="btn btn-success rounded-pill w-auto align-self-start">
          <i class="fas fa-save me-1"></i> Simpan
        </button>
      </form>
    </div>
  </div>

  {{-- Tambah Rentang Harga --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold text-danger border-bottom-0">
      <i class="fas fa-money-bill-wave me-2"></i>Tambah Rentang Harga
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-categories.store') }}" class="d-flex flex-column gap-3">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <input type="number" name="min_price" class="form-control shadow-sm" placeholder="Harga Minimum" required>
          </div>
          <div class="col-md-6">
            <input type="number" name="max_price" class="form-control shadow-sm" placeholder="Harga Maksimum" required>
          </div>
        </div>
        <button type="submit" class="btn btn-danger rounded-pill w-auto align-self-start mt-2">
          <i class="fas fa-save me-1"></i> Simpan
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
