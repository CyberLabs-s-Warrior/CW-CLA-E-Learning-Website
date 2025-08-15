@extends('templates.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="container-fluid py-4">
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

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="text-center mb-4">
        <h4 class="fw-semibold text-dark">{{ $detailCourse->course->name ?? 'Judul kursus tidak tersedia' }}</h4>
        <p class="text-muted mb-0" style="font-size: 0.95rem;">{!! $detailCourse->description !!}</p>
      </div>

      @if($detailCourse->media && is_array($detailCourse->media) && count($detailCourse->media))
        <div class="position-relative mb-4">
          <div class="d-flex gap-3 overflow-hidden px-2" id="media-container" style="scroll-behavior: smooth;">
            @foreach($detailCourse->media as $index => $file)
              @php
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              @endphp
              <div class="flex-shrink-0 bg-light rounded-3 shadow-sm p-2" style="width: 32%;">
                @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                  <img src="{{ asset('storage/' . $file) }}" alt="Media Gambar" class="img-fluid rounded-2 zoom-image" style="height: 180px; object-fit: cover; width: 100%; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('storage/' . $file) }}">
                @elseif(in_array($ext, ['mp4', 'mov', 'avi', 'webm']))
                  <video controls class="rounded-2" style="width: 100%; max-width: 720px; height: auto;">
                    <source src="{{ asset('storage/' . $file) }}" type="video/{{ $ext }}">
                    Browser tidak mendukung video ini.
                  </video>
                @else
                  <div class="alert alert-warning py-2 px-3 small rounded-2 text-center mb-0">
                    <i class="fas fa-exclamation-circle me-1"></i> Format media tidak dikenali
                  </div>
                @endif
              </div>
            @endforeach
          </div>

          @if(count($detailCourse->media) > 3)
            <button class="btn btn-outline-primary position-absolute top-50 start-0 translate-middle-y" style="z-index:10; width:40px; height:40px;" id="prev-btn">&lt;</button>
            <button class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle-y" style="z-index:10; width:40px; height:40px;" id="next-btn">&gt;</button>
          @endif
        </div>
      @endif

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

      <p class="text-muted small d-flex align-items-center mt-3">
        <i class="fas fa-calendar-alt me-2"></i>
        Dibuat pada: {{ \Carbon\Carbon::parse($detailCourse->created_at)->translatedFormat('d F Y - H:i') }}
      </p>

      <div class="text-end mt-4">
        <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
          <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body p-0">
        <img src="" id="modal-image" class="img-fluid rounded-3 w-100">
      </div>
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const mediaContainer = document.getElementById('media-container');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  if (mediaContainer && prevBtn && nextBtn) {
    const slideWidth = mediaContainer.children[0].offsetWidth + 12;
    let scrollPosition = 0;

    prevBtn.addEventListener('click', function() {
      scrollPosition -= slideWidth;
      if(scrollPosition < 0) scrollPosition = 0;
      mediaContainer.scrollTo({ left: scrollPosition, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', function() {
      scrollPosition += slideWidth;
      const maxScroll = mediaContainer.scrollWidth - mediaContainer.clientWidth;
      if(scrollPosition > maxScroll) scrollPosition = maxScroll;
      mediaContainer.scrollTo({ left: scrollPosition, behavior: 'smooth' });
    });
  }

  const zoomImages = document.querySelectorAll('.zoom-image');
  const modalImage = document.getElementById('modal-image');

  zoomImages.forEach(img => {
    img.addEventListener('click', function() {
      modalImage.src = this.dataset.src;
    });
  });
});
</script>
@endpush
