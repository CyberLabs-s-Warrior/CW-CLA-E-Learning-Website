@extends('templates.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-3">
      <div class="bg-primary bg-opacity-25 text-primary rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px;">
        <i class="fas fa-eye fa-lg"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-0">Detail Kursus</h1>
      <small class="text-muted">Informasi lengkap tentang kursus ini</small>
    </div>
  </div>

  {{-- Content Card --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      {{-- Judul & Deskripsi --}}
      <div class="text-center mb-4">
        <h4 class="fw-semibold text-dark">{{ $detailCourse->title }}</h4>
        <p class="text-muted mb-0" style="font-size: 0.95rem;">{{ $detailCourse->description }}</p>
      </div>

      {{-- Media Centered --}}
      @if($detailCourse->media)
        @php
          $ext = strtolower(pathinfo($detailCourse->media, PATHINFO_EXTENSION));
        @endphp
        <div class="d-flex justify-content-center mb-4">
          @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
            <img src="{{ asset('storage/' . $detailCourse->media) }}" alt="Media Gambar" class="img-fluid rounded-3 shadow-sm" style="max-width: 600px;">
          @elseif(in_array($ext, ['mp4', 'mov', 'avi']))
            <video controls class="rounded-3 shadow-sm" style="width: 100%; max-width: 720px;">
              <source src="{{ asset('storage/' . $detailCourse->media) }}" type="video/{{ $ext }}">
              Browser tidak mendukung video ini.
            </video>
          @else
            <div class="alert alert-warning py-2 px-3 small rounded-3 text-center">
              <i class="fas fa-exclamation-circle me-1"></i> Format media tidak dikenali
            </div>
          @endif
        </div>
      @endif

      {{-- Modules --}}
      <div class="mb-4">
        <h5 class="fw-semibold mb-3">Modul:</h5>
        <ul class="list-group list-group-flush border rounded-3 shadow-sm">
          @forelse($detailCourse->modules as $modul)
            <li class="list-group-item">{{ $modul }}</li>
          @empty
            <li class="list-group-item text-muted fst-italic">Belum ada modul.</li>
          @endforelse
        </ul>
      </div>

      {{-- Created At --}}
      <p class="text-muted small d-flex align-items-center mt-3">
        <i class="fas fa-calendar-alt me-2"></i>
        Dibuat pada: {{ \Carbon\Carbon::parse($detailCourse->created_at)->translatedFormat('d F Y - H:i') }}
      </p>

      {{-- Back Button --}}
      <div class="text-end mt-4">
        <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
          <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
