@extends('templates.app')

@section('title', 'Detail Materi')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-3">
      <div class="bg-info bg-opacity-25 text-info rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px;">
        <i class="fas fa-info-circle fa-lg"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-0">Detail Materi</h1>
      <small class="text-muted">Informasi lengkap tentang materi ini</small>
    </div>
  </div>

  {{-- Card --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      {{-- Judul --}}
      <div class="text-center mb-4">
        <h4 class="fw-semibold text-dark">{{ $lesson->title }}</h4>
      </div>

      {{-- Kursus & Modul --}}
      <div class="mb-3">
        <p class="mb-1"><strong>Kursus:</strong> {{ $lesson->detailCourse->course->name ?? '-' }}</p>
        <p class="mb-1"><strong>Modul:</strong> {{ $lesson->module_name }}</p>
      </div>

      {{-- Konten --}}
      <div class="mb-4">
        <p class="mb-1"><strong>Konten:</strong></p>
        <div class="border rounded p-3 bg-light">
          {!! ($lesson->content) !!}
        </div>
      </div>

      {{-- Media --}}
      @if($lesson->media)
        @php
          $ext = pathinfo($lesson->media, PATHINFO_EXTENSION);
          $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
          $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi']);
        @endphp

        <div class="mb-4 text-center">
          <p class="fw-semibold mb-2">Media:</p>
          @if($isImage)
            <img src="{{ asset('storage/' . $lesson->media) }}" alt="Media" class="img-fluid rounded shadow-sm" style="max-width: 600px; max-height: 400px; object-fit: contain;">
          @elseif($isVideo)
            <video controls class="rounded shadow-sm" style="width: 100%; max-width: 720px; max-height: 420px;">
              <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $ext }}">
              Browser Anda tidak mendukung pemutaran video.
            </video>
          @else
            <a href="{{ asset('storage/' . $lesson->media) }}" target="_blank" class="btn btn-outline-info rounded-pill mt-2">
              <i class="fas fa-file-alt me-1"></i> Lihat Media
            </a>
          @endif
        </div>
      @else
        <div class="alert alert-secondary small">Tidak ada media.</div>
      @endif

      {{-- Created at --}}
      <p class="text-muted small d-flex align-items-center mt-3">
        <i class="fas fa-calendar-alt me-2"></i>
        Dibuat pada: {{ $lesson->created_at->translatedFormat('d F Y - H:i') }}
      </p>

      {{-- Back Button --}}
      <div class="text-end mt-4">
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
          <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
