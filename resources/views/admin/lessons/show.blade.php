@extends('templates.app')

@section('title', 'Detail Materi')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-info-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Detail Materi</h1>
  </div>

  {{-- Card Detail --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="mb-3">
        <h5 class="fw-bold">{{ $lesson->title }}</h5>
        <p class="mb-2"><strong>Kursus:</strong> {{ $lesson->course->title ?? '-' }}</p>
        <p class="mb-2"><strong>Modul:</strong> {{ $lesson->module_name }}</p>
        <p class="mb-2"><strong>Konten:</strong><br> {!! nl2br(e($lesson->content)) !!}</p>
        <p class="mb-2"><strong>Dibuat pada:</strong> {{ $lesson->created_at->translatedFormat('d F Y - H:i') }}</p>
      </div>

      {{-- Media --}}
      @if($lesson->media)
        @php
          $ext = pathinfo($lesson->media, PATHINFO_EXTENSION);
          $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
          $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi']);
        @endphp

        <div class="mb-3">
          <strong>Media:</strong><br>
          @if($isImage)
            <img src="{{ asset('storage/' . $lesson->media) }}" alt="Media" class="img-fluid rounded shadow-sm mt-2" style="max-height: 300px;">
          @elseif($isVideo)
            <video width="100%" height="auto" controls class="rounded shadow-sm mt-2">
              <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $ext }}">
              Browser Anda tidak mendukung pemutaran video.
            </video>
          @else
            <a href="{{ asset('storage/' . $lesson->media) }}" target="_blank" class="text-decoration-underline">Lihat Media</a>
          @endif
        </div>
      @else
        <p class="text-muted">Tidak ada media.</p>
      @endif

      <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary rounded-pill px-4 mt-3">
        <i class="fas fa-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </div>
</div>
@endsection
