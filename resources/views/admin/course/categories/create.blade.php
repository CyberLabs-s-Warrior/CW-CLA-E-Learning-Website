@extends('templates.app')

@section('title', 'Tambah Data Course')

@section('content')
<div class="container-fluid py-4 animate-fade-in">

  {{-- Header --}}
  <div class="d-flex align-items-center mb-4 animate-slide-up">
    <div class="me-3">
      <div class="icon-circle-lg shadow" style="background: linear-gradient(135deg, #3949ab, #1e88e5);">
        <i class="fas fa-plus-circle fa-lg text-white"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-1">Tambah Data Course</h1>
      <p class="text-muted mb-0">Silakan pilih jenis data yang ingin ditambahkan</p>
    </div>
  </div>

  {{-- Card Pilihan --}}
  <div class="row">
    <div class="col-md-4 mb-4 animate-fade-up" style="animation-delay: 0.1s">
      <a href="{{ route('admin.course-categories.create.category') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale">
          <div class="icon-circle bg-primary text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-folder-plus fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-1">Tambah Kategori</h5>
          <p class="text-muted small mb-0">Buat kategori baru untuk course.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-4 animate-fade-up" style="animation-delay: 0.2s">
      <a href="{{ route('admin.course-levels.create') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale">
          <div class="icon-circle bg-success text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-layer-group fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-1">Tambah Level</h5>
          <p class="text-muted small mb-0">Tentukan level seperti Pemula, Menengah, atau Lanjutan.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-4 animate-fade-up" style="animation-delay: 0.3s">
      <a href="{{ route('admin.course-prices.create') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-shadow transition-scale">
          <div class="icon-circle bg-danger text-white mb-3 mx-auto animate-icon-bounce">
            <i class="fas fa-money-bill-wave fa-lg"></i>
          </div>
          <h5 class="fw-semibold mb-1">Tambah Rentang Harga</h5>
          <p class="text-muted small mb-0">Tentukan rentang harga seperti Rp1.000 – Rp10.000.</p>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .hover-shadow:hover {
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-4px);
    transition: all 0.3s ease-in-out;
  }

  .transition-scale {
    transition: transform 0.3s ease;
  }

  .transition-scale:hover {
    transform: scale(1.03);
  }

  .icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .icon-circle-lg {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3949ab, #1e88e5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  /* Animasi */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes bounceIcon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
  }

  .animate-fade-in { animation: fadeIn 0.5s ease-in-out both; }
  .animate-slide-up { animation: slideUp 0.6s ease-in-out both; }
  .animate-fade-up {
    opacity: 0;
    animation: fadeIn 0.6s ease-in-out forwards;
  }
  .animate-icon-bounce {
    animation: bounceIcon 1.2s infinite ease-in-out;
  }
</style>
@endsection
