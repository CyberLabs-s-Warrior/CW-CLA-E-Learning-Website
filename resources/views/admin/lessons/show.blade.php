@extends('templates.app')

@section('title', 'Detail Materi')

@section('content')
  <div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
      <div class="me-3">
        <div class="bg-gradient-info text-blue rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 60px; height: 60px;">
          <i class="fas fa-book fa-2x"></i>
        </div>
      </div>
      <div>
        <h1 class="h3 fw-bold mb-1">{{ $lesson->title }}</h1>
        <small class="text-muted">Detail materi lengkap dengan modul dan urutan</small>
      </div>
    </div>

    {{-- Card Utama --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
      <div class="card-body">

        {{-- Info Lesson --}}
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Kursus:</strong> {{ $lesson->course->name ?? '-' }}</span>
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Modul:</strong> {{ $lesson->module_name }}
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Urutan:</strong> {{ $lesson->order }}
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Slug:</strong> {{ $lesson->slug }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Durasi:</strong> {{ $lesson->formatted_duration }}
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Preview:</strong>
              @if($lesson->is_preview)
                <span class="badge bg-success">Ya</span>
              @else
                <span class="badge bg-secondary">Tidak</span>
              @endif
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Dibuat:</strong> {{ $lesson->created_at->format('d M Y H:i') }}
            </div>
            <div class="p-3 bg-light rounded shadow-sm mb-2">
              <strong>Diperbarui:</strong> {{ $lesson->updated_at->format('d M Y H:i') }}
            </div>
          </div>
        </div>

        {{-- Konten --}}
        <div class="mb-4">
          <h5 class="fw-semibold mb-3">Konten Materi</h5>
          <div class="p-4 bg-white rounded shadow-sm" style="white-space: pre-line; font-size: 1rem; line-height: 1.6;">
            {!! $lesson->content !!}
          </div>
        </div>

        {{-- Media --}}
        @if($lesson->media)
          @php
            $ext = strtolower(pathinfo($lesson->media, PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
            $isVideo = in_array($ext, ['mp4', 'mov', 'avi']);
          @endphp
          <div class="mb-4 text-center">
            <h5 class="fw-semibold mb-3">Media</h5>
            @if($isImage)
              <img src="{{ asset('storage/' . $lesson->media) }}" alt="Media" class="img-fluid rounded shadow-sm hover-shadow"
                style="max-height: 200px; object-fit: contain; transition: transform .3s;">
            @elseif($isVideo)
              <video controls class="rounded" style="max-width: 520px; max-height: 320px;">
                <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $ext }}">
                Browser Anda tidak mendukung pemutaran video.
              </video>
            @else
              <a href="{{ asset('storage/' . $lesson->media) }}" target="_blank"
                class="btn btn-outline-info rounded-pill mt-2">
                <i class="fas fa-file-alt me-1"></i> Lihat Media
              </a>
            @endif
          </div>
        @endif

        {{-- List Lesson di Modul (horizontal scroll card) --}}
        <div class="mb-4">
          <h5 class="fw-semibold mb-3">Lesson di Modul "{{ $lesson->module_name }}"</h5>
          <div class="d-flex overflow-auto gap-3 pb-2">
            @foreach($lessonsInModule as $l)
              <a href="{{ route('admin.lessons.show', $l->id) }}"
                class="card flex-shrink-0 p-3 text-decoration-none shadow-sm rounded-3 @if($l->id == $lesson->id) border-primary border-3 @endif"
                style="min-width: 200px; transition: transform .2s;">
                <div class="fw-semibold">{{ $l->order }}. {{ $l->title }}</div>
                <small class="text-muted">{{ gmdate('H:i:s', $l->duration) }}</small>
              </a>
            @endforeach
          </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="text-start mt-3">
          <a href="{{ route('admin.lessons.index') }}"
            class="btn btn-outline-secondary rounded-pill px-4 shadow-sm hover-scale">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke daftar
          </a>
        </div>

      </div>
    </div>
  </div>

  {{-- Optional CSS tambahan untuk efek hover --}}
  @push('styles')
    <style>
      .hover-shadow:hover {
        transform: scale(1.03);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, .15) !important;
      }

      .hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
      }
    </style>
  @endpush

@endsection