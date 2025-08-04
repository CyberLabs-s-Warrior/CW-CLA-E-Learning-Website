@extends('templates.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-eye"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Detail Kursus</h1>
  </div>

  {{-- Content Card --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <h4 class="fw-semibold text-dark">{{ $detailCourse->title }}</h4>
      <p class="text-muted">{{ $detailCourse->description }}</p>

      {{-- Media --}}
      @if($detailCourse->media)
        <div class="mb-4">
          @php
              $ext = strtolower(pathinfo($detailCourse->media, PATHINFO_EXTENSION));
          @endphp

          @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
            <img src="{{ asset('storage/' . $detailCourse->media) }}" alt="Media Gambar" class="img-fluid rounded shadow-sm" style="max-width: 400px;">
          @elseif(in_array($ext, ['mp4', 'mov', 'avi']))
            <video controls class="rounded shadow-sm" style="width: 100%; max-width: 500px;">
              <source src="{{ asset('storage/' . $detailCourse->media) }}" type="video/{{ $ext }}">
              Browser tidak mendukung video ini.
            </video>
          @else
            <p class="text-muted">Format media tidak dikenali</p>
          @endif
        </div>
      @endif

      {{-- Modules --}}
      <h5 class="fw-semibold">Modul:</h5>
      <ul class="list-group list-group-flush mb-4">
        @forelse($detailCourse->modules as $modul)
          <li class="list-group-item">{{ $modul }}</li>
        @empty
          <li class="list-group-item text-muted">Belum ada modul.</li>
        @endforelse
      </ul>

      {{-- Created at --}}
      <div class="text-muted small mb-3">
        <i class="fas fa-calendar-alt me-1"></i> Dibuat pada: {{ \Carbon\Carbon::parse($detailCourse->created_at)->translatedFormat('d F Y H:i') }}
      </div>

      <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-secondary rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </div>
</div>
@endsection
